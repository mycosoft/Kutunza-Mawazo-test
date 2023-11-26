<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Travlio_Elementor_Booking_Tours extends Widget_Base {

    public function get_name() {
        return 'apus_element_booking_tours';
    }

    public function get_title() {
        return esc_html__( 'Apus Booking Tours', 'travlio' );
    }

    public function get_categories() {
        return [ 'travlio-elements' ];
    }

    protected function _register_controls() {
        $terms = get_terms(array(
            'taxonomy' => 'categories',
            'hide_empty' => false,
        ));
        $categories = ['' => esc_html__('All Booking Rules', 'travlio')];
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
            foreach ($terms as $term) {
                $categories[$term->term_id] = $term->name;
            }
        }

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Booking Tours', 'travlio' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $this->add_control(
            'limit',
            [
                'label' => esc_html__( 'Limit', 'travlio' ),
                'type' => Controls_Manager::TEXT,
                'input_type' => 'number',
                'default' => '3'
            ]
        );

        $this->add_control(
            'category',
            [
                'label' => esc_html__( 'Booking rule', 'travlio' ),
                'type' => Controls_Manager::SELECT,
                'options' => $categories,
                'default' => ''
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => esc_html__( 'Order by', 'travlio' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Default', 'travlio'),
                    'rating' => esc_html__('Rating', 'travlio'),
                    'price_from' => esc_html__('Price From', 'travlio'),
                    'post_title' => esc_html__('Title', 'travlio'),
                ),
                'default' => ''
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__( 'Sort order', 'travlio' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Default', 'travlio'),
                    'ASC' => esc_html__('Ascending', 'travlio'),
                    'DESC' => esc_html__('Descending', 'travlio'),
                ),
                'default' => ''
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
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
            'item_type',
            [
                'label' => esc_html__( 'Item Style', 'travlio' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'grid' => esc_html__('Grid 1', 'travlio'),
                    'grid-v2' => esc_html__('Grid 2', 'travlio'),
                    'grid-v3' => esc_html__('Grid 3', 'travlio'),
                    'grid-v4' => esc_html__('Grid 4', 'travlio'),
                    'grid-v5' => esc_html__('Grid 5', 'travlio'),
                    'list' => esc_html__('List', 'travlio'),
                ),
                'default' => 'grid'
            ]
        );


        $this->add_control(
            'layout_type',
            [
                'label' => esc_html__( 'Layout', 'travlio' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'grid' => esc_html__('Grid', 'travlio'),
                    'carousel' => esc_html__('Carousel', 'travlio'),
                ),
                'default' => 'grid'
            ]
        );

        $columns = range( 1, 12 );
        $columns = array_combine( $columns, $columns );

        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__( 'Columns', 'travlio' ),
                'type' => Controls_Manager::SELECT,
                'options' => $columns,
                'frontend_available' => true,
                'default' => 3,
            ]
        );

        $this->add_responsive_control(
            'slides_to_scroll',
            [
                'label' => esc_html__( 'Slides to Scroll', 'travlio' ),
                'type' => Controls_Manager::SELECT,
                'description' => esc_html__( 'Set how many slides are scrolled per swipe.', 'travlio' ),
                'options' => $columns,
                'condition' => [
                    'columns!' => '1',
                    'layout_type' => 'carousel',
                ],
                'frontend_available' => true,
                'default' => 1,
            ]
        );

        $this->add_control(
            'rows',
            [
                'label' => esc_html__( 'Rows', 'travlio' ),
                'type' => Controls_Manager::TEXT,
                'input_type' => 'number',
                'placeholder' => esc_html__( 'Enter your rows number here', 'travlio' ),
                'default' => 1,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'show_nav',
            [
                'label'         => esc_html__( 'Show Navigation', 'travlio' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Show', 'travlio' ),
                'label_off'     => esc_html__( 'Hide', 'travlio' ),
                'return_value'  => true,
                'default'       => true,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label'         => esc_html__( 'Show Pagination', 'travlio' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Show', 'travlio' ),
                'label_off'     => esc_html__( 'Hide', 'travlio' ),
                'return_value'  => true,
                'default'       => true,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'         => esc_html__( 'Autoplay', 'travlio' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Yes', 'travlio' ),
                'label_off'     => esc_html__( 'No', 'travlio' ),
                'return_value'  => true,
                'default'       => true,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'infinite_loop',
            [
                'label'         => esc_html__( 'Infinite Loop', 'travlio' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Yes', 'travlio' ),
                'label_off'     => esc_html__( 'No', 'travlio' ),
                'return_value'  => true,
                'default'       => true,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
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

    }

    protected function render() {
        $settings = $this->get_settings();

        extract( $settings );
        $args = [
            'posts_per_page' => $limit,
            'sort' => $orderby,
            'sort_by' => $order
        ];
        if ( $category ) {
            $args['categories'] = [$category];
        }

        $posts = travlio_get_tours($args);
        
        if ( !empty($posts) ) {
            
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

            $columns = !empty($columns) ? $columns : 3;
            $columns_tablet = !empty($columns_tablet) ? $columns_tablet : 2;
            $columns_mobile = !empty($columns_mobile) ? $columns_mobile : 1;
            
            $slides_to_scroll = !empty($slides_to_scroll) ? $slides_to_scroll : $columns;
            $slides_to_scroll_tablet = !empty($slides_to_scroll_tablet) ? $slides_to_scroll_tablet : $slides_to_scroll;
            $slides_to_scroll_mobile = !empty($slides_to_scroll_mobile) ? $slides_to_scroll_mobile : 1;
            ?>
            <div class="widget-booking-tours <?php echo esc_attr($el_class.' '.$layout_type.' '.$item_type); ?>">
                
                <div class="widget-content">
                    <?php if ( $layout_type == 'carousel' ): ?>
                        <div class="slick-carousel"
                            data-items="<?php echo esc_attr($columns); ?>"
                            data-smallmedium="<?php echo esc_attr( $columns_tablet ); ?>"
                            data-extrasmall="<?php echo esc_attr($columns_mobile); ?>"

                            data-slidestoscroll="<?php echo esc_attr($slides_to_scroll); ?>"
                            data-slidestoscroll_smallmedium="<?php echo esc_attr( $slides_to_scroll_tablet ); ?>"
                            data-slidestoscroll_extrasmall="<?php echo esc_attr($slides_to_scroll_mobile); ?>"

                            data-pagination="<?php echo esc_attr( $show_pagination ? 'true' : 'false' ); ?>" data-nav="<?php echo esc_attr( $show_nav ? 'true' : 'false' ); ?>" data-rows="<?php echo esc_attr( $rows ); ?>" data-infinite="<?php echo esc_attr( $infinite_loop ? 'true' : 'false' ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ? 'true' : 'false' ); ?>">
                            
                                <?php
                                foreach( $posts as $post ) {
                                    setup_postdata( $GLOBALS['post'] =& $post );
                                ?>
                                    <div class="item">
                                        <?php get_template_part( 'template-booking/loop/'.$item_type ); ?>
                                    </div>
                                <?php } ?>

                        </div>
                    <?php else: ?>
                        <?php
                            $mdcol = 12/$columns;
                            $smcol = 12/$columns_tablet;
                            $xscol = 12/$columns_mobile;
                        ?>
                        <div class="row">

                            <?php
                            $i = 1;
                            foreach( $posts as $post ) {
                                setup_postdata( $GLOBALS['post'] =& $post );

                                $classes = '';
                                if ( $i%$columns == 1 ) {
                                    $classes .= ' md-clearfix lg-clearfix';
                                }
                                if ( $i%$columns_tablet == 1 ) {
                                    $classes .= ' sm-clearfix';
                                }
                                if ( $i%$columns_mobile == 1 ) {
                                    $classes .= ' xs-clearfix';
                                }
                            ?>
                                <div class="col-md-<?php echo esc_attr($mdcol); ?> col-sm-<?php echo esc_attr($smcol); ?> col-xs-<?php echo esc_attr( $xscol ); ?> list-item <?php echo esc_attr($classes); ?>">
                                    <?php get_template_part( 'template-booking/loop/'.$item_type ); ?>
                                </div>
                            <?php $i++; } ?>

                        </div>
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            </div>
            <?php
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new Travlio_Elementor_Booking_Tours );