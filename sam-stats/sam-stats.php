<?php
/*
Plugin Name: Sam Stats
Plugin URI: http://themology.net/sam-stats-for-wordpress
Description: Do you want to track how many visitors you have, where they come from and what they do on your site? Than Sam Stats is the right choise for you!
Version: 1.0.0
Author: Sam R
Author URI: http://themology
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

require_once( plugin_dir_path( __FILE__ ) . 'includes/Browser.php');
require_once( plugin_dir_path( __FILE__ ) . 'includes/sam-geo.class.php');
require_once( plugin_dir_path( __FILE__ ) . 'includes/sam-functions.php');
require_once( plugin_dir_path( __FILE__ ) . 'includes/sam-functions-top-query.php');
require_once( plugin_dir_path( __FILE__ ) . 'includes/sam-shortcodes.php');



define('sam_plugin_url', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
define('sam_plugin_dir', plugin_dir_path( __FILE__ ) );




function sam_init_scripts()
	{
		wp_enqueue_script('jquery');

		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_style('smart-stats-style', sam_plugin_url.'css/style.css');
		wp_enqueue_style('smart-stats-flags', sam_plugin_url.'css/flags.css');
		wp_enqueue_script('smart-stats-js', plugins_url( '/js/scripts.js' , __FILE__ ) , array( 'jquery' ));
		wp_localize_script( 'smart-stats-js', 'sam_ajax', array( 'sam_ajaxurl' => admin_url( 'admin-ajax.php')));
		wp_enqueue_style('jquery-ui', sam_plugin_url.'css/jquery-ui.css');
		
		//SAMAdmin
		wp_enqueue_style('SAMAdmin', sam_plugin_url.'SAMAdmin/css/SAMAdmin.css');
		wp_enqueue_style('SAMIcons', sam_plugin_url.'SAMAdmin/css/SAMIcons.css');		
		wp_enqueue_script('SAMAdmin', plugins_url( 'SAMAdmin/js/SAMAdmin.js' , __FILE__ ) , array( 'jquery' ));
		
		
		//jquery.jqplot
		wp_enqueue_style('jquery.jqplot', sam_plugin_url.'css/jquery.jqplot.css');		
		wp_enqueue_script('jquery.jqplot.min', plugins_url( 'js/jquery.jqplot.min.js' , __FILE__ ) , array( 'jquery' ));		
		
		wp_enqueue_script('jqplot.pieRenderer.min', plugins_url( 'js/jqplot.pieRenderer.min.js' , __FILE__ ) , array( 'jquery' ));		
		wp_enqueue_script('jqplot.highlighter.min', plugins_url( 'js/jqplot.highlighter.min.js' , __FILE__ ) , array( 'jquery' ));					
		wp_enqueue_script('jqplot.enhancedLegendRenderer.min', plugins_url( 'js/jqplot.enhancedLegendRenderer.min.js' , __FILE__ ) , array( 'jquery' ));			
		
		wp_enqueue_script('jqplot.dateAxisRenderer.min', plugins_url( 'js/jqplot.dateAxisRenderer.min.js' , __FILE__ ) , array( 'jquery' ));			
		
		wp_enqueue_script('jqplot.canvasTextRenderer.min', plugins_url( 'js/jqplot.canvasTextRenderer.min.js' , __FILE__ ) , array( 'jquery' ));			
				
		wp_enqueue_script('jqplot.canvasAxisTickRenderer.min', plugins_url( 'js/jqplot.canvasAxisTickRenderer.min.js' , __FILE__ ) , array( 'jquery' ));		
		
		wp_enqueue_script('jqplot.canvasAxisLabelRenderer.min', plugins_url( 'js/jqplot.canvasAxisLabelRenderer.min.js' , __FILE__ ) , array( 'jquery' ));			
				
	}
add_action("init","sam_init_scripts");







register_activation_hook(__FILE__, 'sam_install');
register_uninstall_hook(__FILE__, 'sam_uninstall');


function sam_uninstall()
	{

		$sam_delete_data = get_option( 'sam_delete_data' );
		
		
		if($sam_delete_data=='yes')
			{	
		
				global $wpdb;
				$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}sam" );
				$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}sam_online" );
				
				delete_option( 'sam_version' );
				delete_option( 'sam_delete_data' );
				delete_option( 'sam_customer_type' );
			}
		

		
		

		
	}
	
	
	
function sam_install()
	{
		
		global $wpdb;
		
        $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "sam"
                 ."( UNIQUE KEY id (id),
					id int(100) NOT NULL AUTO_INCREMENT,
					session_id	VARCHAR( 255 )	NOT NULL,
					sam_date	DATE NOT NULL,
					sam_time	TIME NOT NULL,
					sam_endtime	TIME NOT NULL,
					userid	VARCHAR( 50 )	NOT NULL,
					event	VARCHAR( 50 )	NOT NULL,
					browser	VARCHAR( 50 )	NOT NULL,
					platform	VARCHAR( 50 )	NOT NULL,
					ip	VARCHAR( 20 )	NOT NULL,
					city	VARCHAR( 50 )	NOT NULL,
					region	VARCHAR( 50 )	NOT NULL,
					countryName	VARCHAR( 50 )	NOT NULL,
					url_id	VARCHAR( 255 )	NOT NULL,
					url_term	VARCHAR( 255 )	NOT NULL,
					referer_doamin	VARCHAR( 255 )	NOT NULL,
					referer_url	TEXT NOT NULL,
					screensize	VARCHAR( 50 ) NOT NULL,
					isunique	VARCHAR( 50 ) NOT NULL,
					landing	VARCHAR( 10 ) NOT NULL

					)";
		$wpdb->query($sql);
		
		
		
        $sql2 = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "sam_online"
                 ."( UNIQUE KEY id (id),
					id int(100) NOT NULL AUTO_INCREMENT,
					session_id VARCHAR( 255 ) NOT NULL,
					sam_time  DATETIME NOT NULL,
					userid	VARCHAR( 50 )	NOT NULL,
					url_id	VARCHAR( 255 )	NOT NULL,
					url_term	VARCHAR( 255 )	NOT NULL,
					city	VARCHAR( 50 )	NOT NULL,
					region	VARCHAR( 50 )	NOT NULL,
					countryName	VARCHAR( 50 )	NOT NULL,
					browser	VARCHAR( 50 )	NOT NULL,
					platform	VARCHAR( 50 )	NOT NULL,
					referer_doamin	VARCHAR( 255 )	NOT NULL,
					referer_url	TEXT NOT NULL
					)";
		$wpdb->query($sql2);
		

		$sam_version= "1.0";
		update_option('sam_version', $sam_version); 
		
		$sam_customer_type= "free"; 
		update_option('sam_customer_type', $sam_customer_type); 



		}



function sam_visit()
	{
		

	$sam_date = sam_get_date();
	$sam_time = sam_get_time();
	$sam_datetime = sam_get_datetime();	
	$sam_endtime = $sam_datetime;
	

	$browser = new Browser_sam();
	$platform = $browser->getPlatform();
	$browser = $browser->getBrowser();
	$screensize = sam_get_screensize();
	

	$ip = $_SERVER['REMOTE_ADDR'];
	$geoplugin = new geoPlugin();
	$geoplugin->locate();
	$city = $geoplugin->city;
	$region = $geoplugin->region;
	$countryName = $geoplugin->countryCode;


	$referer = sam_get_referer();
	$referer = explode(',',$referer);
	$referer_doamin = $referer['0'];
	$referer_url = $referer['1'];



	$userid = sam_getuser();
	$url_id_array = sam_geturl_id();
	$url_id_array = explode(',',$url_id_array);
	$url_id = $url_id_array['0'];
	$url_term = $url_id_array['1'];
	
	$event = "visit";
	
	$isunique = sam_get_unique();
	$landing = sam_landing();
	$sam_session_id = sam_session();
	
	
	global $wpdb;
	$table = $wpdb->prefix . "sam";
		
	$wpdb->query( $wpdb->prepare("INSERT INTO $table 
								( id, session_id, sam_date, sam_time, sam_endtime, userid, event, browser, platform, ip, city, region, countryName, url_id, url_term, referer_doamin, referer_url, screensize, isunique, landing )
			VALUES	( %d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )",
						array	( '', $sam_session_id, $sam_date, $sam_time, $sam_endtime, $userid, $event, $browser, $platform, $ip, $city, $region, $countryName, $url_id, $url_term, $referer_doamin, $referer_url, $screensize, $isunique, $landing )
								));
		
		


$table = $wpdb->prefix . "sam_online";	
$result = $wpdb->get_results("SELECT * FROM $table WHERE session_id='$sam_session_id'", ARRAY_A);
$count = $wpdb->num_rows;


 

	if($count==NULL)
		{
			$wpdb->query( $wpdb->prepare("INSERT INTO $table 
								( id, session_id, sam_time, userid, url_id, url_term, city, region, countryName, browser, platform, referer_doamin, referer_url) VALUES	(%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
							array( '', $sam_session_id, $sam_datetime, $userid, $url_id, $url_term, $city, $region, $countryName, $browser, $platform, $referer_doamin, $referer_url)
								));
		}
	else
		{
			$wpdb->query("UPDATE $table SET sam_time='$sam_datetime', url_id='$url_id', referer_doamin='$referer_doamin', referer_url='$referer_url' WHERE session_id='$sam_session_id'");
		}


					
	}

add_action('wp_head', 'sam_visit');




function login_with_email_address($username) {
        $user = get_user_by('email',$username);
        if(!empty($user->user_login))
                $username = $user->user_login;
        return $username;
}
add_action('wp_authenticate','login_with_email_address');

function change_username_wps_text($text){
       if(in_array($GLOBALS['pagenow'], array('wp-login.php'))){
         if ($text == 'Username'){$text = 'Username / Email';}
            }
                return $text;
         }
add_filter( 'gettext', 'change_username_wps_text' );

















add_action('admin_init', 'sam_options_init' );
add_action('admin_menu', 'sam_menu_init');


function sam_options_init(){
	register_setting('sam_options', 'sam_version');
	register_setting('sam_options', 'sam_customer_type');	
	register_setting('sam_options', 'sam_delete_data');

    }

function sam_settings(){
	include('sam-settings.php');
	}
	
	
function sam_dashboard(){
	include('sam-dashboard.php');
	}
		
	
	
function sam_admin_online(){
	include('sam-admin-online.php');
	}

function sam_admin_visitors(){
	include('sam-admin-visitors.php');
	}

function sam_admin_geo(){
	include('sam-admin-geo.php');
	}

function sam_admin_filter(){
	include('sam-admin-filter.php');
	}




function sam_menu_init() {





	add_menu_page(__('Sam Stats','sam'), __('Sam Stats','sam'), 'manage_options', 'sam_settings', 'sam_dashboard');

	add_submenu_page('sam_settings', __('All Visitors','menu-sam'), __('All Time Visitors','menu-sam'), 'manage_options', 'sam_admin_visitors', 'sam_admin_visitors');	
	
	add_submenu_page('sam_settings', __('Online Users','menu-sam'), __('Online Users','menu-sam'), 'manage_options', 'sam_admin_online', 'sam_admin_online');
	
	add_submenu_page('sam_settings', __('Filter','menu-sam'), __('Filter Statistics','menu-sam'), 'manage_options', 'sam_admin_filter', 'sam_admin_filter');		

	add_submenu_page('sam_settings', __('Sam Dashboard','menu-sam'), __('Sam Stats Settings','menu-sam'), 'manage_options', 'sam_dashboard', 'sam_settings');	

}

?>