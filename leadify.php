<?php
/*
	Plugin Name:leadify
	Plugin Url: http://bitwali.com
	Description: simple de 
	Author: Muhammad Ijaz Anjum
	Author Uri: http://bitwali.com
*/

// CONSTANTS 
	define( 'LEADIFY_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
	define( 'LEADIFY_ROOT_PATH', dirname( __FILE__ ) );
// define( 'BWREVIEW_SLUG', 'cptbwreview' );

/****************************
	Main class of leadify 
*****************************/
class cls_Leadify
{
	/**
	 * To create instance of settings class.
	 *
	 * @var $settings_section
	 *
	 * @since 1.0.0
	*/
	private $settings_section;

	/**
	 * Class constructor
	 *
	 * @since 1.0.0
	 */
	function __construct()
	{
		
		//	1.0 adds top menu and submenus
		add_action( 'admin_menu', array( $this, 'leadify_menu' ) );
		
		// add_action( 'admin_enqueue_scripts', array( $this, 'wpbr_admin_scripts' ) ,  10, 1 );
		// add_action( 'admin_enqueue_scripts', array( $this, 'wpbr_admin_styles' ) );

		// add_action( 'wp_enqueue_scripts', array( $this, 'wpbr_front_scripts' ) );
		// add_action( 'wp_enqueue_scripts', array( $this, 'wpbr_front_styles' ) );

		// add_action( 'init' , array( $this, 'wpbr_save_review_form' ) );
		// add_action( 'init' , array( $this, 'review_post_type' ) , 1 );

		include( LEADIFY_ROOT_PATH. '/include/api/cls-leadify-settings-api.php' );
		include( LEADIFY_ROOT_PATH . '/include/cls-settings-sections.php' );
		$this->settings_section = new cls_Settings_Sections();

		// include REVIEWPRESS_ROOT_PATH.'/include/class-all-review.php';

		// include REVIEWPRESS_ROOT_PATH.'/include/class-shortcode.php';

		// include REVIEWPRESS_ROOT_PATH . '/include/class.upgrade.php';

		// // $this->pending_reviews = new
		// add_action( 'save_post', array( $this, 'save_reviews_values' ), 20, 3 );

		// // For custom CSS
		// add_action( 'wp_enqueue_scripts', array( $this, 'wpbr_register_style' ), 99 );
		// add_action( 'plugins_loaded', array( $this, 'wpbr_maybe_print_css' ) );

		// // To add settings default values.
		// add_action( 'activated_plugin', array( $this, 'wpbr_setting_default' ) );

		// add_action( 'admin_print_styles-post.php', array( $this, 'wpbr_remove_preview_button' ) );
		// add_action( 'admin_head-post-new.php' , array( $this, 'wpbr_remove_preview_button' ) );
		// add_action( 'init', array( $this, 'wpbr_textdomain' ) );
		// add_action( 'admin_menu',array( $this, 'add_pending_reviews_bubble' ) , 99 );

		}


		/**
		 * Add leadify menu and sub menu
		 *
		 * @since 1.0.0
		 */
		public function leadify_menu() {
			//add a top level menu page Leadify
			//add_menu_page(  $page_title,  $menu_title,  $capability,  $menu_slug, callable $function = '',  $icon_url = '', int $position = null )
			add_menu_page( 'Leadify', __( 'Leadify', 'leadify' ), 'manage_options', 'leadify_menu_slug', array( $this, 'cb_leadify_settings' ) , 'none', '15' );

			// Add a submenu page.
			// add_submenu_page(  $parent_slug,  $page_title,  $menu_title,  $capability,  $menu_slug, callable $function = '' )
			add_submenu_page( 'leadify_menu_slug', 'Settings', __( 'Settings', 'leadify' ), 'manage_options', 'leadify_settings_slug' , array( $this, 'cb_leadify_settings' ) );
			

		}
		/**
		 * Include setting classes
		 *
		 * @since 1.0.0
		 */
		function cb_leadify_settings() {
			
			$screen = get_current_screen();
			if ( strpos( $screen->base, 'leadify_settings_slug' ) !== false ) {
				
				$this->settings_section->plugin_page();

			}//  else if ( strpos( $screen->base, 'reviewpress_shortcode' ) !== false ) {

			// 	include_once( REVIEWPRESS_ROOT_PATH.'/include/shortcode-page.php' );

			// }
		}//end of cb_leadify_settings

		/**
		 * Add js code for admin menu.
		 *
		 * @param  int $hook  suffix for the current admin page.
		 * @since 1.0.0
		 */
		function wpbr_admin_scripts( $hook ) {

			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'main-js', plugins_url( 'assets/js/admin-main.js', __FILE__ ), false, REVIEWPRESS_VERSION );

			if ( 'reviewpress_page_reviewpress_settings' === $hook ) {

				wp_enqueue_style( 'codemirror_css', plugins_url( 'assets/codemirror/codemirror.css', __FILE__ ) );
				wp_enqueue_script( 'codemirror', plugins_url( 'assets/codemirror/codemirror.js', __FILE__ ), array( 'jquery' ), REVIEWPRESS_VERSION );
				wp_enqueue_script( 'codemirror_js_css', plugins_url( 'assets/codemirror/css.js', __FILE__ ), array( 'codemirror' ), REVIEWPRESS_VERSION );
				wp_enqueue_script( 'codemirror_activeline', plugins_url( 'assets/codemirror/active-line.js', __FILE__ ), array( 'codemirror' ), REVIEWPRESS_VERSION );

			}

		}

		/**
		 * Add css for admin panel.
		 *
		 * @since 1.0.0
		 */
		public function wpbr_admin_styles() {

			wp_enqueue_style( 'review_styles', plugins_url( 'assets/css/style.css' , __FILE__ ), false, REVIEWPRESS_VERSION );
		}

		/**
		 * Add css for front end
		 *
		 * @since 1.0.0
		 */
		public function wpbr_front_styles() {

			wp_enqueue_style( 'review_styles', plugins_url( 'assets/css/front.css' , __FILE__ ), false, REVIEWPRESS_VERSION );
		}

		/**
		 * Add js for front end
		 *
		 * @since 1.0.0
		 */
		function wpbr_front_scripts() {

			wp_enqueue_script( 'jquery' );

			wp_enqueue_script( 'front_main', plugins_url( 'assets/js/front-main.js', __FILE__ ) , $deps = array(), REVIEWPRESS_VERSION , true );

			if ( 'on' === get_option( 'wpbr_form' )['google_captcha'] ) {
				wp_enqueue_script( 'google-recaptcha', 'https://www.google.com/recaptcha/api.js' );
			}

			wp_enqueue_script( 'raty', plugins_url( 'assets/js/jquery.raty.js', __FILE__ ) , array( 'jquery' ) );

		}


		

		/**
		 * Add textdomain for translation.
		 *
		 * @since 1.0.0
		 */
		public function leadify_textdomain() {

			load_plugin_textdomain( 'leadify', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}

		/**
		 * Add Review post type
		 *
		 * @since 1.0.0
		 */
		public function review_post_type() {

			$labels = array(
			'name'               => _x( 'Reviews', 'post type general name', 'reviewpress' ),
			'singular_name'      => _x( 'Review', 'post type singular name', 'reviewpress' ),
			'menu_name'          => _x( 'Reviews', 'admin menu', 'reviewpress' ),
			'name_admin_bar'     => _x( 'Review', 'add new on admin bar', 'reviewpress' ),
			'add_new'            => _x( 'Add New', 'review', 'reviewpress' ),
			'add_new_item'       => __( 'Add New Review', 'reviewpress' ),
			'new_item'           => __( 'Add Review', 'reviewpress' ),
			'edit_item'          => __( 'Edit Review', 'reviewpress' ),
			'view_item'          => __( 'View Review', 'reviewpress' ),
			'all_items'          => __( 'All Reviews', 'reviewpress' ),
			'search_items'       => __( 'Search Reviews', 'reviewpress' ),
			'parent_item_colon'  => __( 'Parent Reviews:', 'reviewpress' ),
			'not_found'          => __( 'No reviews found.', 'reviewpress' ),
			'not_found_in_trash' => __( 'No reviews found in Trash.', 'reviewpress' ),
			);

			$args = array(
			'labels'               => $labels,
			'public'               => false,
			'publicly_queryable'   => true,
			'show_ui'              => true,
			'show_in_menu'         => 'all_reviews',
			'query_var'            => true,
			'rewrite'              => array( 'slug' => 'review' ),
			'capability_type'      => 'post',
			'has_archive'          => true,
			'hierarchical'         => false,
			'menu_position'        => null,
			'supports'             => false,
			'register_meta_box_cb' => array( $this , 'review_custom_fields' ),
			);

			register_post_type( 'cptreviewpress', $args );

		}

		/**
		 * Review post type custom meta
		 *
		 * @since 1.0.0
		 */

		function review_custom_fields() {
			add_meta_box( 'wpbr_review_meta_box', 'Fill Fields', array( $this, 'custom_fields_metabox' ), 'cptreviewpress', 'normal', 'high' );

		}

		/**
		 * Review post meta fields
		 *
		 * @since 1.0.0
		 */
		function custom_fields_metabox() {

			global $post;
			$message_value  = get_post_meta( $post->ID, 'wpbr_reviewer_message', $single = true );
			echo '<input type="hidden" name="review_meta_noncename" id="review_meta_noncename" value="' .
			esc_html( wp_create_nonce( plugin_basename( __FILE__ ) ) ) . '" />';

			echo '<label>Name</label>';
			echo '<input type="text" placeholder="Enter Name Here" name="wpbr_review_name" value="'.esc_html( get_post_meta( $post->ID , 'wpbr_review_name' , true ) ).'" class="widefat" />';
			echo '<label>Title</label>';
			echo '<input type="text" placeholder="Enter Title Here" name="wpbr_review_title" value="'. esc_html( get_post_meta( $post->ID , 'wpbr_review_title' , true ) ).'" class="widefat" />';
			echo '<label>Email</label>';
			echo '<input type="email" placeholder="Enter Email Here" name="wpbr_review_email" value="'.esc_html( get_post_meta( $post->ID , 'wpbr_review_email' , true ) ).'" class="widefat" />';
			echo '<label>Rating</label>';
			echo '<input type="number" placeholder="Enter Rating Here" min="1" max="5" step="any" name="wpbr_review_rating" value="'.esc_html( get_post_meta( $post->ID , 'wpbr_review_rating' , true ) ).'" class="widefat" />';
			echo '<label>Parent Post ID</label>';
			echo '<input type="number" min="0" name="wpbr_review_parent_post" value="'.esc_html( wp_get_post_parent_id( $post->ID ) ).'" class="widefat" />';
			echo '<label>Message</label>';
			echo '<textarea placeholder="Enter Message Here" rows="7" cols="7" name="wpbr_review_message" class="widefat">'.esc_html( get_post_meta( $post->ID , 'wpbr_review_message' , true ) ).'</textarea>';

		}

		/**
		 * Save review type meta values
		 *
		 * @param int  $post_id The post ID.
		 * @param post $post The post object.
		 * @param bool $update Whether this is an existing post being updated or not.
		 *
		 * @since 1.0.0
		 */
		function save_reviews_values( $post_id, $post, $update ) {

			if ( 'cptreviewpress' != $post->post_type ) {
				return;
			}

			if ( isset( $_GET['actions'] ) ) {
				return;
			}

			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
					return;
			}

			if ( ! isset( $_POST['review_meta_noncename'] ) ) {
				return;
			}

			if ( ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['review_meta_noncename'] ) ), plugin_basename( __FILE__ ) ) ) {
				return ;
			}

			if ( ! current_user_can( 'edit_post', $post->ID ) ) {
				return ;
			}

			if ( isset( $_POST['wpbr_review_form_submit'] ) ) {
				return;
			}

			remove_action( 'save_post', array( $this, 'save_reviews_values' ) , 20 );

			update_post_meta( $post_id, 'wpbr_review_name', ! empty( $_POST['wpbr_review_name'] ) ? sanitize_text_field( wp_unslash( $_POST['wpbr_review_name'] ) ) : '' );
			update_post_meta( $post_id, 'wpbr_review_title', ! empty( $_POST['wpbr_review_title'] ) ? sanitize_text_field( wp_unslash( $_POST['wpbr_review_title'] ) ) : '' );
			update_post_meta( $post_id, 'wpbr_review_email', ! empty( $_POST['wpbr_review_email'] ) ? sanitize_text_field( wp_unslash( $_POST['wpbr_review_email'] ) ) : '' );
			update_post_meta( $post_id, 'wpbr_review_rating', ! empty( $_POST['wpbr_review_rating'] ) ? sanitize_text_field( wp_unslash( $_POST['wpbr_review_rating'] ) ) : '' );
			update_post_meta( $post_id, 'wpbr_review_message', ! empty( $_POST['wpbr_review_message'] ) ? sanitize_text_field( wp_unslash( $_POST['wpbr_review_message'] ) ) : '' );

			wp_update_post( array(
				'ID'          => $post_id,
				'post_parent' => ! empty( $_POST['wpbr_review_parent_post'] ) ? sanitize_text_field( wp_unslash( $_POST['wpbr_review_parent_post'] ) ) : '',
				'post_title'  => ! empty( $_POST['wpbr_review_title'] ) ? sanitize_text_field( wp_unslash( $_POST['wpbr_review_title'] ) ) : '',
			) );

			add_action( 'save_post', array( $this, 'save_reviews_values' ) , 20 );

		}


		/**
		 * Save review form values
		 *
		 * @since 1.0.0
		 */
		function wpbr_save_review_form() {

			if ( isset( $_POST['wpbr_review_form_submit'] ) && wp_verify_nonce( sanitize_key( wp_unslash( $_POST['wpbr_review_form_nonce_field'] ) ), 'wpbr_review_form_action' )  ) {

				$is_reviewed = get_children( array(
					'post_type'   => 'cptreviewpress',
					'post_parent' => sanitize_text_field( wp_unslash( $_POST['wpbr_review_post_id'] ) ), // Input var Okay.
				) );

				$already_reviewed = array_filter( $is_reviewed, function ( $e ) {
					// get_post_meta( $e->ID, 'wpbr_review_email', true )
					if ( get_current_user_id() == $e->post_author  ) {
						return $e->post_author;
					}
				} );

				if ( ! empty( $already_reviewed ) ) {
					return ;
				}

					/**
				*  Google ReCaptcha Validation
				*/
				if ( 'on' === get_option( 'wpbr_form' )['google_captcha'] ) {
					include( REVIEWPRESS_ROOT_PATH. '/include/api/recaptchalib.php' );

					$secret = get_option( 'wpbr_form' )['google_captcha_secret_key'];

					// Empty response.
					$response = null;

					// Check secret key.
					$re_captcha = new ReCaptcha( $secret );

					if ( isset( $_POST['g-recaptcha-response'] ) && sanitize_key( wp_unslash( $_POST['g-recaptcha-response'] ) ) ) { // Input var okay.
						$response = $re_captcha->verifyResponse( wp_unslash( $_SERVER['REMOTE_ADDR'] ),sanitize_text_field( wp_unslash( $_POST['g-recaptcha-response'] ) ) ); // Input var okay.
					}

					if ( ! $response->success ) {
						echo "<script>alert('Captcha Invalid! Try Again')</script>";
						return;
					}
				}

					$postarr = array(
					'post_author'           => ! empty( $_POST['wpbr_review_user_id'] ) ? sanitize_text_field( wp_unslash( $_POST['wpbr_review_user_id'] ) ) : '',
					'post_title'            => ! empty( $_POST['wpbr_review_title'] ) ? sanitize_text_field( wp_unslash( $_POST['wpbr_review_title'] ) ) : '',
					'post_status'           => get_option( 'wpbr_reviews' )['auto_approve_rievew'],
					'post_type'             => 'cptreviewpress',
					'post_parent'           => ! empty( $_POST['wpbr_review_post_id'] ) ? sanitize_text_field( wp_unslash( $_POST['wpbr_review_post_id'] ) ) : '',
					);

					$post_id = wp_insert_post( $postarr );

					update_post_meta( $post_id, 'wpbr_review_name', ! empty( $_POST['wpbr_review_name'] ) ? sanitize_text_field( wp_unslash( $_POST['wpbr_review_name'] ) ) : '' );
					update_post_meta( $post_id, 'wpbr_review_title', ! empty( $_POST['wpbr_review_title'] ) ? sanitize_text_field( wp_unslash( $_POST['wpbr_review_title'] ) ) : '' );
					update_post_meta( $post_id, 'wpbr_review_email', ! empty( $_POST['wpbr_review_email'] ) ? sanitize_text_field( wp_unslash( $_POST['wpbr_review_email'] ) ) : '' );
					update_post_meta( $post_id, 'wpbr_review_rating', ! empty( $_POST['score'] ) ? sanitize_text_field( wp_unslash( $_POST['score'] ) ) : '' );
					update_post_meta( $post_id, 'wpbr_review_message', ! empty( $_POST['wpbr_review_message'] ) ? sanitize_text_field( wp_unslash( $_POST['wpbr_review_message'] ) ) : '' );


			}
		}

		/**
		 * For enqeue custom styles
		 */
		function wpbr_register_style() {
			$url = home_url();
			if ( is_ssl() ) {
				$url = home_url( '/', 'https' );
			}

			wp_register_style( 'review_press_custom_style', add_query_arg( array( 'review_press_custom_style' => 1 ), $url ) );

			wp_enqueue_style( 'review_press_custom_style' );
		}

		/**
		 * If the query var is set, print the Simple Custom CSS rules.
		 */
		public function wpbr_maybe_print_css() {

			// Only print CSS if this is a stylesheet request.
			if ( ! isset( $_GET['review_press_custom_style'] ) || intval( $_GET['review_press_custom_style'] ) !== 1 ) {
				return;
			}

			ob_start();
			header( 'Content-type: text/css' );
			$options     = get_option( 'wpbr_custom_css' )['custom_css'];
			$raw_content = isset( $options ) ? $options : '';
			$content     = wp_kses( $raw_content, array( '\'', '\"' ) );
			$content     = str_replace( '&gt;', '>', $content );
			echo  $content ;
			die();
		}

		/**
		 * Set Default Values of Setting on plugin activation first time
		 *
		 * @since 1.0.0
		 */
		public function wpbr_setting_default() {

			if ( ! get_option( 'wpbr_display' ) && ! get_option( 'wpbr_reviews' )  &&  ! get_option( 'wpbr_form' ) ) {
				update_option('wpbr_display' , array(
					'review_authorization'          => 'all_users',
					'review_icon'                   => 'star',
					'rating_icon_color' 			=> '#0a0000',
				));
				update_option( 'wpbr_reviews', array(
					'auto_approve_rievew'          => 'pending',
					'sort_review'                  => 'rating',
					'number_of_reviews'            => '10',
				));
				update_option( 'wpbr_form', array(
					'google_captcha'                => 'off',
					'google_snippet'                => 'no',
					'name_field_text'               => 'Name',
					'name_field_display'            => 'on',
					'email_field_text'              => 'Email',
					'email_field_display'           => 'on',
					'title_field_text'              => 'Title',
					'title_field_display'           => 'on',
					'rating_field_text'             => 'Rating',
					'review_content_field_text'     => 'Review Comment',
					'review_content_field_display'  => 'on',
					'name_field_required'           => 'on',
					'title_field_required'          => 'on',
					'email_field_required'          => 'on',
					'review_content_field_required' => 'on',
				));
			}
		}

		/**
		 * Remove preveiw button from review post type
		 *
		 * @since 1.0.0
		 */
		function wpbr_remove_preview_button() {
			if ( 'cptreviewpress' == get_current_screen()->post_type ) {
				$style = '';
				$style .= '<style type="text/css">';
				$style .= '#preview-action ,#post-body-content';
				$style .= '{display: none; }';
				$style .= '</style>';

				echo $style;
			}
		}

		/**
		 * Add pending reviews bubble notifcation.
		 *
		 * @since 1.0.0
		 */
		public function add_pending_reviews_bubble() {
			global $wpdb;

			$pend_count = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts  WHERE post_type = 'cptreviewpress' AND post_status = 'pending' " );

			global $menu;

			foreach ( $menu as $key => $value ) {

				if ( 'ReviewPress' == $menu[ $key ][0] ) {
					$menu[ $key ][0] .= " <span class='update-plugins count-$pend_count'><span class='plugin-count'>" . $pend_count . '</span></span>';
					return;
				}
			}
		}
	}

	$cls_leadify_instance = new cls_Leadify();
