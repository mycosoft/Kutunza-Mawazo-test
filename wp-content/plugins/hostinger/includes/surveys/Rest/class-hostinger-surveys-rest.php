<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Hostinger_Surveys_Rest {
	private const SUBMIT_SURVEY = '/v3/wordpress/survey/store';
	private const CLIENT_SURVEY_ELIGIBILITY = '/v3/wordpress/survey/client-eligible';
	private const CLIENT_SURVEY_IDENTIFIER = 'customer_satisfaction_score';
	private const GET_SURVEY = '/v3/wordpress/survey/get';

	private Hostinger_Requests_Client $client;

	public function __construct( Hostinger_Requests_Client $client ) {
		$this->client = $client;
	}

	public function is_client_eligible(): bool {

		$response = $this->client->get( self::CLIENT_SURVEY_ELIGIBILITY, array(
			'identifier' => self::CLIENT_SURVEY_IDENTIFIER,
		) );

		$response_data = $this->decode_response( $response )['response_data']->data;

		if ( isset( $response_data ) && ! $response_data === true ) {
			return false;
		}

		return (bool) $this->get_result( $response );
	}

	public function get_survey_questions(): array {

		$response = $this->client->get( self::GET_SURVEY, array(
			'identifier' => self::CLIENT_SURVEY_IDENTIFIER,
		) );

		if( ! $this->get_result($response) ) {
			return array();
		}

		$response_data = $this->decode_response( $response )['response_data']->data;

		if ( isset( $response_data->questions ) && is_array( $response_data->questions ) ) {
			return $response_data->questions;
		}

		return array();
	}

	public function submit_survey_data( array $data, string $survey_type ): bool {
		$response = $this->client->post( self::SUBMIT_SURVEY, $data );
		return $this->get_result( $response );
	}

	/**
	 * @param array|WP_Error $response
	 *
	 * @return mixed
	 */
	public function get_result( $response ) {

		$response_code = $this->decode_response( $response )['response_code'];
		$response_body = $this->decode_response( $response )['response_body'];
		$response_data = $this->decode_response( $response )['response_data']->data;

		if ( is_wp_error( $response ) || $response_code !== 200 ) {
			error_log( 'Error: ' . $response_body );

			return false;
		}

		return $response_data;
	}

	/**
	 * @param array|WP_Error $response
	 *
	 * @return array
	 */
	public function decode_response( $response ): array {
		$response_body = wp_remote_retrieve_body( $response );
		$response_code = wp_remote_retrieve_response_code( $response );
		$response_data = json_decode( $response_body );

		return array(
			'response_code' => $response_code,
			'response_data' => $response_data,
			'response_body' => $response_body
		);
	}

}
