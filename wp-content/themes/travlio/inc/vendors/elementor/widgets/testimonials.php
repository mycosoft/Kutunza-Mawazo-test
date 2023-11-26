<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Travlio_Elementor_Testimonials extends Widget_Base {

	public function get_name() {
        return 'apus_element_testimonials';
    }

	public function get_title() {
        return esc_html__( 'Apus Testimonials', 'travlio' );
    }

	public function get_icon() {
        return 'eicon-testimonial';
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

        $repeater = new Repeater();

        $repeater->add_control(
            'content', [
                'label' => esc_html__( 'Content', 'travlio' ),
                'type' => Controls_Manager::TEXTAREA
            ]
        );

        $repeater->add_control(
            'img_src',
            [
                'name' => 'image',
                'label' => esc_html__( 'Choose Image', 'travlio' ),
                'type' => Controls_Manager::MEDIA,
                'placeholder'   => esc_html__( 'Upload Brand Image', 'travlio' ),
            ]
        );
        $repeater->add_control(
            'name',
            [
                'label' => esc_html__( 'Name', 'travlio' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'John Doe',
            ]
        );

        $repeater->add_control(
            'job',
            [
                'label' => esc_html__( 'Job', 'travlio' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Leader',
            ]
        );

        $repeater->add_control(
            'star',
            [
                'label' => esc_html__( 'Star', 'travlio' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    1 => esc_html__('1 Star', 'travlio'),
                    2 => esc_html__('2 Star', 'travlio'),
                    3 => esc_html__('3 Star', 'travlio'),
                    4 => esc_html__('4 Star', 'travlio'),
                    5 => esc_html__('5 Star', 'travlio'),
                ),
                'default' => 1
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__( 'Link To', 'travlio' ),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__( 'Enter your social link here', 'travlio' ),
                'placeholder' => esc_html__( 'https://your-link.com', 'travlio' ),
            ]
        );

        $this->add_control(
            'testimonials',
            [
                'label' => esc_html__( 'Testimonials', 'travlio' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );


        $this->add_control(
            'columns',
            [
                'label' => esc_html__( 'Columns', 'travlio' ),
                'type' => Controls_Manager::NUMBER,
                'input_type' => 'number',
                'default' => 2
            ]
        );

        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Style', 'travlio' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Default', 'travlio'),
                    'style1' => esc_html__('Style1', 'travlio'),
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

        $this->end_controls_section();


        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__( 'Tyles', 'travlio' ),
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
                    '{{WRAPPER}} .widget-title' => 'color: {{VALUE}};',
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

        $this->add_control(
            'test_title_color',
            [
                'label' => esc_html__( 'Testimonial Title Color', 'travlio' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .name-client a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Testimonial Title Typography', 'travlio' ),
                'name' => 'test_title_typography',
                'selector' => '{{WRAPPER}} .name-client a',
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__( 'Content Color', 'travlio' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Content Typography', 'travlio' ),
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .description',
            ]
        );

        $this->add_control(
            'job_color',
            [
                'label' => esc_html__( 'Job Color', 'travlio' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .job' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Job Typography', 'travlio' ),
                'name' => 'job_typography',
                'selector' => '{{WRAPPER}} .job',
            ]
        );

        $this->end_controls_section();
    }

	protected function render() {

        $settings = $this->get_settings();

        extract( $settings );

        if ( !empty($testimonials) ) {
            ?>
            <div class="widget-testimonials <?php echo esc_attr($el_class.' '.$style); ?>">
                
                <?php if( 1 == 'style1') { ?>

                    <div class="slick-carousel testimonial-main" data-items="1" data-smallmedium="1" data-extrasmall="1" data-pagination="false" data-nav="false" data-asnavfor=".testimonial-thumbnail" data-slickparent="true">
                        <?php foreach ($testimonials as $item) { ?>
                            <?php $img_src = ( isset( $item['img_src']['id'] ) && $item['img_src']['id'] != 0 ) ? wp_get_attachment_url( $item['img_src']['id'] ) : ''; ?>
                            
                            <div class="item text-center">
                                <?php if ( !empty($item['content']) ) { ?>
                                    <div class="top-testimonial-des">
                                        <div class="description"><?php echo trim($item['content']); ?></div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="wrapper-testimonial-thumbnail">
                        <div class="slick-carousel testimonial-thumbnail" data-centerMode="true" data-items="3" data-smallmedium="3" data-extrasmall="1" data-pagination="false" data-nav="false" data-centerPadding="0px" data-asnavfor=".testimonial-main" data-slidestoscroll="1" data-focusonselect="true" data-infinite="true">
                            <?php foreach ($testimonials as $item) { ?>
                                <?php $img_src = ( isset( $item['img_src']['id'] ) && $item['img_src']['id'] != 0 ) ? wp_get_attachment_url( $item['img_src']['id'] ) : ''; ?>
                                <div class="item">
                                    <div class="info-testimonial-bottom flex-middle">
                                        <?php if ( $img_src ) { ?>
                                            <div class="wrapper-avarta">
                                                <div class="avarta flex-middle">
                                                    <img src="<?php echo esc_url($img_src); ?>" alt="<?php echo esc_attr(!empty($item['name']) ? $item['name'] : ''); ?>">
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="info-testimonials">
                                            <?php if ( !empty($item['name']) ) {

                                                $title = '<h3 class="name-client">'.$item['name'].'</h3>';
                                                if ( ! empty( $item['link']['url'] ) ) {
                                                    $title = sprintf( '<h3 class="name-client"><a href="'.esc_url($item['link']['url']).'" target="'.esc_attr($item['link']['is_external'] ? '_blank' : '_self').'" '.($item['link']['nofollow'] ? 'rel="nofollow"' : '').'>%1$s</a></h3>', $item['name'] );
                                                }
                                                echo trim($title);
                                            ?>
                                            <?php } ?>

                                            <?php if ( !empty($item['job']) ) { ?>
                                                <div class="job"><?php echo trim($item['job']); ?></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                <?php }else{ ?>
                    <div class="slick-carousel testimonial-main <?php echo esc_attr($columns < count($testimonials) ? '':'hidden-dots'); ?>" data-items="<?php echo esc_attr($columns); ?>" data-smallmedium="2" data-extrasmall="1" data-pagination="true" data-slidesToScroll="1" data-nav="false">
                        <?php foreach ($testimonials as $item) { ?>
                            <div class="item">
                                <div class="testimonials-item">
                                    
                                        <?php
                                        $img_src = ( isset( $item['img_src']['id'] ) && $item['img_src']['id'] != 0 ) ? wp_get_attachment_url( $item['img_src']['id'] ) : '';
                                        if ( $img_src ) {
                                        ?>
                                            <div class="avarta">
                                                <img src="<?php echo esc_url($img_src); ?>" alt="<?php echo esc_attr(!empty($item['name']) ? $item['name'] : ''); ?>">
                                            </div>
                                        <?php } ?>

                                        <div class="meta-inner">
                                            <?php if ( !empty($item['name']) ) {
                                                $title = '<h3 class="name-client">'.$item['name'].'</h3>';
                                                if ( ! empty( $item['link']['url'] ) ) {
                                                    $title = sprintf( '<h3 class="name-client"><a href="'.esc_url($item['link']['url']).'" target="'.esc_attr($item['link']['is_external'] ? '_blank' : '_self').'" '.($item['link']['nofollow'] ? 'rel="nofollow"' : '').'>%1$s</a></h3>', $item['name'] );
                                                }
                                                echo trim($title);
                                            ?>
                                            <?php } ?>
                                            <?php if ( !empty($item['job']) ) { ?>
                                                <div class="job"><?php echo trim($item['job']); ?></div>
                                            <?php } ?>
                                            <?php if ( !empty($item['star']) ) { ?>
                                                <div class="star">
                                                    <div class="star-inner" style="width:<?php echo esc_attr($item['star']*20); ?>%"></div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <?php if ( !empty($item['content']) ) { ?>
                                            <div class="description">
                                                <?php echo trim($item['content']); ?>
                                            </div>
                                        <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                <?php } ?>
            </div>
            <?php
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new Travlio_Elementor_Testimonials );