<?php
/**
 * favorite
 *
 * @package    travlio
 * @author     ApusTheme <apusthemes@gmail.com >
 * @license    GNU General Public License, version 3
 * @copyright  13/06/2016 ApusTheme
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
 
class Travlio_Favorite {
	
	public static function init() {
		add_action( 'wp_ajax_travlio_add_favorite', array(__CLASS__, 'add_favorite') );
		add_action( 'wp_ajax_nopriv_travlio_add_favorite', array(__CLASS__, 'add_favorite') );
		add_action( 'wp_ajax_travlio_remove_favorite', array(__CLASS__, 'remove_favorite') );
		add_action( 'wp_ajax_nopriv_travlio_remove_favorite', array(__CLASS__, 'remove_favorite') );
	}

	public static function add_favorite() {
		check_ajax_referer( 'travlio-ajax-nonce', 'security' );

		do_action('travlio_before_add_bookmak');
		if ( isset($_GET['post_id']) && $_GET['post_id'] ) {
			self::save_wishlist($_GET['post_id']);
			$result['status'] = 'success';
			$result['msg'] = esc_html__('Added favorite successful.', 'travlio');
		} else {
			$result['status'] = 'error';
			$result['msg'] = esc_html__('Add favorite error.', 'travlio');
		}
		echo json_encode($result);
		die();
	}

	public static function remove_favorite() {
		check_ajax_referer( 'travlio-ajax-nonce', 'security' );
		do_action('travlio_before_remove_bookmak');
		if ( isset($_GET['post_id']) && $_GET['post_id'] ) {
			$user_id = get_current_user_id();
			$data = get_user_meta($user_id, '_favorite', true);
			if (is_array($data)) {
				foreach ($data as $key => $value) {
					if ( $_GET['post_id'] == $value ) {
						unset($data[$key]);
					}
				}
			}
			update_user_meta( $user_id, '_favorite', $data );
			// count favorite
			$counts = intval( get_post_meta($_GET['post_id'], '_favorite_count', true) );
		    if( $counts != '' ) {
		        $counts--;
		    } else {
		        $counts = 0;
		    }
		    update_post_meta( $_GET['post_id'], '_favorite_count', $counts );
			$result['status'] = 'success';
			$result['msg'] = esc_html__('Removed favorite successful.', 'travlio');
		} else {
			$result['status'] = 'error';
			$result['msg'] = esc_html__('Remove favorite error.', 'travlio');
		}
		echo json_encode($result);
		die();
	}

	public static function get_favorite() {
		$user_id = get_current_user_id();
		$data = get_user_meta($user_id, '_favorite', true);
		return $data;
	}

	public static function save_wishlist($post_id) {
		$user_id = get_current_user_id();
		$data = get_user_meta($user_id, '_favorite', true);
		if ( is_array($data) ) {
			if ( !in_array($post_id, $data) ) {
				$data[] = $post_id;
				update_user_meta( $user_id, '_favorite', $data );
				// count favorite
				$counts = intval( get_post_meta($post_id, '_favorite_count', true) );
			    if( $counts != '' ) {
			        $counts++;
			    } else {
			        $counts = 1;
			    }
			    update_post_meta( $post_id, '_favorite_count', $counts );
			}
		} else {
			$data = array($post_id);
			update_user_meta( $user_id, '_favorite', $data );
			// count favorite
			$counts = 1;
		    update_post_meta( $post_id, '_favorite_count', $counts );
		}
	}

	public static function check_listing_added($post_id) {
		$data = self::get_favorite();
		if ( !is_array($data) || !in_array($post_id, $data) ) {
			return false;
		}
		return true;
	}

	public static function display_favorite_btn( $post_id ) {
		$class = '';
		$icon_class = 'ti-heart';
		if ( !is_user_logged_in() ) {
			$class = 'apus-favorite-not-login';
		} else {
			$added = Travlio_Favorite::check_listing_added($post_id);
			if ($added) {
				$class = 'apus-favorite-added';
			} else {
				$class = 'apus-favorite-add';
			}
		}
		?>
		<div class="listing-btn-wrapper listing-favorite">
			<a href="javascript:void(0);" class="<?php echo esc_attr($class); ?>" data-id="<?php echo esc_attr($post_id); ?>">
				<i class="<?php echo esc_attr($icon_class); ?>"></i>
			</a>
		</div>
		<?php
	}

}

Travlio_Favorite::init();