<?php

//namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Travlio_Elementor_Search_Form extends Elementor\Widget_Base {

	public function get_name() {
        return 'apus_element_search_form';
    }

	public function get_title() {
        return esc_html__( 'Apus Header Search Form', 'travlio' );
    }
    
	public function get_categories() {
        return [ 'travlio-header-elements' ];
    }

	protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'travlio' ),
                'tab' => Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'travlio' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => esc_html__( 'Enter your title here', 'travlio' ),
            ]
        );

        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Style', 'travlio' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Style 1', 'travlio'),
                    'st_v2' => esc_html__('Style 2', 'travlio'),
                ),
                'default' => ''
            ]
        );

   		$this->add_control(
            'el_class',
            [
                'label'         => esc_html__( 'Extra class name', 'travlio' ),
                'type'          => Elementor\Controls_Manager::TEXT,
                'placeholder'   => esc_html__( 'If you wish to style particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'travlio' ),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_button_style',
            [
                'label' => esc_html__( 'Button', 'travlio' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'scheme' => Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .btn-search-icon',
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
                'color',
                [
                    'label' => esc_html__( 'Color', 'travlio' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .btn-search-icon' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'bg_color',
                [
                    'label' => esc_html__( 'Background Color', 'travlio' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .btn-search-icon' => 'background-color: {{VALUE}};',
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
                'hv_color',
                [
                    'label' => esc_html__( 'Hover Color', 'travlio' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .btn-search-icon:hover' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .btn-search-icon:focus' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'bg_hv_color',
                [
                    'label' => esc_html__( 'Hover Background Color', 'travlio' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .btn-search-icon:hover' => 'background-color: {{VALUE}};',
                        '{{WRAPPER}} .btn-search-icon:focus' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->add_control(
            'sh_hv_color',
            [
                'label' => esc_html__( 'Shadow Background Color', 'travlio' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-search-icon.st_v2::before' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'style' => 'st_v2',
                ],

            ]
        );

        $this->add_responsive_control(
            'icon_width',
            [
                'label' => esc_html__( 'Icon Width', 'travlio' ),
                'type' => Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .btn-search-icon' => 'width: {{SIZE}}{{UNIT}}; max-width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_height',
            [
                'label' => esc_html__( 'Icon Height', 'travlio' ),
                'type' => Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .btn-search-icon' => 'height: {{SIZE}}{{UNIT}}; max-height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

    }

	protected function render() {
        $settings = $this->get_settings();

        extract( $settings );
        ?>
        <div class="widget-search-header <?php echo esc_attr($el_class); ?>">
            <a href="javascript:void(0);" class="btn-search-icon <?php echo esc_attr($style); ?>"><i class="flaticon-loupe"></i></a>
            <div class="search-header-wrapper hidden">
                <div class="search-header-inner">
                    <?php if( !empty($title) ) { ?>
                        <h2 class="title text-center text-white" >
                           <?php echo trim( $title ); ?>
                        </h2>
                    <?php } ?>
                    <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
                        <div class="main-search input-group">
                            <span class="input-group-btn">
                                <button type="submit" class="btn"><i class="flaticon-loupe"></i></button>
                            </span>
                            <input type="text" placeholder="<?php esc_attr_e( 'Enter Your Search', 'travlio' ); ?>" name="s" class="apus-search form-control" autocomplete="off"/>
                        </div>
                        <input type="hidden" name="post_type" value="post">
                    </form>
                </div>
            </div>
        </div>
        <?php
    }
}

Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Travlio_Elementor_Search_Form );