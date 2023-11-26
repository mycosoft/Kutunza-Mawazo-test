<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Travlio_Elementor_Booking_My_Favorite extends Elementor\Widget_Base {

    public function get_name() {
        return 'apus_element_booking_my_favorite';
    }

    public function get_title() {
        return esc_html__( 'Apus My Favorite', 'travlio' );
    }

    public function get_categories() {
        return [ 'travlio-elements' ];
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
            'el_class',
            [
                'label'         => esc_html__( 'Extra class name', 'travlio' ),
                'type'          => Elementor\Controls_Manager::TEXT,
                'placeholder'   => esc_html__( 'If you wish to style particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'travlio' ),
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings();

        extract( $settings );

        ?>

        <div class="widget no-margin widget-my-farovite <?php echo esc_attr($el_class); ?>">
            <?php if ( $title ) { ?>
                <h2 class="widget-title"><?php echo trim($title); ?></h2>
            <?php } ?>
            <?php
            if ( !is_user_logged_in() ) { ?>
                <div class="text-danger"><?php esc_html_e('Please login to view your farovite', 'travlio'); ?></div>
            <?php
            } else {
                $post_ids = Travlio_Favorite::get_favorite();
                $post_ids = (!empty($post_ids) && is_array($post_ids)) ? array_merge(array(0), $post_ids) : array(0);
                $args = array(
                    'post__in' => $post_ids
                );
                $posts = travlio_get_tours($args); ?>
            
                <div class="row">
                    <?php if ( !empty($posts) ) { 
                        foreach( $posts as $post ) {
                                setup_postdata( $GLOBALS['post'] =& $post );
                            ?>
                                <div class="col-xs-12 col-sm-6">
                                    <?php get_template_part( 'template-booking/loop/list-favorite' ); ?>
                                </div>
                            <?php }

                            wp_reset_postdata(); ?>

                    <?php } else { ?>
                        <div class="col-xs-12">
                            <div class="apus-farovite-note text-danger">
                                <?php esc_html_e( 'You have not added any listings to your farovite', 'travlio' ); ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>

            <?php } ?>

        </div>
        <?php
    }
}

Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Travlio_Elementor_Booking_My_Favorite );