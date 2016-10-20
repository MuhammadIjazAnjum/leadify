<?php

/**
 * ReviePress Setting section.
 *
 * @package Leadify
 */
if ( ! class_exists( 'cls_Settings_Sections' ) ) :
	class cls_Settings_Sections {

		/**
		 * Private member.
		 */
		private $settings_api;

		/**
		 * Constructor of class.
		 */
		function __construct() {
			
			$this->settings_api = new cls_Leadify_Settings_API ;
			add_action( 'admin_init', array( $this, 'admin_init' ) );
		}

		/**
		 * Call in costructor.
		 */
		function admin_init() {

			// Set the settings.
			$this->settings_api->set_sections( $this->get_settings_sections() );
			$this->settings_api->set_fields( $this->get_settings_fields() );

			// Initialize settings.
			 $this->settings_api->admin_init();
		}

		/**
		 * Generate setting section
		 idls=id leadify section
		 */
		function get_settings_sections() {
			$sections = array(
			array(
			   'id'    => 'idls_display',
			   'title' => __( 'Display Settings', 'leadify' ),
			   'setting'=>'display_settings',
			),
			array(
			   'id'    => 'idls_reviews',
			   'title' => __( 'Reviews Settings', 'leadify' ),
			   'setting'=>'reviews_settings',
			),
			array(
			   'id'    => 'idls_form',
			   'title' => __( 'Review Form Settings', 'leadify' ),
			   'setting'=>'review_form_settings',
			),
			array(
			   'id'    => 'idls_custom_css',
			   'title' => __( 'Custom CSS', 'leadify' ),
			   'setting'=>'custom_css_settings',
			   ),
			);
			return $sections;
		}

		 /**
		  * Returns all the settings fields
		  *
		  * @return array settings fields
		  *
		  * @since 1.0.0
		  */
		function get_settings_fields() {

			// $post_type = get_post_types( array( 'public' => true, 'show_in_nav_menus' => true ) );
			$settings_fields = array(
			  'idls_display' => array(
				 array(
					'name'    => 'leadify_authorization',
					'label'   => __( 'Leadify Authorization', 'leadify' ),
					'desc'    => __( 'Select user who can give review', 'leadify' ),
					'type'    => 'radio',
					'options' => array(
					   'all_users'   => __( 'All Users','leadify' ),
					   'login_users' => __( 'Just Login Users','leadify' ),
					),
					'default' => 'all_users',
				 ),
				 array(
					'name'        => 'leadify_users',
					'label'       => __( 'Select Users', 'leadify' ),
					'type'        => 'text',
					'field-class' => 'hidden',
					'desc'        => __( 'Select user who can give review', 'leadify' ),
				 ),
				 array(
					'name'    => 'leadify_icon',
					'label'   => __( 'Rating Icon', 'leadify' ),
					'desc'    => __( 'Select icon for rating', 'leadify' ),
					'type'    => 'radio',
					'options' => array(
					   'star'  => __( 'Star','leadify' ),
					   'heart' => __( 'Heart','leadify' ),
					),
					'default' => 'star',
				 ),
				 array(
					'name'    => 'rating_icon_color',
					'label'   => __( 'Rating Icon Color', 'leadify' ),
					'desc'    => __( 'Select Color for Rating Icos', 'leadify' ),
					'type'    => 'color',
					'default' => '#ea9c00',
				 ),
			  ),
			  'idls_reviews' => array(
				 array(
					'name'    => 'auto_approve_rievew',
					'label'   => __( 'Auto Approve Reviews', 'leadify' ),
					'desc'    => __( 'Select Yes to Automatically Approve Reviews', 'leadify' ),
					'type'    => 'radio',
					'default' => 'pending',
					'options' => array(
					   'publish' => __( 'Yes','leadify' ),
					   'pending'  => __( 'No','leadify' ),
					),

				 ),
				 array(
					'name'    => 'sort_review',
					'label'   => __( 'Sort Reviews By', 'leadify' ),
					'type'    => 'select',
					'options' => array(
					   'rating' => __( 'Rating','leadify' ),
					   'date'   => __( 'Date','leadify' ),
					),
				 ),
				 array(
					'name'    => 'number_of_reviews',
					'label'   => __( 'Number of Reviews', 'leadify' ),
					'desc'    => __( 'Select Number of Reviews you want to show', 'leadify' ),
					'type'    => 'number',
					'default' => '10',
					'sanitize_callback' => 'sanitize_text_field ',
				 ),
			  ),
			  'idls_form' => array(
				 array(
					'name'    => 'google_captcha',
					'label'   => __( 'Add Google Captcha', 'leadify' ),
					'desc'    => __( 'To prevent Spamming', 'leadify' ),
					'type'    => 'checkbox',
				 ),
				 array(
					'name'        => 'google_captcha_site_key',
					'label'       => __( 'Site Key', 'leadify' ),
					'desc'        => __( 'Enter Google Captcha Site Key', 'leadify' ),
					'type'        => 'text',
					'default'     => '',
					'field-class' => 'hidden',
					'sanitize_callback' => 'sanitize_text_field ',
				 ),
				 array(
					'name'        => 'google_captcha_secret_key',
					'label'       => __( 'Secret key', 'leadify' ),
					'desc'        => __( 'Enter Google Captcha Secret Key', 'leadify' ),
					'type'        => 'text',
					'default'     => '',
					'field-class' => 'hidden',
					'sanitize_callback' => 'sanitize_text_field ',
				 ),
				 array(
					'name'    => 'google_snippet',
					'label'   => __( 'Add Google Rich Snippets', 'leadify' ),
					'type'    => 'radio',
					'default' => 'no',
					'options' => array(
					   'yes' => __( 'Yes','leadify' ),
					   'no'  => __( 'No','leadify' ),
					),
				 ),
				 array(
					'name'              => 'name_field_text',
					'label'             => __( 'Name Field', 'leadify' ),
					'type'              => 'text',
					'default'           => 'Name',
					'sanitize_callback' => 'sanitize_text_field ',
				 ),
				 array(
					'name'        => 'name_field_required',
					'label'       => __( 'Require', 'leadify' ),
					'type'        => 'checkbox',
				 ),
				 array(
					'name'        => 'name_field_display',
					'label'       => __( 'Display', 'leadify' ),
					'type'        => 'checkbox',
					'default'     => 'on',
				 ),
				 array(
					'name'        => 'email_field_text',
					'label'       => __( 'Email Field', 'leadify' ),
					'type'        => 'text',
					'default'     => 'Email',
					'sanitize_callback' => 'sanitize_text_field ',
				 ),
				 array(
					'name'        => 'email_field_required',
					'label'       => __( 'Require', 'leadify' ),
					'type'        => 'checkbox',
				 ),
				 array(
					'name'        => 'email_field_display',
					'label'       => __( 'Display', 'leadify' ),
					'type'        => 'checkbox',
					'default'     => 'on',
				 ),
				 array(
					'name'        => 'title_field_text',
					'label'       => __( 'Title Field', 'leadify' ),
					'type'        => 'text',
					'default'     => 'Title',
					'sanitize_callback' => 'sanitize_text_field ',
				 ),
				 array(
					'name'        => 'title_field_required',
					'label'       => __( 'Require', 'leadify' ),
					'type'        => 'checkbox',
				 ),
				 array(
					'name'        => 'title_field_display',
					'label'       => __( 'Display', 'leadify' ),
					'type'        => 'checkbox',
					'default'     => 'on',
				 ),
				 array(
					'name'        => 'rating_field_text',
					'label'       => __( 'Rating Field', 'leadify' ),
					'type'        => 'text',
					'default'     => 'Rating',
					'sanitize_callback' => 'sanitize_text_field ',
				 ),
				 array(
					'name'        => 'review_content_field_text',
					'label'       => __( 'Review Comment', 'leadify' ),
					'type'        => 'text',
					'default'     => 'Review Comment',
					'sanitize_callback' => 'sanitize_text_field ',
				 ),
				 array(
					'name'        => 'review_content_field_required',
					'label'       => __( 'Require', 'leadify' ),
					'type'        => 'checkbox',
				 ),
				 array(
					'name'         => 'review_content_field_display',
					'label'        => __( 'Display', 'leadify' ),
					'type'         => 'checkbox',
					'default'      => 'on',
					),
				 ),
				 'idls_custom_css' => array(
					array(
					   'name'              => 'custom_css',
					   'label'             => '',
					   'type'              => 'textarea',
					   'sanitize_callback' => 'wp_strip_all_tags',
					),
				 ),

				 );

				 return $settings_fields;
		}

		/**
		 * Generate spread the word section.
		 *
		 * @since 1.0.0
		 */
		function plugin_page() {

			//echo '<div id="" class="wrap"><h2 class="opt-title"><span id="icon-options-general" class="analytics-options"><img src="" alt=""></span> 	 Leadify Settings</h2></div>';
			echo "<h2>Leadify Settings</h2> ";

			$this->settings_api->show_navigation();
			$this->settings_api->show_forms();

			
			?>
			</br></br></br></br></br></br></br>
           <div class="metabox-holder wpbr-sidebar">
              <div class="sidebar postbox">
				 <h2><?php esc_html_e( 'Spread the Word' , 'leadify' )?></h2>
            <ul>
					<li>
						<a href="http://twitter.com/share?text=This is Best WordPress Review  Plugin&url=http://wordpress.org&hashtags=leadify,WordPress" data-count="none"  class="button twitter" target="_blank" title="Post to Twitter Now"><?php esc_html_e( 'Share on Twitter' , 'leadify' )?><span class="dashicons dashicons-twitter"></span></a>
					</li>

					<li>
						<a href="https://www.facebook.com/sharer/sharer.php?u=https://wordpress.org" class="button facebook" target="_blank" title="Post to Facebook Now"><?php esc_html_e( 'Share on Facebook' , 'leadify' )?><span class="dashicons dashicons-facebook"></span>
						</a>
					</li>

					<li>
						<a href="#" class="button wordpress" target="_blank" title="Rate on Wordpress.org"><?php esc_html_e( 'Rate on Wordpress.org' , 'leadify' )?><span class="dashicons dashicons-wordpress"></span>
						</a>
					</li>
					<li>
						<a href="http://wpbrigade.com/feed/" class="button rss" target="_blank" title="Subscribe to our Feeds"><?php esc_html_e( 'Subscribe to our Feeds' , 'leadify' )?><span class="dashicons dashicons-rss"></span>
						</a>
					</li>
				</ul>
              </div>
			  </div>

				<?php
		}//end of plugin_page
		function plugin_paage() {

			echo '<div id="" class="wrap"><h2 class="opt-title"><span id="icon-options-general" class="analytics-options"><img src="" alt=""></span>
		 Leadify Settings</h2></div>';

			echo "<div class='wpbr-wrap'><div class='wpbr-tabsWrapper'>";
			echo '<div class="wpbr-button-container top">
						<div class="setting-notification">'.
							__( 'Settings have changed, you should save them!' , 'leadify' )
						.'</div>
                  <input type="submit" class="wpbrmedia-settings-submit button button-primary button-big" value="'.esc_html__( 'Save Settings','leadify' ).'" id="wpbr_save_setting_top">
                  </div>';
			echo '<div id="review-setting" class="">';

			//$this->settings_api->show_navigation();
			$this->settings_api->show_forms();

			echo '</div>';
			echo '<div class="wpbr-button-container bottom">
                  <div class="wpbr-social-links alignleft">
                  <a href="https://twitter.com/wpbrigade" class="twitter" target="_blank"><span class="dashicons dashicons-twitter"></span></a>
                  <a href="https://www.facebook.com/WPBrigade" class="facebook" target="_blank"><span class="dashicons dashicons-facebook"></span></a>
                  <a href="https://profiles.wordpress.org/WPBrigade/" class="wordpress" target="_blank"><span class="dashicons dashicons-wordpress"></span></a>
                  <a href="http://wpbrigade.com/feed/" class="rss" target="_blank"><span class="dashicons dashicons-rss"></span></a>
                  </div>
                  <input type="submit" class="wpbrmedia-settings-submit button button-primary button-big" value="'.esc_html__( 'Save Settings','leadify' ).'" id="wpbr_save_setting_bottom">
                  </div>';
			echo '</div>';

			?>
           <div class="metabox-holder wpbr-sidebar">
              <div class="sidebar postbox">
				 <h2><?php esc_html_e( 'Spread the Word' , 'leadify' )?></h2>
            <ul>
					<li>
						<a href="http://twitter.com/share?text=This is Best WordPress Review  Plugin&url=http://wordpress.org&hashtags=leadify,WordPress" data-count="none"  class="button twitter" target="_blank" title="Post to Twitter Now"><?php esc_html_e( 'Share on Twitter' , 'leadify' )?><span class="dashicons dashicons-twitter"></span></a>
					</li>

					<li>
						<a href="https://www.facebook.com/sharer/sharer.php?u=https://wordpress.org" class="button facebook" target="_blank" title="Post to Facebook Now"><?php esc_html_e( 'Share on Facebook' , 'leadify' )?><span class="dashicons dashicons-facebook"></span>
						</a>
					</li>

					<li>
						<a href="#" class="button wordpress" target="_blank" title="Rate on Wordpress.org"><?php esc_html_e( 'Rate on Wordpress.org' , 'leadify' )?><span class="dashicons dashicons-wordpress"></span>
						</a>
					</li>
					<li>
						<a href="http://wpbrigade.com/feed/" class="button rss" target="_blank" title="Subscribe to our Feeds"><?php esc_html_e( 'Subscribe to our Feeds' , 'leadify' )?><span class="dashicons dashicons-rss"></span>
						</a>
					</li>
				</ul>
              </div>
			  </div>

				<?php
		}//end of plugin_page

			   /**
				* Get all the pages
				*
				* @return array page names with key value pairs
				*
				* @since 1.0.0
				*/
		function get_pages() {
			$pages = get_pages();
			$pages_options = array();
			if ( $pages ) {
				foreach ( $pages as $page ) {
					$pages_options[ $page->ID ] = $page->post_title;
				}
			}

			return $pages_options;
		}
	}
		 endif;
