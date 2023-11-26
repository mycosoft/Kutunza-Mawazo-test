<?php

function travlio_wp_realestate_redux_config($sections, $sidebars, $columns) {
    
    $sections[] = array(
        'icon' => 'el el-pencil',
        'title' => esc_html__('Tours Settings', 'travlio'),
        'fields' => array(
            array(
                'id' => 'show_tour_breadcrumbs',
                'type' => 'switch',
                'title' => esc_html__('Breadcrumbs', 'travlio'),
                'default' => 1
            ),
            array(
                'title' => esc_html__('Breadcrumbs Background Color', 'travlio'),
                'subtitle' => '<em>'.esc_html__('The breadcrumbs background color of the site.', 'travlio').'</em>',
                'id' => 'tour_breadcrumb_color',
                'type' => 'color',
                'transparent' => false,
            ),
            array(
                'id' => 'tour_breadcrumb_image',
                'type' => 'media',
                'title' => esc_html__('Breadcrumbs Background', 'travlio'),
                'subtitle' => esc_html__('Upload a .jpg or .png image that will be your breadcrumbs.', 'travlio'),
            ),
            array(
                'id' => 'listing_general_hour_settings',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3> '.esc_html__('Other Settings', 'travlio').'</h3>',
            ),
            array(
                'id' => 'listing_enable_favorite',
                'type' => 'switch',
                'title' => esc_html__('Enable Favorite', 'travlio'),
                'default' => 1,
            ),
        )
    );
    // Archive Tours settings
    $sections[] = array(
        'subsection' => true,
        'title' => esc_html__('Search Page', 'travlio'),
        'fields' => array(
            array(
                'id' => 'tour_display_mode',
                'type' => 'select',
                'title' => esc_html__('Display Mode', 'travlio'),
                'options' => array(
                    'grid' => esc_html__('Grid - default', 'travlio'),
                    'grid-v2' => esc_html__('Grid - v2', 'travlio'),
                    'grid-v3' => esc_html__('Grid - v3', 'travlio'),
                    'grid-v4' => esc_html__('Grid - v4', 'travlio'),
                    'grid-v5' => esc_html__('Grid - v5', 'travlio'),
                    'list' => esc_html__('List', 'travlio'),
                ),
                'default' => 'grid'
            ),
            array(
                'id' => 'tour_columns',
                'type' => 'select',
                'title' => esc_html__('Grid Columns', 'travlio'),
                'options' => $columns,
                'default' => 3,
                'required' => array('tour_display_mode', '=', array('grid', 'grid-v2', 'grid-v3', 'grid-v4', 'grid-v5') ),
            )
        )
    );
    
    // Tour Page
    $sections[] = array(
        'title' => esc_html__('Single Tour', 'travlio'),
        'subsection' => true,
        'fields' => array(
            array(
                'id' => 'tour_single_layout',
                'type' => 'image_select',
                'compiler' => true,
                'title' => esc_html__('Archive Tour Layout', 'travlio'),
                'subtitle' => esc_html__('Select the variation you want to apply on your store.', 'travlio'),
                'options' => array(
                    'main' => array(
                        'title' => esc_html__('Main Only', 'travlio'),
                        'alt' => esc_html__('Main Only', 'travlio'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen1.png'
                    ),
                    'left-main' => array(
                        'title' => esc_html__('Left - Main Sidebar', 'travlio'),
                        'alt' => esc_html__('Left - Main Sidebar', 'travlio'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen2.png'
                    ),
                    'main-right' => array(
                        'title' => esc_html__('Main - Right Sidebar', 'travlio'),
                        'alt' => esc_html__('Main - Right Sidebar', 'travlio'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen3.png'
                    ),
                ),
                'default' => 'left-main'
            ),
            array(
                'id' => 'tour_single_fullwidth',
                'type' => 'switch',
                'title' => esc_html__('Is Full Width?', 'travlio'),
                'default' => false
            ),
            array(
                'id' => 'tour_single_left_sidebar',
                'type' => 'select',
                'title' => esc_html__('Single Tour Left Sidebar', 'travlio'),
                'subtitle' => esc_html__('Choose a sidebar for left sidebar.', 'travlio'),
                'options' => $sidebars
            ),
            array(
                'id' => 'tour_single_right_sidebar',
                'type' => 'select',
                'title' => esc_html__('Single Tour Right Sidebar', 'travlio'),
                'subtitle' => esc_html__('Choose a sidebar for right sidebar.', 'travlio'),
                'options' => $sidebars
            ),
            array(
                'id' => 'show_tour_social_share',
                'type' => 'switch',
                'title' => esc_html__('Show Social Share', 'travlio'),
                'default' => 1
            ),
        )
    );
    return $sections;
}
add_filter( 'travlio_redux_framwork_configs', 'travlio_wp_realestate_redux_config', 10, 3 );

