<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Travlio_Elementor_Banner extends Widget_Base {

	public function get_name() {
        return 'apus_element_banner';
    }

	public function get_title() {
        return esc_html__( 'Apus Banner', 'travlio' );
    }
    
	public function get_categories() {
        return [ 'travlio-elements' ];
    }

	protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Banner', 'travlio' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'travlio' ),
                'type' => Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => esc_html__( 'Enter your title here', 'travlio' ),
            ]
        );

        $this->add_control(
            'line',
            [
                'label' => esc_html__( 'Decoration Line', 'travlio' ),
                'type' => Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => '',
                'condition' => [
                    'style' => 'style3',
                ],
            ]
        );

        $this->add_control(
            'sub_title',
            [
                'label' => esc_html__( 'Sub Title', 'travlio' ),
                'type' => Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => esc_html__( 'Enter your sub title here', 'travlio' ),
                'condition' => [
                    'style' => 'style2',
                ],
            ]
        );

        $this->add_control(
            'content',
            [
                'label' => esc_html__( 'Content', 'travlio' ),
                'type' => Controls_Manager::WYSIWYG,
                'placeholder' => esc_html__( 'Enter your content here', 'travlio' ),
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__( 'URL', 'travlio' ),
                'type' => Controls_Manager::TEXT,
                'input_type' => 'url',
                'placeholder' => esc_html__( 'Enter your Button Link here', 'travlio' ),
            ]
        );

        $this->add_control(
            'btn_text',
            [
                'label' => esc_html__( 'Button Text', 'travlio' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your button text here', 'travlio' ),
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
            'img_top_src',
            [
                'name' => 'image_top',
                'label' => esc_html__( 'Image Top', 'travlio' ),
                'type' => Controls_Manager::MEDIA,
                'placeholder'   => esc_html__( 'Upload Image Here', 'travlio' ),
                'condition' => [
                    'style' => 'style3',
                ],
            ]
        );

        $this->add_control(
            'img_top_position',
            [
                'label' => esc_html__( 'Position Image Top', 'travlio' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'st_left' => esc_html__('Left Top', 'travlio'),
                    'st_right' => esc_html__('Right Top', 'travlio'),
                    'st_left st_b' => esc_html__('Left Bottom', 'travlio'),
                    'st_right st_b' => esc_html__('Right Bottom', 'travlio'),
                ),
                'default' => 'st_left',
                'condition' => [
                    'style' => 'style3',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_align',
            [
                'label' => esc_html__( 'Content Alignment', 'travlio' ),
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
                    '{{WRAPPER}} .inner' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Style', 'travlio' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'style1' => esc_html__('Style 1', 'travlio'),
                    'style2' => esc_html__('Style 2', 'travlio'),
                    'style3' => esc_html__('Style 3', 'travlio'),
                ),
                'default' => 'style1'
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
            'section_box_style',
            [
                'label' => esc_html__( 'Style', 'travlio' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'box_height',
            [
                'label' => esc_html__( 'Height', 'travlio' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .widget-banner' => 'height: {{SIZE}}{{UNIT}}; max-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'background_overlay',
                'label' => esc_html__( 'Background', 'travlio' ),
                'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .banner-image:before',
            ]
        );

        $this->add_control(
            'background_overlay_opacity',
            [
                'label' => esc_html__( 'Opacity', 'travlio' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => .5,
                ],
                'range' => [
                    'px' => [
                        'max' => 1,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .banner-image:before' => 'opacity: {{SIZE}};',
                ],
                'condition' => [
                    'background_overlay_background' => [ 'classic', 'gradient' ],
                ],
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
                'label' => esc_html__( 'Color', 'travlio' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Core\Schemes\Color::get_type(),
                    'value' => Core\Schemes\Color::COLOR_1,
                ],
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .title' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography_title',
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .title',
            ]
        );

        $this->add_control(
            'line_color',
            [
                'label' => esc_html__( 'Line Color', 'travlio' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Core\Schemes\Color::get_type(),
                    'value' => Core\Schemes\Color::COLOR_1,
                ],
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .line:before' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'style' => 'style3',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_subtitle_style',
            [
                'label' => esc_html__( 'Sub Title', 'travlio' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'subtitle_color',
            [
                'label' => esc_html__( 'Color', 'travlio' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Core\Schemes\Color::get_type(),
                    'value' => Core\Schemes\Color::COLOR_1,
                ],
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography_subtitle',
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .subtitle',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_style',
            [
                'label' => esc_html__( 'Content', 'travlio' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__( 'Padding', 'travlio' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .inner-banner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__( 'Color', 'travlio' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Core\Schemes\Color::get_type(),
                    'value' => Core\Schemes\Color::COLOR_1,
                ],
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .banner-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography_content',
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .banner-content',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_button_style',
            [
                'label' => esc_html__( 'Button', 'travlio' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => esc_html__( 'Color', 'travlio' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Core\Schemes\Color::get_type(),
                    'value' => Core\Schemes\Color::COLOR_1,
                ],
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .more-banner' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'button_line_color',
            [
                'label' => esc_html__( 'Line Color', 'travlio' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Core\Schemes\Color::get_type(),
                    'value' => Core\Schemes\Color::COLOR_1,
                ],
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .more-banner:before' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography_button',
                'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .more-banner',
            ]
        );

        $this->end_controls_section();

    }

	protected function render() {

        $settings = $this->get_settings();

        extract( $settings );

        ?>
        <div class="widget-banner <?php echo esc_attr($el_class.' '.$style); ?>">
            <?php
            if ( !empty($img_src['id']) ) {
            ?>

                <?php if(!empty($link)){ ?>    
                    <a href="<?php echo esc_url($link); ?>" class="banner-image">  
                        <?php echo travlio_get_attachment_thumbnail($img_src['id'], 'full'); ?>
                    </a>     
                <?php }else{ ?>
                    <div class="banner-image">
                        <?php echo travlio_get_attachment_thumbnail($img_src['id'], 'full'); ?>
                    </div>
                <?php } ?>

            <?php } ?>

            <?php
            if ( !empty($img_top_src['id']) ) {
            ?>
                <div class="banner-image-top <?php echo esc_attr($img_top_position); ?>">                    
                    <?php echo travlio_get_attachment_thumbnail($img_top_src['id'], 'full'); ?>
                </div>
            <?php } ?>

            <?php if( !empty($content) || !empty($btn_text) || !empty($title) ){ ?>
                <div class="inner-banner <?php echo esc_attr( (!empty($img_src['id']))?'p-ab ':'' ); ?><?php echo esc_attr($style); ?>">
                    
                    <?php if(!empty($sub_title)) { ?>
                        <div class="subtitle" >
                           <?php echo trim( $sub_title ); ?>
                        </div>
                    <?php } ?>

                    <?php if( !empty($title) && !empty($link) ) { ?>
                        <h3 class="title">
                            <a href="<?php echo esc_url($link); ?>">
                               <?php echo trim( $title ); ?>
                               <?php if ( !empty($line) ) { ?>
                                    <br><div class="line"><?php echo trim( $line ); ?></div>
                                <?php } ?>
                            </a>
                        </h3>
                    <?php } elseif(!empty($title)) { ?>
                        <h3 class="title" >
                           <?php echo trim( $title ); ?>
                           <?php if ( !empty($line) ) { ?>
                                <br><div class="line"><?php echo trim( $line ); ?></div>
                            <?php } ?>
                        </h3>
                    <?php } ?>
                    
                    <?php if ( !empty($content) ) { ?>
                        <div class="banner-content">
                            <?php echo trim($content); ?>
                        </div>
                    <?php } ?>

                    <?php if ( !empty($btn_text) ) { ?>
                        <div class="more-bottom">
                            <a class="text-underline more-banner" href="<?php echo esc_url($link); ?>" ><?php echo trim($btn_text); ?></a>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
        <?php
    }
}
Plugin::instance()->widgets_manager->register_widget_type( new Travlio_Elementor_Banner );