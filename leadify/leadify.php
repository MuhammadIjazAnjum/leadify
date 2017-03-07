<?php
/*
Plugin Name: Leadify
Plugin URI: http://convertplug.com/
Author: Muhammad Ijaz Anjum
Author URI: https://www.bitwali.com
Version: 0.1
Description: Welcome to Leadify - the easiest way to manage website traffic into leads. 
Text Domain: leadify
*/
if( !defined( 'LEADIFY_VERSION' ) ) {
	define( 'LEADIFY_VERSION', '0.1');
}

if( !defined( 'LEADIFY_BASE_DIR' ) ) {
	define( 'LEADIFY_BASE_DIR', plugin_dir_path( __FILE__ ));
}

if( !defined( 'LEADIFY_BASE_URL' ) ) {
	define( 'LEADIFY_BASE_URL', plugin_dir_url( __FILE__ ));
}

if( !defined( 'LEADIFY_DIR_NAME' ) ){
	define( 'LEADIFY_DIR_NAME', plugin_basename( dirname( __FILE__ ) ) );
}

register_activation_hook( __FILE__, 'on_leadify_activation' );
/*
* Function for activation hook
*
* @Since 1.0
*/
function on_leadify_activation() {

	// update_option( 'convert_plug_redirect', true );
	// update_site_option( 'bsf_force_check_extensions', true );
	// update_option( "dismiss-cp-update-notice", false );

	$leadify_previous_version = get_option( 'leadify_previous_version' );

	if( !$leadify_previous_version ) {
		update_option( 'leadify_new_user', true );
	} else {
		update_option( 'leadify_new_user', false );
	}

	// save previous version of plugin in option
	update_option( "leadify_previous_version", LEADIFY_VERSION );

	global $wp_version;
	$wp = '3.5';
	$php = '5.3.2';
    if ( version_compare( PHP_VERSION, $php, '<' ) )
        $flag = 'PHP';
    elseif
        ( version_compare( $wp_version, $wp, '<' ) )
        $flag = 'WordPress';
    else
        return;
    $version = 'PHP' == $flag ? $php : $wp;
    deactivate_plugins( basename( __FILE__ ) );
    wp_die('<p><strong>Leadify </strong> requires <strong>'.$flag.'</strong> version <strong>'.$version.'</strong> or greater. Please contact your host.</p>','Plugin Activation Error',  array( 'response'=>200, 'back_link'=> TRUE ) );

}

if(!class_exists( 'Leadify' )){
	class Leadify {
		public static $options = array();
		
		function __construct(){

			add_action( 'wp_loaded', array( $this,'leadify_user_access' ), 1 );
			
			add_action( 'admin_menu', array( $this,'add_admin_menu' ), 99 );
			// add_action( 'admin_menu', array( $this,'add_admin_menu_rename' ), 9999 );
			
		}// End of __construct

		/*
		* Add ConvertPlug access capabilities to user roles
		* Since 2.2.0
		*/
		function leadify_user_access() {

			if ( is_user_logged_in() ) {
				if ( current_user_can( 'manage_options' ) ) {

					global $wp_roles;
					
					//$wp_user_name	:[administrator] => Administrator [editor] => Editor [author] => Author [contributor] => Contributor [subscriber] => Subscriber )
	 				$wp_user_name = $wp_roles->get_names();
	 				$roles = false;
	 				if(!$roles) {
	 					$roles = array();
	 				}

	 				// give access to administrator
	 				$roles[] = 'administrator';

	 				foreach ( $wp_user_name as $key => $value ) {
	 					$role = get_role( $key );

	 					if ( in_array( $key, $roles ) ) {
	 						//adds user capability
	 						$role->add_cap( 'leadify_access' );
	 					} else {
	 						$role->remove_cap( 'leadify_access' );
	 					}
	 				}
 				}
			}
		}

		
		
      	/*
		* Add Leadify menu
		*/
		function add_admin_menu(){
			// add_menu_page( string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '', string $icon_url = '', int $position = null )
			// Add a top-level menu page.
			 add_menu_page( 'Leadify', 'Leadify', 'leadify_access', 'leadify', array($this,'admin_dashboard'), 'div' );
		}
		function admin_dashboard()
			{
				require_once('admin/admin.php');
			}
		//store modue in stataic module array
		function leadify_store_module($module_array)
			{
				print_r($module_array);
				die();
			}	
	}//End of class Leadify  
	// Add module(s)
	function leadify_add_module($module_array)
	{
		leadify::leadify_store_module($module_array);
	}


	// call  modules
	require_once('modules/config.php');

}//End of if(!class_exists( 'Leadify' ))
new Leadify;
