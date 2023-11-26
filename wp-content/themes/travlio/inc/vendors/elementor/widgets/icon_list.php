<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Travlio_Elementor_Icon_List extends Widget_Base {

    public function get_name() {
        return 'apus_icon_list';
    }

    public function get_title() {
        return esc_html__( 'Apus Icon List', 'travlio' );
    }

    public function get_icon() {
        return 'eicon-bullet-list';
    }

    public function get_categories() {
        return [ 'travlio-elements' ];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'travlio' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'travlio' ),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'text',
            [
                'label' => esc_html__( 'Text', 'travlio' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__( 'List Item', 'travlio' ),
                'default' => esc_html__( 'List Item', 'travlio' ),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'social_icon',
            [
                'label' => esc_html__( 'Icon', 'travlio' ),
                'type' => Controls_Manager::ICON,
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

        $this->add_control(
            'social_icon_list',
            [
                'label' => esc_html__( 'Social Icons', 'travlio' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );
        
        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Style', 'travlio' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Normal', 'travlio'),
                ),
                'default' => ''
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

        $this->add_responsive_control(
            'alignment',
            [
                'label' => esc_html__( 'Alignment', 'travlio' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'travlio' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'travlio' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'travlio' ),
                        'icon' => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Justified', 'travlio' ),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .social' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title',
            [
                'label' => esc_html__( 'Title', 'travlio' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'travlio' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .widget-title ' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Title Typography', 'travlio' ),
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .widget-title',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__( 'List Items', 'travlio' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Typography', 'travlio' ),
                'name' => 'li_typography',
                'selector' => '{{WRAPPER}} li',
            ]
        );

        $this->start_controls_tabs(
            'style_tabs'
        );

            $this->start_controls_tab(
                'style_normal_tab',
                [
                    'label' => esc_html__( 'Normal', 'travlio' ),
                ]
            );

                $this->add_control(
                    'item_color',
                    [
                        'label' => esc_html__( 'Color', 'travlio' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            // Stronger selector to avoid section style from overwriting
                            '{{WRAPPER}} .icon-list-item a' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .icon-list-item' => 'color: {{VALUE}};',
                        ],
                    ]
                );

            $this->end_controls_tab();

            $this->start_controls_tab(
                'style_hover_tab',
                [
                    'label' => esc_html__( 'Hover', 'travlio' ),
                ]
            );

                $this->add_control(
                    'item_color_hv',
                    [
                        'label' => esc_html__( 'Hover Color Link', 'travlio' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            // Stronger selector to avoid section style from overwriting
                            '{{WRAPPER}} .icon-list-item a:hover' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .icon-list-item a:focus' => 'color: {{VALUE}};',
                        ],
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_icon_style',
            [
                'label' => esc_html__( 'Icon', 'travlio' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Icon Typography', 'travlio' ),
                'name' => 'icon_typography',
                'selector' => '{{WRAPPER}} i',
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__( 'Size', 'travlio' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 14,
                ],
                'range' => [
                    'px' => [
                        'min' => 6,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Color', 'travlio' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_hv_color',
            [
                'label' => esc_html__( 'Hover Color', 'travlio' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .icon-list-item li:hover i' => 'color: {{VALUE}};',
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

        <div class="widget-icon-list <?php echo esc_attr($el_class.' '.$style); ?>">

            <ul class="icon-list-item">
                <?php
                foreach ( $settings['social_icon_list'] as $index => $item ) {


                    $repeater_setting_key = $this->get_repeater_setting_key( 'text', 'social_icon_list', $index );

                    $this->add_render_attribute( $repeater_setting_key, 'class', 'elementor-icon-list-text' );

                    $this->add_inline_editing_attributes( $repeater_setting_key );


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
                        <?php if( $item['link']['url'] ){ ?>
                            <a <?php echo trim($this->get_render_attribute_string( $link_key )); ?>>
                        <?php } ?>
                            <div class="inner flex-middle">
                                <?php if( !empty( $item['social_icon']) ){ ?>
                                    <span class="inner-icon">
                                        <i class="<?php echo esc_attr( $item['social_icon'] ); ?>"></i>
                                    </span>
                                <?php } ?>
                                <span><?php echo esc_html($item['text']); ?></span>
                            </div>
                        <?php if( $item['link']['url'] ){ ?>
                            </a>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
        </div> 
        <?php 
    }
    
    protected function _content_template() {
        ?>
        <# var iconsHTML = {}; #>
        <div class="widget-icon-list">
            <ul class="icon-list-item">
                <# _.each( settings.social_icon_list, function( item, index ) {

                    #>
                    <li>
                        <# if ( item.link && item.link.url ) { #>
                            <a href="{{ item.link.url }}">
                        <# } #>

                            <span class="inner-icon"><i class="{{ item.social_icon }}" aria-hidden="true"></i></span>
                            <span>{{{ item.text }}}</span>

                        <# if ( item.link && item.link.url ) { #>
                            </a>
                        <# } #>
                    </li>
                <# } ); #>
            </ul>
        </div>
        <?php
    }
}
Plugin::instance()->widgets_manager->register_widget_type( new Travlio_Elementor_Icon_List );