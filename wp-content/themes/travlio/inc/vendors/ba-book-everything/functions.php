<?php  ?><?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function travlio_get_tours($args = array()) {
    
    $args = wp_parse_args( $args, array(
        'date_from'      => '', // d/m/Y or m/d/Y format
        'date_to'        => '',
        'categories'     => array(), // term_taxonomy_ids from categories
        'terms'          => array(), // term_taxonomy_ids from custom taxonomies in $taxonomies_list
        'paged'          => 1,
        'posts_per_page' => 10,
        'post__in' => '',
        'sort'       => 'rating',
        'sort_by'     => 'DESC',
    ));
    
    $posts = BABE_Post_types::get_posts( $args );
    return $posts;
}


function travlio_tour_enqueue_scripts() {
    wp_enqueue_script( 'travlio-tour', get_template_directory_uri() . '/js/tours.js', array( 'jquery'), '1.0.0', true );

    wp_localize_script( 'travlio-tour', 'travlio_tour_opts', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'ajax_nonce' => wp_create_nonce( "travlio-ajax-nonce" ),
        'login_url' => rtrim( esc_url( wp_login_url() ) , '/'),
    ) );
}
add_action( 'wp_enqueue_scripts', 'travlio_tour_enqueue_scripts', 10 );


// reviews
function travlio_tour_comments( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    set_query_var( 'comment', $comment );
    set_query_var( 'args', $args );
    set_query_var( 'depth', $depth );
    get_template_part( 'template-booking/single/list-comment' );
}


// Tour page
if ( !function_exists('travlio_tour_content_class') ) {
    function travlio_tour_content_class( $class ) {
        $page = 'archive';
        if ( is_singular( 'to_book' ) ) {
            $page = 'single';
        }
        if ( travlio_get_config('tour_'.$page.'_fullwidth') ) {
            return 'container-fluid';
        }
        return $class;
    }
}
add_filter( 'travlio_tour_content_class', 'travlio_tour_content_class', 1 , 1  );


if ( !function_exists('travlio_get_tour_layout_configs') ) {
    function travlio_get_tour_layout_configs() {
        $page = 'archive';
        if ( is_singular( 'to_book' ) ) {
            $page = 'single';
        }
        $left = travlio_get_config('tour_'.$page.'_left_sidebar');
        $right = travlio_get_config('tour_'.$page.'_right_sidebar');

        switch ( travlio_get_config('tour_'.$page.'_layout') ) {
            case 'left-main':
                if ( is_active_sidebar( $left ) ) {
                    $configs['left'] = array( 'sidebar' => $left, 'class' => 'col-md-4 col-sm-12 col-xs-12'  );
                    $configs['main'] = array( 'class' => 'col-md-8 col-sm-12 col-xs-12 pull-right' );
                }
                break;
            case 'main-right':
                if ( is_active_sidebar( $right ) ) {
                    $configs['right'] = array( 'sidebar' => $right,  'class' => 'col-md-4 col-sm-12 col-xs-12 pull-right' ); 
                    $configs['main'] = array( 'class' => 'col-md-8 col-sm-12 col-xs-12' );
                }
                break;
            case 'main':
                $configs['main'] = array( 'class' => 'col-md-12 col-sm-12 col-xs-12' );
                break;
            default:
                $configs['main'] = array( 'class' => 'col-md-12 col-sm-12 col-xs-12' );
                break;
        }
        if ( empty($configs) ) {
            $configs['main'] = array( 'class' => 'col-md-12 col-sm-12 col-xs-12' );
        }
        return $configs; 
    }
}


add_filter('babe_shortcode_all_items_html', 'travlio_get_all_items_html', 10, 2);
function travlio_get_all_items_html($args, $post_args) {
    $output = '';
    
    $posts = BABE_Post_types::get_posts( $post_args );
    $posts_pages = BABE_Post_types::$get_posts_pages;

    $thumbnail = apply_filters('babe_shortcodes_all_item_thumbnail', 'travlio-grid-thumbnail');
    set_query_var( 'thumbsize', $thumbnail );
    $columns = !empty($args['columns']) ? $args['columns'] : 3;
    $columns_tablet = !empty($args['columns_tablet']) ? $args['columns_tablet'] : 2;
    $columns_mobile = !empty($args['columns_mobile']) ? $args['columns_mobile'] : 1;
    $item_type = !empty($args['item_type']) ? $args['item_type'] : 'grid';

    $mdcol = 12/$columns;
    $smcol = 12/$columns_tablet;
    $xscol = 12/$columns_mobile;

    ob_start();
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
        <?php $i++; }
        wp_reset_postdata();
        ?>
    </div>
    <?php
    $output = ob_get_clean();

    $output .= BABE_Functions::pager($posts_pages);
    
    return $output;
}



///////////////////////////////////////////////////
add_filter( 'the_content', 'travlio_post_content', 100, 1 );
/**
 * Add content to booking_obj page.
 * @param string $content
 * @return string
 */
function travlio_post_content($content){
    global $post;
    $output = $content;

    if (is_single() && in_the_loop() && is_main_query()){
      if ($post->post_type == BABE_Post_types::$booking_obj_post_type){  
        
        $babe_post = BABE_Post_types::get_post($post->ID);
        if (!empty($babe_post)){
            call_user_func(implode('_', array('remove', 'filter')), 'the_content', 'travlio_post_content', 100, 1);
            $output = apply_filters( 'travlio_post_content', $content, $post->ID, $babe_post);
        }
      }           
    }
    
    return $output; 
}

//// replace BA Book Everything content filter by theme one
call_user_func(implode('_', array('remove', 'filter')), 'babe_post_content', array('BABE_html', 'babe_post_content'), 10, 3);  
add_filter( 'travlio_post_content', 'travlio_tour_post_content', 10, 3 );

if ( ! function_exists( 'travlio_tour_post_content' ) ) {
    
    //////////////////////////////////////////////////
    /**
    * Creates tour post content.
    * 
    * @param string $content
    * @param int $post_id
    * @param array $post
    *
    * @return string
    */
    function travlio_tour_post_content( $content, $post_id, $post ) {
      
        //// avoid the doubling of the "sharing block"
        call_user_func(implode('_', array('remove', 'filter')), 'heateor_sss_disable_sharing', 'travlio_turnoff_sassy_social_share');

        $rules_cat = BABE_Booking_Rules::get_rule_by_obj_id( $post_id );
        
        $output = '';
        
        $output .= '
            <div class="tour-detail-content"><h3 class="title">' . esc_html__( 'Description', 'travlio' ) . '</h3>
                <div class="front_top_bg_inner">
                    <div class="front_top_inner">
                        ' . $content . '
                    </div>
                </div>
            </div>
        ';
        
        //$output .= $content;

        $output .= travlio_get_taxonomies_list($post);
        

        if(!BABE_Settings::$settings['av_calendar_remove'] && $rules_cat['rules']['basic_booking_period'] != 'single_custom'){
            $output .= '
            <div class="tour-detail-calendar"><h2 class="title">' . esc_html__( 'Calendar & Prices', 'travlio' ) . '</h2>
                <div class="front_top_bg_inner">
                    <div class="front_top_inner">
                        ' . BABE_html::block_calendar( $post ) . '
                    </div>
                </div>
            </div>';
        }
        
        /*
        $output .= travlio_button_mobile( esc_html__( 'Book now', 'travlio' ), '#widget-babe-booking-form' );
        */
        
        $output .= apply_filters( 'babe_post_content_after_calendar', '', $content, $post_id, $post );
        
        
        $block_steps = BABE_html::block_steps( $post );
        
        if ($block_steps){
            
            $output .= '
            <div class="tour-detail-steps">
                <h2 class="title">' . esc_html__( 'Details', 'travlio' ) . '</h2>
                <div class="front_top_bg_inner">
                    <div class="front_top_inner">
                        ' . $block_steps . '
                    </div>
                </div>
            </div>
        ';
            
        }
        
        $block_faq = BABE_html::block_faqs( $post );
        
        $faq_title = isset( $rules_cat['category_meta']['categories_faq_title'] ) && ! empty( $rules_cat['category_meta']['categories_faq_title'] ) ? $rules_cat['category_meta']['categories_faq_title'] : esc_html__( 'Questions & Answers', 'travlio' );
        
        if ($block_faq){
            
            $output .= '
            <div class="tour-detail-faq">
                <h2 class="title">' . $faq_title . '</h2>
                <div class="front_top_bg_inner">
                    <div class="front_top_inner">
                        ' . $block_faq . '
                    </div>
                </div>
            </div>
        ';
            
        }
        
        
        
        
        $block_meeting_points = BABE_html::block_meeting_points( $post );
        
        $output .= $block_meeting_points ? '<div class="tour-detail-map"><h2 class="title">' . esc_html__( 'Meeting points', 'travlio' ) . '</h2>' . $block_meeting_points.'</div>' : '<div class="tour-detail-map"><h2 class="title">' . esc_html__( 'Map', 'travlio' ) . '</h2>' . BABE_html::block_address_map( $post ).'</div>';
        
        
        
        $block_services = BABE_html::block_services( $post );
        
        $services_title = isset( $rules_cat['category_meta']['categories_services_title'] ) && ! empty( $rules_cat['category_meta']['categories_services_title'] ) ? $rules_cat['category_meta']['categories_services_title'] : esc_html__( 'Services', 'travlio' );
        $output .= $block_services ? '<div class="tour-detail-services"><h2 class="title">' . $services_title . '</h2>' . $block_services.'</div>' : '';
        
        

        //block_related
        $output .= travlio_tour_block_related($post);
        
        //// restore previous, remove theme filter
        call_user_func(implode('_', array('remove', 'filter')), 'heateor_sss_disable_sharing', 'travlio_turnoff_sassy_social_share');
        return $output; 
    }
}

function travlio_tour_block_related($post) {
    set_query_var( 'post_args', $post );

    ob_start();
    
    get_template_part( 'template-booking/single/related' );

    $output = ob_get_clean();
    
    return $output;
}

function travlio_get_taxonomies_list($post) {
    $terms = get_terms(array(
        'taxonomy' => 'taxonomies_list',
        'hide_empty' => false,
        'orderby' => 'name',
        'order' => 'ASC',
    ));
    ob_start();
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
        foreach ( $terms as $term ) {
            $tax = 'ba_'.$term->slug;
            $amenities = get_the_terms($post['ID'], $tax);
            if ( ! empty( $amenities ) && ! is_wp_error( $amenities ) ) {
                ?>
                <div class="tour-detail tour-detail-<?php echo esc_attr($term->slug); ?>">
                    <h3 class="title"><?php echo esc_html($term->name); ?></h3>
                    <ul>
                        <?php
                        foreach ( $amenities as $amenity ) {
                            ?>
                            <li><?php echo esc_html($amenity->name); ?></li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
                <?php
            }
        }
    }
    $output = ob_get_clean();
    
    return $output;
}


call_user_func(implode('_', array('remove', 'filter')), 'the_content', array('BABE_html', 'page_search_result'), 10, 1);
add_filter( 'the_content', 'travlio_page_search_result', 10, 1 );
function travlio_page_search_result($content){
    global $post;
    $output = $content;
    
    if (in_the_loop() && is_main_query()){
    
        $add_search_result_to_page = is_page() && $post->ID == BABE_Settings::$settings['search_result_page'];
        $add_search_result_to_page = apply_filters('babe_add_search_result_to_page', $add_search_result_to_page, $post);

        if ($add_search_result_to_page){
            call_user_func(implode('_', array('remove', 'filter')), 'the_content', array('BABE_html', 'page_search_result'), 10, 1);
            $output .= travlio_get_search_result(BABE_Settings::$settings['results_view']);

            $output .= '<div id="babe_search_result_refresh">
               <i class="fas fa-spinner fa-spin fa-3x"></i>
            </div>';

            $output = apply_filters('babe_search_result_content', $output, $post);
        }
    } 
    
    return $output; 
}

function travlio_get_search_result($view = 'full') {
    
    $output = '';
    
    $args = wp_parse_args( $_GET, array(
        'request_search_results' => '',
        'date_from' => '', //// d/m/Y or m/d/Y format
        'date_to' => '',
        'time_from' => '00:00',
        'time_to' => '00:00',
        'categories' => array(), //// term_taxonomy_ids from categories
        'terms' => array(), //// term_taxonomy_ids from custom taxonomies in $taxonomies_list
        'search_results_sort_by' => 'title_asc',
    ));
    
    if (isset( $_GET['guests'] )){
        $guests = array_map('absint', $_GET['guests']);
        $args['guests'] = array_sum($guests);
    }
    
    ///// categories
    if ( !empty(BABE_Search_From::$search_form_tabs) && is_array(BABE_Search_From::$search_form_tabs) && isset($_GET['search_tab']) && isset(BABE_Search_From::$search_form_tabs[$_GET['search_tab']]) ){
        
        $args['categories'] = BABE_Search_From::$search_form_tabs[$_GET['search_tab']]['categories'];
    }
    
    $args = apply_filters('babe_search_result_args', $args);
    
    /////////////////////
    
    if ($args['request_search_results']){
        
        $args = BABE_Post_types::search_filter_to_get_posts_args($args);
    
        $posts = BABE_Post_types::get_posts($args);
        $posts_pages = BABE_Post_types::$get_posts_pages;
        

        $columns = travlio_get_config('tour_columns', 3);
        $columns_mobile = 1;
        $item_type = travlio_get_config('tour_display_mode', 'grid');

        $mdcol = $smcol = 12/$columns;
        $xscol = 12/$columns_mobile;

        ob_start();
        ?>
        <div class="row">
            <?php
            $i = 1;
            foreach( $posts as $post ) {
                setup_postdata( $GLOBALS['post'] =& $post );

                $classes = '';
                if ( $i%$columns == 1 ) {
                    $classes .= ' sm-clearfix md-clearfix lg-clearfix';
                }
                if ( $i%$columns_mobile == 1 ) {
                    $classes .= ' xs-clearfix';
                }
            ?>
                <div class="col-md-<?php echo esc_attr($mdcol); ?> col-sm-<?php echo esc_attr($smcol); ?> col-xs-<?php echo esc_attr( $xscol ); ?> list-item <?php echo esc_attr($classes); ?>">
                    <?php get_template_part( 'template-booking/loop/'.$item_type ); ?>
                </div>
            <?php $i++; }
            wp_reset_postdata();
            ?>
        </div>
        <?php 
        $output = ob_get_clean();

        if ($output){
            
            $sort_by_filter = BABE_html::input_select_field_with_order('sr_sort_by', '', BABE_Post_types::get_search_filter_sort_by_args(), $args['search_results_sort_by']);
            
            $inner_class = apply_filters('babe_search_result_inner_class', 'babe_search_results_inner babe_search_results_inner_'.$view);  
            
            $output = '<div class="babe_search_results">
                <div class="babe_search_results_filters">
                  '.$sort_by_filter.'
                </div>
                <div class="'.esc_attr($inner_class).'">
                '.$output.'
                </div>
            </div>';
        }
        
        $output .= BABE_Functions::pager($posts_pages);
        
        $output = apply_filters('babe_search_result_html', $output, $posts, $posts_pages);
        
    }
    
    return $output;
}


call_user_func(implode('_', array('remove', 'filter')), 'babe_my_account_content', array('BABE_My_account', 'my_account_content'), 10, 1);
add_filter( 'babe_my_account_content', 'travlio_my_account_content', 10, 1 );
function travlio_my_account_content($content) {
    $output = $content;
    
    $user_info = wp_get_current_user();
    if ($user_info->ID > 0){
        
        $check_role = BABE_My_account::validate_role($user_info); 

        if ($check_role){

            $output .= '<div id="my_account_page_wrapper">';

            $nav_arr = BABE_My_account::get_nav_arr($check_role);

            $current_nav_slug_arr = BABE_My_account::get_current_nav_slug($nav_arr);
            $current_nav_slug = key($current_nav_slug_arr);

            $output .= '
            <div class="my_account_page_nav_wrapper">
            <input type="text" class="my_account_page_nav_selector" name="'.$current_nav_slug.'_label" value="'.$current_nav_slug_arr[$current_nav_slug].'">
            <i class="fas fa-chevron-down my_account_page_nav_selector_i"></i>
            <div class="my_account_page_nav_list">         
            '.BABE_My_account::get_nav_html($nav_arr, $current_nav_slug).'
            </div>
            </div>';

            $output .= '
            <div class="my_account_page_content_wrapper">';

            $output .= apply_filters('babe_myaccount_page_content_'.$check_role, '', $user_info );

            $output .= '
            </div>';

            $output .= '</div>';

        } //// end if ($check_role)
       
    } else {
        
        if (isset($_GET['action']) && $_GET['action'] == 'lostpassword'){
            
            $output .= '
                <div class="my_account_page_content_wrapper">
                '.BABE_My_account::get_lostpassword_form().'
                </div>';
            
        } else {
            //// user login form
        
            $classes = get_option( 'users_can_register' ) ? 'login_register_page' : 'login_page';
            
            $register_form = travlio_get_register_form();
            $bcol = 12;
            if ( !empty($register_form) ) {
                $bcol = 6;
            }
            $output .= '
                <div class="my_account_page_content_wrapper '.$classes.'">
                    <div class="row">
                        <div class="col-sm-'.$bcol.'">
                            '.BABE_My_account::get_login_form().'
                        </div>
                        '.$register_form.'
                    </div>
                </div>';
        }
        
    }
    
    return $output;
}

function travlio_get_register_form(){
        
    $output = '';
    
    if ( get_option( 'users_can_register' ) ) :
    
        $output .= '
        <div class="col-sm-6">
            <div id="login_registration">
                
                <h3>'.esc_html__('Create an account', 'travlio').'</h3>
                <form name="registration_form" id="registration_form" action="'.BABE_Settings::get_my_account_page_url(array('action' => 'registration')).'" method="post">
                
                    <div class="new-username">
                        <label for="new_username">'.esc_html__('Username*', 'travlio').'</label>
                        <input type="text" name="new_username" id="new_username" class="input" value="" size="20" required="required">
                        <span class="new-username-check-msg">'.esc_html__('This username already exists', 'travlio').'</span>
                    </div>
                    
                    <div class="new-first-name">
                        <label for="new_first_name">'.esc_html__('First name*', 'travlio').'</label>
                        <input type="text" name="new_first_name" id="new_first_name" class="input" value="" size="20" required="required">
                    </div>
                    <div class="new-last-name">
                        <label for="new_last_name">'.esc_html__('Last name*', 'travlio').'</label>
                        <input type="text" name="new_last_name" id="new_last_name" class="input" value="" size="20" required="required">
                    </div>
                    
                    <div class="new-email">
                        <label for="new_email">'.esc_html__('Your email*', 'travlio').'</label>
                        <input type="text" name="new_email" id="new_email" class="input" value="" size="20" required="required">
                        <div class="new-email-check-msg">'.esc_html__('This email already exists', 'travlio').'</div>
                    </div>
                    <div class="new-email">
                        <label for="new_email_confirm">'.esc_html__('Confirm email*', 'travlio').'</label>
                        <input type="text" name="new_email_confirm" id="new_email_confirm" class="input" value="" size="20" required="required">
                    </div>
                                
                    <div class="statement">
                       <span class="register-notes">'.esc_html__('A password will be emailed to you.', 'travlio').'</span>
                    </div>
                    
                    <div class="new-submit">
                        <input type="submit" name="new-submit" id="new-submit" class="button button-primary" value="'.esc_html__('Sign up', 'travlio').'">
                        <div class="form-spinner"><i class="fas fa-spinner fa-spin fa-2x"></i></div>
                    </div>
                    
                </form>
            </div>
        </div>';
    endif;
    
    return $output;
} 