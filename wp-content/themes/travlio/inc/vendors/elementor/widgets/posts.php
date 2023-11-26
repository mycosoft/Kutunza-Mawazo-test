<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Travlio_Elementor_Posts extends Elementor\Widget_Base {

	public function get_name() {
        return 'apus_element_posts';
    }

	public function get_title() {
        return esc_html__( 'Apus Posts', 'travlio' );
    }
    
	public function get_categories() {
        return [ 'travlio-elements' ];
    }

	protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Posts', 'travlio' ),
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
            'number',
            [
                'label' => esc_html__( 'Number', 'travlio' ),
                'type' => Elementor\Controls_Manager::NUMBER,
                'input_type' => 'number',
                'description' => esc_html__( 'Number posts to display', 'travlio' ),
                'default' => 4
            ]
        );
        
        $this->add_control(
            'order_by',
            [
                'label' => esc_html__( 'Order by', 'travlio' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Default', 'travlio'),
                    'date' => esc_html__('Date', 'travlio'),
                    'ID' => esc_html__('ID', 'travlio'),
                    'author' => esc_html__('Author', 'travlio'),
                    'title' => esc_html__('Title', 'travlio'),
                    'modified' => esc_html__('Modified', 'travlio'),
                    'rand' => esc_html__('Random', 'travlio'),
                    'comment_count' => esc_html__('Comment count', 'travlio'),
                    'menu_order' => esc_html__('Menu order', 'travlio'),
                ),
                'default' => ''
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__( 'Sort order', 'travlio' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Default', 'travlio'),
                    'ASC' => esc_html__('Ascending', 'travlio'),
                    'DESC' => esc_html__('Descending', 'travlio'),
                ),
                'default' => ''
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => esc_html__( 'Columns', 'travlio' ),
                'type' => Elementor\Controls_Manager::NUMBER,
                'input_type' => 'number',
                'default' => 4,
                'condition' => [
                    'layout_type' => [ 'grid', 'carousel' ],
                ],
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label' => esc_html__( 'Layout', 'travlio' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'grid' => esc_html__('Grid', 'travlio'),
                    'list' => esc_html__('List', 'travlio'),
                    'carousel' => esc_html__('Carousel', 'travlio')
                ),
                'default' => 'grid'
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
                'default' => 'large',
                'separator' => 'none',
                'condition' => [
                    'layout_type' => [ 'grid', 'carousel' ],
                ],
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
            'section_title_style',
            [
                'label' => esc_html__( 'Title', 'travlio' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'travlio' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .widget-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Title Typography', 'travlio' ),
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .widget-title',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_item_style',
            [
                'label' => esc_html__( 'Item', 'travlio' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
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
                'name_color',
                [
                    'label' => esc_html__( 'Title Color', 'travlio' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        // Stronger selector to avoid section style from overwriting
                        '{{WRAPPER}} .entry-title a' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'date_color',
                [
                    'label' => esc_html__( 'Date Color', 'travlio' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        // Stronger selector to avoid section style from overwriting
                        '{{WRAPPER}} .date' => 'color: {{VALUE}};',
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
                'name_hv_color',
                [
                    'label' => esc_html__( 'Title Color', 'travlio' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        // Stronger selector to avoid section style from overwriting
                        '{{WRAPPER}} .entry-title a:hover' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .entry-title a:focus' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'date_hv_color',
                [
                    'label' => esc_html__( 'Date Color', 'travlio' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        // Stronger selector to avoid section style from overwriting
                        '{{WRAPPER}} .date:hover' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .date:focus' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

	protected function render() {

        $settings = $this->get_settings();

        extract( $settings );

        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => $number,
            'orderby' => $order_by,
            'order' => $order,
        );
        $loop = new WP_Query($args);
        if ( $loop->have_posts() ) {
            if ( $image_size == 'custom' ) {
                
                if ( $image_custom_dimension['width'] && $image_custom_dimension['height'] ) {
                    $thumbsize = $image_custom_dimension['width'].'x'.$image_custom_dimension['height'];
                } else {
                    $thumbsize = 'full';
                }
            } else {
                $thumbsize = $image_size;
            }
            set_query_var( 'thumbsize', $thumbsize );
            ?>
            <div class="widget-blogs  <?php echo esc_attr($layout_type); ?> <?php echo esc_attr($el_class); ?>">
                <?php if ( $title ) { ?>
                    <h2 class="widget-title"><?php echo trim($title); ?></h2>
                <?php } ?>
                <div class="widget-content">

                    <?php if ( $layout_type == 'carousel' ): ?>
                        <div class="slick-carousel <?php echo esc_attr($columns < $loop->post_count ? '':'hidden-dots'); ?>" data-items="<?php echo esc_attr($columns); ?>" data-smallmedium="2" data-extrasmall="1" data-pagination="true" data-nav="false">
                            <?php while ( $loop->have_posts() ): $loop->the_post(); ?>
                                <div class="item">
                                    <?php get_template_part( 'template-posts/loop/inner-grid'); ?>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php elseif($layout_type == 'grid'): ?>
                        <?php $bcol = 12/$columns; ?>
                        <div class="layout-blog style-grid">
                            <div class="row">
                                <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                                    <div class="col-md-<?php echo esc_attr($bcol); ?> col-sm-6 col-xs-12">
                                        <?php get_template_part( 'template-posts/loop/inner-grid' ); ?>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                            <?php get_template_part( 'template-posts/loop/inner-list-small' ); ?>
                        <?php endwhile; ?>
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            </div>
            <?php
        }

    }

}

Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Travlio_Elementor_Posts );