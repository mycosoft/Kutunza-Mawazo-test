<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Travlio_Elementor_Team extends Widget_Base {

    public function get_name() {
        return 'apus_element_team';
    }

    public function get_title() {
        return esc_html__( 'Apus Teams', 'travlio' );
    }

    public function get_icon() {
        return 'fa fa-users';
    }

    public function get_categories() {
        return [ 'travlio-elements' ];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Team', 'travlio' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'title', [
                'label' => esc_html__( 'Social Title', 'travlio' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Social Title' , 'travlio' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__( 'Link', 'travlio' ),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'default' => [
                    'is_external' => 'true',
                ],
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => esc_html__( 'https://your-link.com', 'travlio' ),
            ]
        );

        $repeater->add_control(
            'social_icon',
            [
                'label' => esc_html__( 'Icon', 'travlio' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'social',
                'label_block' => true,
                'default' => [
                    'value' => 'fab fa-facebook-f',
                    'library' => 'fa-brands',
                ],
                'recommended' => [
                    'fa-brands' => [
                        'android',
                        'apple',
                        'behance',
                        'bitbucket',
                        'codepen',
                        'delicious',
                        'deviantart',
                        'digg',
                        'dribbble',
                        'elementor',
                        'facebook',
                        'flickr',
                        'foursquare',
                        'free-code-camp',
                        'github',
                        'gitlab',
                        'globe',
                        'google-plus',
                        'houzz',
                        'instagram',
                        'jsfiddle',
                        'linkedin',
                        'medium',
                        'meetup',
                        'mixcloud',
                        'odnoklassniki',
                        'pinterest',
                        'product-hunt',
                        'reddit',
                        'shopping-cart',
                        'skype',
                        'slideshare',
                        'snapchat',
                        'soundcloud',
                        'spotify',
                        'stack-overflow',
                        'steam',
                        'stumbleupon',
                        'telegram',
                        'thumb-tack',
                        'tripadvisor',
                        'tumblr',
                        'twitch',
                        'twitter',
                        'viber',
                        'vimeo',
                        'vk',
                        'weibo',
                        'weixin',
                        'whatsapp',
                        'wordpress',
                        'xing',
                        'yelp',
                        'youtube',
                        '500px',
                    ],
                    'fa-solid' => [
                        'envelope',
                        'link',
                        'rss',
                    ],
                ],
            ]
        );  

        $this->add_control(
            'name', [
                'label' => esc_html__( 'Member Name', 'travlio' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Member Name' , 'travlio' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'property', [
                'label' => esc_html__( 'Member Job', 'travlio' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Member Job' , 'travlio' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'description', [
                'label' => esc_html__( 'Description', 'travlio' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => '',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'email', [
                'label' => esc_html__( 'Email', 'travlio' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'info@mywebsite.com' , 'travlio' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'phone', [
                'label' => esc_html__( 'Phone', 'travlio' ),
                'type' => Controls_Manager::TEXT,                
                'placeholder' => esc_html__( '0123456789', 'travlio' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'img_src',
            [
                'name' => 'image',
                'label' => esc_html__( 'Image', 'travlio' ),
                'type' => Controls_Manager::MEDIA,
                'placeholder'   => esc_html__( 'Upload Image Here', 'travlio' ),
            ]
        );

        $this->add_control(
            'social_icon_list',
            [
                'label' => esc_html__( 'Socials', 'travlio' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );
        

        $this->add_control(
            'el_class',
            [
                'label'         => esc_html__( 'Extra class name', 'travlio' ),
                'type'          => Controls_Manager::TEXT,
                'placeholder'   => esc_html__( 'If you wish to style particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'travlio' ),
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__( 'Title', 'travlio' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Background Hover Color', 'travlio' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Core\Schemes\Color::get_type(),
                    'value' => Core\Schemes\Color::COLOR_1,
                ],
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .social a:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {

        $settings = $this->get_settings();

        extract( $settings );
        $migration_allowed = Icons_Manager::is_migration_allowed();

        ?>
        <div class="widget widget-team <?php echo esc_attr($el_class); ?>">
            <div class="team-item">
                <div class="top-image">
                    <?php
                    if ( !empty($settings['img_src']['id']) ) {
                    ?>
                        <div class="team-image">
                            <?php echo travlio_get_attachment_thumbnail($settings['img_src']['id'], 'full'); ?>
                            <a class="team-popup-btn" href="javascript:void(0);">
                                <i class="ti-search"></i>
                            </a> 
                        </div>
                    <?php } ?>
                </div>

                <div class="content">
                    
                    <?php if ( !empty($name) ) { ?>
                        <h3 class="name-team"><?php echo esc_html($name); ?></h3>
                    <?php } ?>
                    <?php if ( !empty($property) ) { ?>
                        <div class="property"><?php echo esc_html($property); ?></div>
                    <?php } ?>

                    <?php if ( !empty($social_icon_list) ) { ?>
                        <ul class="social">
                            <?php
                            foreach ( $settings['social_icon_list'] as $index => $item ) {
                                $migrated = isset( $item['__fa4_migrated']['social_icon'] );
                                $is_new = empty( $item['social'] ) && $migration_allowed;
                                $social = '';

                                // add old default
                                if ( empty( $item['social'] ) && ! $migration_allowed ) {
                                    $item['social'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-wordpress';
                                }

                                if ( ! empty( $item['social'] ) ) {
                                    $social = str_replace( 'fa fa-', '', $item['social'] );
                                }

                                if ( ( $is_new || $migrated ) && 'svg' !== $item['social_icon']['library'] ) {
                                    $social = explode( ' ', $item['social_icon']['value'], 2 );
                                    if ( empty( $social[1] ) ) {
                                        $social = '';
                                    } else {
                                        $social = str_replace( 'fa-', '', $social[1] );
                                    }
                                }
                                if ( 'svg' === $item['social_icon']['library'] ) {
                                    $social = '';
                                }

                                $link_key = 'link_' . $index;

                                $this->add_render_attribute( $link_key, 'href', $item['link']['url'] );

                                if ( $item['link']['is_external'] ) {
                                    $this->add_render_attribute( $link_key, 'target', '_blank' );
                                }

                                if ( $item['link']['nofollow'] ) {
                                    $this->add_render_attribute( $link_key, 'rel', 'nofollow' );
                                }
                                ?>
                                <li>
                                    <a <?php echo trim($this->get_render_attribute_string( $link_key )); ?>>
                                        <?php
                                        if ( $is_new || $migrated ) {
                                            Icons_Manager::render_icon( $item['social_icon'] );
                                        } else { ?>
                                            <i class="<?php echo esc_attr( $item['social'] ); ?>"></i>
                                        <?php } ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </div>

                <div class="hidden team-popup-wrapper">
                    <div class="team-popup-inner">

                        <div class="row flex-middle-sm">
                            <?php
                                if ( !empty($settings['img_src']['id']) ) {
                            ?>
                                <div class="col-xs-12 col-sm-6">
                                    <div class="team-image">
                                        <?php echo travlio_get_attachment_thumbnail($settings['img_src']['id'], 'full'); ?>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="content col-xs-12 col-sm-6">
                                <?php if ( !empty($name) ) { ?>
                                    <h3 class="name-team"><?php echo esc_html($name); ?></h3>
                                <?php } ?>

                                <?php if ( !empty($property) ) { ?>
                                    <div class="property"><?php echo esc_html($property); ?></div>
                                <?php } ?>

                                <?php if ( !empty($description) ) { ?>
                                    <div class="description">                            
                                        <?php echo trim($description); ?>
                                    </div>
                                <?php } ?>

                                <div class="contact-info">
                                    <h3 class="title"><?php esc_html_e('Contact:', 'travlio'); ?></h3>
                                    <?php if ( !empty($email) ) { ?>
                                        <div class="email">                            
                                            <a href="mailto:<?php echo trim($email); ?>" target="_top"><?php echo trim($email); ?></a>
                                        </div>
                                    <?php } ?>

                                    <?php if ( !empty($phone) ) { ?>
                                        <div class="phone">
                                            <a href="tel:<?php echo trim($phone); ?>"><?php echo trim($phone); ?></a>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="social-info">
                                    <?php if ( !empty($social_icon_list) ) { ?>
                                        <h3 class="title"><?php esc_html_e('Social Account:', 'travlio'); ?></h3>
                                        <ul class="social list-inline">
                                            <?php
                                            foreach ( $settings['social_icon_list'] as $index => $item ) {
                                                $migrated = isset( $item['__fa4_migrated']['social_icon'] );
                                                $is_new = empty( $item['social'] ) && $migration_allowed;
                                                $social = '';

                                                // add old default
                                                if ( empty( $item['social'] ) && ! $migration_allowed ) {
                                                    $item['social'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-wordpress';
                                                }

                                                if ( ! empty( $item['social'] ) ) {
                                                    $social = str_replace( 'fa fa-', '', $item['social'] );
                                                }

                                                if ( ( $is_new || $migrated ) && 'svg' !== $item['social_icon']['library'] ) {
                                                    $social = explode( ' ', $item['social_icon']['value'], 2 );
                                                    if ( empty( $social[1] ) ) {
                                                        $social = '';
                                                    } else {
                                                        $social = str_replace( 'fa-', '', $social[1] );
                                                    }
                                                }
                                                if ( 'svg' === $item['social_icon']['library'] ) {
                                                    $social = '';
                                                }

                                                $link_key = 'link_' . $index;

                                                $this->add_render_attribute( $link_key, 'href', $item['link']['url'] );

                                                if ( $item['link']['is_external'] ) {
                                                    $this->add_render_attribute( $link_key, 'target', '_blank' );
                                                }

                                                if ( $item['link']['nofollow'] ) {
                                                    $this->add_render_attribute( $link_key, 'rel', 'nofollow' );
                                                }
                                                ?>
                                                <li>
                                                    <a <?php echo trim($this->get_render_attribute_string( $link_key )); ?>>
                                                        <?php
                                                        if ( $is_new || $migrated ) {
                                                            Icons_Manager::render_icon( $item['social_icon'] );
                                                        } else { ?>
                                                            <i class="<?php echo esc_attr( $item['social'] ); ?>"></i>
                                                        <?php } ?>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            
        </div>
        <?php
    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Travlio_Elementor_Team );