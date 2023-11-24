<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Hostinger_Surveys {
	private const CACHE_ONE_DAY = 86400;
	private const CACHE_ONE_HOUR = 3600;
	private const TIME_15_MINUTES = 900;
	private const CLIENT_SURVEY_IDENTIFIER = 'customer_satisfaction_score';
	private const CLIENT_WOO_COMPLETED_ACTIONS = 'woocommerce_task_list_tracked_completed_tasks';
	private const WOO_SURVEY_IDENTIFIER = 'wordpress_woocommerce_onboarding';
	private const AI_ONBOARDING_SURVEY_IDENTIFIER = 'wordpress_ai_onboarding';
	private const SURVEY_QUESTIONS_TRANSIENT = 'survey_questions_transient';
	private const SUBMITTED_SURVEY_TRANSIENT = 'submitted_survey_transient';
	private const IS_CLIENT_ELIGIBLE_TRANSIENT = 'client_eligibility_transient';
	private const LOCATION_SLUG = 'location';
	private const WOOCOMMERCE_PAGES = array(
		'/wp-admin/admin.php?page=wc-admin',
		'/wp-admin/edit.php?post_type=shop_order',
		'/wp-admin/admin.php?page=wc-admin&path=/customers',
		'/wp-admin/edit.php?post_type=shop_coupon&legacy_coupon_menu=1',
		'/wp-admin/admin.php?page=wc-admin&path=/marketing',
		'/wp-admin/admin.php?page=wc-reports',
		'/wp-admin/admin.php?page=wc-settings',
		'/wp-admin/admin.php?page=wc-status',
		'/wp-admin/admin.php?page=wc-admin&path=/extensions',
		'/wp-admin/edit.php?post_type=product',
		'/wp-admin/post-new.php?post_type=product',
		'/wp-admin/edit.php?post_type=product&page=product-reviews',
		'/wp-admin/edit.php?post_type=product&page=product_attributes',
		'/wp-admin/edit-tags.php?taxonomy=product_cat&post_type=product',
		'/wp-admin/edit-tags.php?taxonomy=product_tag&post_type=product',
		'/wp-admin/admin.php?page=wc-admin&path=/analytics/overview',
		'/wp-admin/admin.php?page=wc-admin'
	);

	private array $required_survey_items = array(
		array(
			'question_slug' => self::LOCATION_SLUG,
			'answer'        => 'wordpress_ai_plugin'
		)
	);
	private Hostinger_Config $config_handler;
	private Hostinger_Settings $settings;
	private Hostinger_Helper $helper;
	private Hostinger_Surveys_Questions $survey_questions;
	private Hostinger_Surveys_Rest $surveys_rest;

	public function __construct() {
		$this->settings         = new Hostinger_Settings();
		$this->helper           = new Hostinger_Helper();
		$this->config_handler   = new Hostinger_Config();
		$this->survey_questions = new Hostinger_Surveys_Questions();

		$client = new Hostinger_Requests_Client( $this->config_handler->get_config_value( 'base_rest_uri', HOSTINGER_REST_URI ), [
			Hostinger_Config::TOKEN_HEADER  => $this->helper::get_api_token(),
			Hostinger_Config::DOMAIN_HEADER => $this->helper->get_host_info()
		] );

		$this->surveys_rest     = new Hostinger_Surveys_Rest( $client );

	}

	public function is_woocommerce_admin_page(): bool {
		$current_uri = sanitize_text_field( $_SERVER['REQUEST_URI'] );

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return false;
		}

		if ( isset( $current_uri ) && strpos( $current_uri, '/wp-json/' ) !== false ) {
			return false;
		}

		if ( in_array( $current_uri, self::WOOCOMMERCE_PAGES ) ) {
			return true;
		}

		return false;

	}

	public function is_survey_enabled(): bool {
		$not_submitted                   = ! get_transient( self::SUBMITTED_SURVEY_TRANSIENT );
		$not_completed                   = ! $this->settings->get_setting( 'feedback_survey_completed' );
		$content_published               = $this->settings->get_setting( 'content_published' );
		$is_client_eligible              = $this->is_client_eligible();
		$is_ai_onboarding_survey_enabled = $this->is_ai_onboarding_survey_enabled();

		return $not_submitted && $not_completed && $content_published && $is_client_eligible && ! $is_ai_onboarding_survey_enabled;
	}

	public function is_woocommerce_survey_enabled(): bool {
		$not_submitted                 = ! get_transient( self::SUBMITTED_SURVEY_TRANSIENT );
		$not_completed                 = ! $this->settings->get_setting( 'woocommerce_survey_completed' );
		$survey_website_type           = $this->settings->get_setting( 'survey.website.type' );
		$is_woocommerce_admin          = $this->is_woocommerce_admin_page();
		$default_woocommerce_completed = $this->default_woocommerce_survey_completed();
		$is_client_eligible            = $this->is_client_eligible();

		return $not_submitted && $not_completed && $survey_website_type && $is_woocommerce_admin && $default_woocommerce_completed && $is_client_eligible;
	}

	private function is_time_elapsed( string $first_login_at, int $time_in_seconds ): bool {
		$current_time = time();
		$time_elapsed = $current_time - $time_in_seconds;

		return $time_elapsed >= $first_login_at;
	}

	public function is_ai_onboarding_survey_enabled(): bool {
		$first_login_at                  = strtotime( get_option( 'hostinger_first_login_at', false ) );
		$not_submitted                   = ! get_transient( self::SUBMITTED_SURVEY_TRANSIENT );
		$not_completed                   = ! $this->settings->get_setting( 'ai_onboarding_survey_completed' );
		$not_woocommerce_admin           = ! $this->is_woocommerce_admin_page();
		$is_client_eligible              = $this->is_client_eligible();
		$is_ai_onboarding_passed         = $this->settings->get_setting( 'ai_onboarding' );
		$is_woocommerce_survey_completed = $this->settings->get_setting( 'woocommerce_survey_completed' );

		if ( ! $is_ai_onboarding_passed ) {
			return false;
		}

		if ( $first_login_at && ! $this->is_time_elapsed( $first_login_at, self::TIME_15_MINUTES ) ) {
			return false;
		}

		return ( $not_submitted && $not_completed && $not_woocommerce_admin && $is_client_eligible ) ||
		       ( $not_submitted && $not_completed && ! $not_woocommerce_admin && $is_woocommerce_survey_completed && $is_client_eligible );
	}



	public function default_woocommerce_survey_completed(): bool {
		$completed_actions          = get_option( self::CLIENT_WOO_COMPLETED_ACTIONS, array() );
		$required_completed_actions = array( 'products', 'appearance', 'payments' );

		return empty( array_diff( $required_completed_actions, $completed_actions ) );
	}

	public function is_client_eligible(): bool {
		$cached_eligibility = get_transient( self::IS_CLIENT_ELIGIBLE_TRANSIENT );

		if ( ! empty( $cached_eligibility ) ) {
			return $cached_eligibility;
		}

		$is_eligible = $this->surveys_rest->is_client_eligible();

		set_transient( self::IS_CLIENT_ELIGIBLE_TRANSIENT, $is_eligible, self::CACHE_ONE_HOUR );

		return $is_eligible;
	}

	private function get_survey_questions(): array {
		$cached_questions = get_transient( self::SURVEY_QUESTIONS_TRANSIENT );

		if ( ! empty( $cached_questions ) ) {
			return $cached_questions;
		}

		$survey_questions = $this->surveys_rest->get_survey_questions();

		set_transient( self::SURVEY_QUESTIONS_TRANSIENT, $survey_questions, self::CACHE_ONE_DAY );

		return $survey_questions;

	}

	public function submit_survey_answers( array $answers, string $survey_type ): void {
		$required_survey_items = $this->get_required_survey_items( $survey_type );
		$data                  = array(
			'identifier' => self::CLIENT_SURVEY_IDENTIFIER,
			'answers'    => $required_survey_items,
		);

		$this->add_user_answers( $data, $answers );
		$success = $this->surveys_rest->submit_survey_data( $data, $survey_type );

		if ( $success ) {

				delete_transient( self::IS_CLIENT_ELIGIBLE_TRANSIENT );

				switch ( $survey_type ) {
					case 'woo_survey':
						$setting_key = 'woocommerce_survey_completed';
						break;

					case 'ai_onboarding_survey':
						$setting_key = 'ai_onboarding_survey_completed';
						break;

					default:
						$setting_key = 'feedback_survey_completed';
				}

				$this->settings->update_setting( $setting_key, true );
				set_transient( self::SUBMITTED_SURVEY_TRANSIENT, true, 1 * 60 ); //Transient expires after 1 hour
				wp_send_json( __( 'Survey completed', 'hostinger' ) );

		};

	}

	private function get_required_survey_items( string $survey_type ): array {
		switch ( $survey_type ) {
			case 'woo_survey':
				return array(
					array(
						'question_slug' => self::LOCATION_SLUG,
						'answer'        => self::WOO_SURVEY_IDENTIFIER,
					),
				);
				break;
			case 'ai_onboarding_survey':
				return array(
					array(
						'question_slug' => self::LOCATION_SLUG,
						'answer'        => self::AI_ONBOARDING_SURVEY_IDENTIFIER,
					),
				);
				break;
			default:
				return $this->required_survey_items;
		}
	}

	private function add_user_answers( array &$data, array $answers ): void {
		foreach ( $answers as $answer_slug => $answer ) {
			$data['answers'][] = [
				'question_slug' => $answer_slug,
				'answer'        => $answer,
			];
		}
	}

	public function get_wp_survey_questions(): array {
		$all_questions  = $this->get_survey_questions();
		$question_slugs = array( 'score', 'comment' );

		return $this->filter_questions_by_slug( $all_questions, $question_slugs );
	}

	private function filter_questions_by_slug( array $all_questions, $question_slugs ): array {
		$questions_with_required_rule = [];

		foreach ( $all_questions as $question ) {
			if ( isset( $question->slug ) && in_array( $question->slug, $question_slugs ) ) {
				$questions_with_required_rule[] = [
					'slug'  => $question->slug,
					'rules' => $question->rules
				];
			}
		}

		return $questions_with_required_rule;
	}

	private function is_survey_question_required( array $question ): bool {
		return isset( $question['rules'] ) && in_array( 'required', $question['rules'] );
	}

	public function generate_json( array $survey_questions, string $survey_type = 'ai_survey' ): string {
		$jsonStructure = [
			"pages"               => [],
			"showQuestionNumbers" => "off",
			"showTOC"             => false,
			"pageNextText"        => __( 'Next', 'hostinger' ),
			"pagePrevText"        => __( 'Previous', 'hostinger' ),
			"completeText"        => __( 'Submit', 'hostinger' ),
			"completedHtml"       => __( 'Thank you for completing the survey !', 'hostinger' ),
			"requiredText"        => '*',
		];

		foreach ( $survey_questions as $question ) {
			$title = '';
			switch ( $survey_type ) {
				case 'woo_survey':
					$title = $this->survey_questions->map_survey_questions( $question['slug'] )['woo_question'];
					break;

				case 'ai_onboarding_survey':
					$title = $this->survey_questions->map_survey_questions( $question['slug'] )['ai_question'];
					break;

				default:
					$title = $this->survey_questions->map_survey_questions( $question['slug'] )['question'];
					break;
			}

			$element = [
				"type"              => $this->survey_questions->map_survey_questions( $question['slug'] )['type'],
				"name"              => $question['slug'],
				"title"             => $title,
				"requiredErrorText" => __( 'Response required.', 'hostinger' ),
			];

			if ( $question['slug'] == 'comment' ) {
				$element['maxLength'] = 250;
			}

			if ( isset( $question['rules'] ) ) {

				$betweenRule = $this->get_between_rule_values( $question['rules'] );
				if ( $betweenRule ) {
					$element["rateMin"]            = $betweenRule[0];
					$element["rateMax"]            = $betweenRule[1];
					$element["minRateDescription"] = __( 'Poor', 'hostinger' );
					$element["maxRateDescription"] = __( 'Excellent', 'hostinger' );
				}

				if ( $this->is_survey_question_required( $question ) ) {
					$element["isRequired"] = true;
				}

			}

			$question_data = [
				"name"     => $question['slug'],
				"elements" => [ $element ]
			];

			$jsonStructure["pages"][] = $question_data;
		}

		return json_encode( $jsonStructure );
	}

	public function get_between_rule_values( array $rules ): array {
		foreach ( $rules as $rule ) {
			if ( strpos( $rule, 'between:' ) === 0 ) {
				$betweenValues = explode( ',', substr( $rule, 8 ) );
				if ( count( $betweenValues ) === 2 ) {
					return $betweenValues;
				}
			}
		}

		return [];
	}

	private function generate_survey_html( string $surveyClass ): string {
		ob_start();
		?>
		<div class="hts-survey-wrapper <?php echo $surveyClass; ?>">
			<div id="hostinger-feedback-survey"></div>
			<div id="hts-questionsLeft">
				<span id="hts-currentQuestion">1</span> <?php echo esc_html( __(
					'Question', 'hostinger' ) ); ?> <?php echo esc_html( __( 'of ', 'hostinger' ) ); ?>
				<span id="hts-allQuestions"></span>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}

	public function customer_csat_survey(): void {
		if ( ! did_action( 'customer_csat_survey' ) ) {
			$survey_html = $this->generate_survey_html( 'hts-woocommerce-csat' );
			echo $survey_html;
			do_action( 'customer_csat_survey' );
		}
	}

	public function customer_ai_csat_survey(): void {
		if ( ! did_action( 'customer_ai_csat_survey' ) ) {
			$survey_html = $this->generate_survey_html( 'hts-ai-onboarding-csat' );
			echo $survey_html;
			do_action( 'customer_ai_csat_survey' );
		}
	}

}
