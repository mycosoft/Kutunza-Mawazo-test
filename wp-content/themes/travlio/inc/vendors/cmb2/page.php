<?php

if ( !function_exists( 'travlio_page_metaboxes' ) ) {
	function travlio_page_metaboxes(array $metaboxes) {
		global $wp_registered_sidebars;
        $sidebars = array();

        if ( !empty($wp_registered_sidebars) ) {
            foreach ($wp_registered_sidebars as $sidebar) {
                $sidebars[$sidebar['id']] = $sidebar['name'];
            }
        }
        $headers = array_merge( array('global' => esc_html__( 'Global Setting', 'travlio' )), travlio_get_header_layouts() );
        $footers = array_merge( array('global' => esc_html__( 'Global Setting', 'travlio' )), travlio_get_footer_layouts() );

		$prefix = 'apus_page_';
	    $fields = array(
			array(
				'name' => esc_html__( 'Select Layout', 'travlio' ),
				'id'   => $prefix.'layout',
				'type' => 'select',
				'options' => array(
					'main' => esc_html__('Main Content Only', 'travlio'),
					'left-main' => esc_html__('Left Sidebar - Main Content', 'travlio'),
					'main-right' => esc_html__('Main Content - Right Sidebar', 'travlio')
				)
			),
			array(
                'id' => $prefix.'fullwidth',
                'type' => 'select',
                'name' => esc_html__('Is Full Width?', 'travlio'),
                'default' => 'no',
                'options' => array(
                    'no' => esc_html__('No', 'travlio'),
                    'yes' => esc_html__('Yes', 'travlio')
                )
            ),
            array(
                'id' => $prefix.'left_sidebar',
                'type' => 'select',
                'name' => esc_html__('Left Sidebar', 'travlio'),
                'options' => $sidebars
            ),
            array(
                'id' => $prefix.'right_sidebar',
                'type' => 'select',
                'name' => esc_html__('Right Sidebar', 'travlio'),
                'options' => $sidebars
            ),
            array(
                'id' => $prefix.'show_breadcrumb',
                'type' => 'select',
                'name' => esc_html__('Show Breadcrumb?', 'travlio'),
                'options' => array(
                    'no' => esc_html__('No', 'travlio'),
                    'yes' => esc_html__('Yes', 'travlio')
                ),
                'default' => 'yes',
            ),
            array(
                'id' => $prefix.'breadcrumb_color',
                'type' => 'colorpicker',
                'name' => esc_html__('Breadcrumb Background Color', 'travlio')
            ),
            array(
                'id' => $prefix.'breadcrumb_image',
                'type' => 'file',
                'name' => esc_html__('Breadcrumb Background Image', 'travlio')
            ),
            array(
                'id' => $prefix.'header_type',
                'type' => 'select',
                'name' => esc_html__('Header Layout Type', 'travlio'),
                'description' => esc_html__('Choose a header for your website.', 'travlio'),
                'options' => $headers,
                'default' => 'global'
            ),
            array(
                'id' => $prefix.'header_transparent',
                'type' => 'select',
                'name' => esc_html__('Header Transparent', 'travlio'),
                'description' => esc_html__('Choose a header for your website.', 'travlio'),
                'options' => array(
                    'no' => esc_html__('No', 'travlio'),
                    'yes' => esc_html__('Yes', 'travlio')
                ),
                'default' => 'global'
            ),
            array(
                'id' => $prefix.'header_position',
                'type' => 'select',
                'name' => esc_html__('Header Position', 'travlio'),
                'description' => esc_html__('Choose a header for your website.', 'travlio'),
                'options' => array(
                    '' => esc_html__('Default', 'travlio'),
                    'header_p_left' => esc_html__('Left', 'travlio'),
                    'header_p_right' => esc_html__('Right', 'travlio'),
                ),
                'default' => 'global'
            ),
            array(
                'id' => $prefix.'footer_type',
                'type' => 'select',
                'name' => esc_html__('Footer Layout Type', 'travlio'),
                'description' => esc_html__('Choose a footer for your website.', 'travlio'),
                'options' => $footers,
                'default' => 'global'
            ),
            array(
                'id' => $prefix.'extra_class',
                'type' => 'text',
                'name' => esc_html__('Extra Class', 'travlio'),
                'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'travlio')
            )
    	);
		
	    $metaboxes[$prefix . 'display_setting'] = array(
			'id'                        => $prefix . 'display_setting',
			'title'                     => esc_html__( 'Display Settings', 'travlio' ),
			'object_types'              => array( 'page' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'fields'                    => $fields
		);

	    return $metaboxes;
	}
}
add_filter( 'cmb2_meta_boxes', 'travlio_page_metaboxes' );

if ( !function_exists( 'travlio_cmb2_style' ) ) {
	function travlio_cmb2_style() {
		wp_enqueue_style( 'travlio-cmb2-style', get_template_directory_uri() . '/inc/vendors/cmb2/assets/style.css', array(), '1.0' );
	}
}
add_action( 'admin_enqueue_scripts', 'travlio_cmb2_style' );


