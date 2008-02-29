<?php
/*
Plugin Name: WP-SpamFree
Plugin URI: http://www.hybrid6.com/webgeek/plugins/wp-spamfree/
Description: A powerful anti-spam plugin that virtually eliminates automated comment spam from bots. Finally, you can enjoy a spam-free WordPress blog!
Author: Scott Allen, aka WebGeek
Version: 1.5.2
Author URI: http://www.hybrid6.com/webgeek/
*/

/*  Copyright 2007    Scott Allen  (email : scott@hybrid6.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function spamfree_init() {
	session_start();
	$wpSpamFreeVer='1.5.2';
	update_option('wp_spamfree_version', $wpSpamFreeVer);
	spamfree_update_keys(0);
	}
	
function spamfree_create_random_key() {
    $chars = 'abcdefghijkmnopqrstuvwxyz023456789';
    srand((double)microtime()*1000000);
    $i = 0;
    $pass = '' ;

    while ($i <= 7) {
        $num = rand() % 33;
        $tmp = substr($chars, $num, 1);
        $keyCode = $keyCode . $tmp;
        $i++;
    	}
		
	if ($keyCode=='') {
		srand((double)74839201183*1000000);
    	$i = 0;
    	$pass = '' ;

    	while ($i <= 7) {
        	$num = rand() % 33;
        	$tmp = substr($chars, $num, 1);
        	$keyCode = $keyCode . $tmp;
        	$i++;
    		}
		}
    return $keyCode;
	}
	
function spamfree_update_keys($reset_keys) {
	$spamfree_options 								= get_option('spamfree_options');
	/*
	//Array Values :: BEGIN
	$spamfree_options_cookie_validation_name 		= $spamfree_options['cookie_validation_name'];
	$spamfree_options_cookie_validation_key 		= $spamfree_options['cookie_validation_key'];
	$spamfree_options_form_validation_field_js 		= $spamfree_options['form_validation_field_js'];
	$spamfree_options_form_validation_key_js 		= $spamfree_options['form_validation_key_js'];
	$spamfree_options_wp_cache 						= $spamfree_options['wp_cache'];
	$spamfree_options_wp_super_cache 				= $spamfree_options['wp_super_cache'];
	$spamfree_options_use_captcha_backup 			= $spamfree_options['use_captcha_backup'];
	$spamfree_options_block_all_trackbacks 			= $spamfree_options['block_all_trackbacks'];
	$spamfree_options_block_all_pingbacks 			= $spamfree_options['block_all_pingbacks'];
	$spamfree_options_use_trackback_verification	= $spamfree_options['use_trackback_verification'];
	//Array Values :: End
	*/

	// Set Random Cookie Name
	$CookieValidationName = $spamfree_options['cookie_validation_name'];
	if (!$CookieValidationName||$reset_keys==1) {
		$randomComValCodeCVN1 = spamfree_create_random_key();
		$randomComValCodeCVN2 = spamfree_create_random_key();
		$CookieValidationName = strtoupper($randomComValCodeCVN1.$randomComValCodeCVN2);
		}
	// Set Random Cookie Value
	$CookieValidationKey = $spamfree_options['cookie_validation_key'];
	if (!$CookieValidationKey||$reset_keys==1) {
		$randomComValCodeCKV1 = spamfree_create_random_key();
		$randomComValCodeCKV2 = spamfree_create_random_key();
		$CookieValidationKey = $randomComValCodeCKV1.$randomComValCodeCKV2;
		}
	// Set Random Form Field Name
	$FormValidationFieldJS = $spamfree_options['form_validation_field_js'];
	if (!$FormValidationFieldJS||$reset_keys==1) {
		$randomComValCodeJSFFN1 = spamfree_create_random_key();
		$randomComValCodeJSFFN2 = spamfree_create_random_key();
		$FormValidationFieldJS = $randomComValCodeJSFFN1.$randomComValCodeJSFFN2;
		}
	// Set Random Form Field Value
	$FormValidationKeyJS = $spamfree_options['form_validation_key_js'];
	if (!$FormValidationKeyJS||$reset_keys==1) {
		$randomComValCodeJS1 = spamfree_create_random_key();
		$randomComValCodeJS2 = spamfree_create_random_key();
		$FormValidationKeyJS = $randomComValCodeJS1.$randomComValCodeJS2;
		}
	$spamfree_options_update = array (
		'cookie_validation_name' 		=> $CookieValidationName,
		'cookie_validation_key' 		=> $CookieValidationKey,
		'form_validation_field_js' 		=> $FormValidationFieldJS,
		'form_validation_key_js' 		=> $FormValidationKeyJS,
		'wp_cache' 						=> $spamfree_options['wp_cache'],
		'wp_super_cache' 				=> $spamfree_options['wp_super_cache'],
		'use_captcha_backup' 			=> $spamfree_options['use_captcha_backup'],
		'block_all_trackbacks' 			=> $spamfree_options['block_all_trackbacks'],
		'block_all_pingbacks' 			=> $spamfree_options['block_all_pingbacks'],
		'use_trackback_verification' 	=> $spamfree_options['use_trackback_verification'],
		);
	update_option('spamfree_options', $spamfree_options_update);		
		

	}
	
function spamfree_count() {
	$spamfree_count = get_option('spamfree_count');	
	return $spamfree_count;
	}

function spamfree_comment_form() {
	$spamfree_options			= get_option('spamfree_options');
	$FormValidationFieldJS 	= $spamfree_options['form_validation_field_js'];
	$FormValidationKeyJS 		= $spamfree_options['form_validation_key_js'];
	echo '<script type=\'text/javascript\'>'."\n";
	echo 'document.write("<input type=\'hidden\' id=\''.$FormValidationFieldJS.'\' name=\''.$FormValidationFieldJS.'\' value=\''.$FormValidationKeyJS.'\'>");'."\n";
	echo '</script>'."\n";
	echo '<noscript><p><strong>Currently you have JavaScript disabled. In order to post comments, please make sure JavaScript and Cookies are enabled, and reload the page.</strong></p></noscript>';
	}
	
function spamfree_check_comment_type($commentdata) {
	if ( $commentdata['comment_type'] != 'trackback' && $commentdata['comment_type'] != 'pingback' ) {
		add_filter('pre_comment_approved', 'spamfree_allowed_post');
		}
	return $commentdata;
	}

function spamfree_allowed_post($approved) {
	// CHECK COOKIE TO PREVENT COMMENT SPAM FROM BOTS :: BEGIN
	$spamfree_options			= get_option('spamfree_options');
	$CookieValidationName  		= $spamfree_options['cookie_validation_name'];
	$CookieValidationKey 		= $spamfree_options['cookie_validation_key'];
	$FormValidationFieldJS 		= $spamfree_options['form_validation_field_js'];
	$FormValidationKeyJS 		= $spamfree_options['form_validation_key_js'];
	$WPCommentValidationJS 		= $_COOKIE[$CookieValidationName];
	$WPFormValidationPost 		= $_POST[$FormValidationFieldJS]; //Comments Post Verification	
	if($WPCommentValidationJS==$CookieValidationKey&&$WPFormValidationPost==$FormValidationKeyJS) {
		// Clear Key Values and Update
		spamfree_update_keys(1);
		return $approved;
		}
	else {
		// Update Count
		update_option( 'spamfree_count', get_option('spamfree_count') + 1 );	
    	wp_die( __('Sorry, there was an error. Please enable JavaScript and Cookies in your browser and try again.') );
		return false;
		}
	// CHECK COOKIE TO PREVENT COMMENT SPAM FROM BOTS :: END
	}

function spamfree_stats() {
	$spamfree_count = get_option('spamfree_count');
	if ( !$spamfree_count )
		return;
	echo '<h3>'.__('WP-SpamFree').'</h3>';
	
	echo '<p>'.sprintf(__('<a href="%1$s" target="_blank">WP-SpamFree</a> has protected your site from <strong>%2$s</strong> spam comments.'), 'http://www.hybrid6.com/webgeek/plugins/wp-spamfree/',  number_format($spamfree_count) ).'</p>';
	}

if (!class_exists('wpSpamFree')) {
    class wpSpamFree {
	
		/**
		* @var string   The name the options are saved under in the database.
		*/
		var $adminOptionsName = 'wp_spamfree_options';
		
		/**
		* @var string   The name of the database table used by the plugin
		*/	
		var $db_table_name = 'wp_spamfree';
		
		
		/**
		* PHP 4 Compatible Constructor
		*/
		//function wpSpamFree(){$this->__construct();}

		/**
		* PHP 5 Constructor
		*/		
		//function __construct(){

		function wpSpamFree(){
			
			global $wpdb;
						
			error_reporting(0); // Prevents errors when page is accessed directly, outside WordPress
			
			register_activation_hook(__FILE__,array(&$this,'install_on_activation'));
			add_action('init', 'spamfree_init');
			add_action('admin_menu', array(&$this,'add_admin_pages'));
			add_action('wp_head', array(&$this, 'wp_head_intercept'));
			add_action('comment_form', 'spamfree_comment_form');
			add_action('preprocess_comment', 'spamfree_check_comment_type',1);
			add_action('activity_box_end', 'spamfree_stats');
        	}
		
		function add_admin_pages(){
			add_submenu_page("plugins.php","WP-SpamFree","WP-SpamFree",10, __FILE__, array(&$this,"output_existing_menu_sub_admin_page"));
			}
		
		function output_existing_menu_sub_admin_page(){
			$wpSpamFreeVer=get_option('wp_spamfree_version');
			if ($wpSpamFreeVer!='') {
				$wpSpamFreeVerAdmin='Version '.$wpSpamFreeVer;
				}
			$spamCount=spamfree_count();
			?>
			<div class="wrap">
			<h2>WP-SpamFree</h2>
			<?php
			if ($spamCount) {
				echo "<p>Since we started counting, WP-SpamFree has protected your blog from <strong>".number_format($spamCount)."</strong> spam comments!</p>
				<p>&nbsp;</p>";
				}
			?>
			
			
			
			<p><strong>Installation Instructions</strong></p>

			<ol>
			    <li>After downloading, unzip file and upload the enclosed 'wp-spamfree' directory to your WordPress plugins directory: '/wp-content/plugins/'.<br />&nbsp;</li>
				<li>As always, <strong>activate</strong> the plugin on your WordPress plugins page.</li>
			</ol>	
			<p>&nbsp;</p>
			<p>You're done! Sit back and see what it feels like to blog without comment spam!</p>
					
			<p>&nbsp;</p>
	
			<p><strong>Troubleshooting</strong></p>
			If you're having trouble getting things to work after installing the plugin, here are a few things to check:
			<ol>
				<li>If you haven't yet, please upgrade to the latest version.<br />&nbsp;</li>
				<li>Clear your browser's cache, clear your cookies, and restart your browser. Then reload the page.<br />&nbsp;</li>
				<li>Make sure <em>JavaScript</em> and <em>cookies</em> are enabled. (JavaScript is different from Java. Java is not required.)<br />&nbsp;</li>
				<li>If have checked these, and still can't quite get it working, please either post a support request in the comments section of the <a href="http://www.hybrid6.com/webgeek/2007/11/wp-spamfree-1-wordpress-plugin-released.php" target="_blank">WP-SpamFree release announcement</a> blog post, or <a href="mailto:scott@hybrid6.com?subject=WP-SpamFree Support Request">send an email</a>.</li>
			</ol>
			<p>&nbsp;</p>			

			
			
  			<p>For updates and documentation, visit the homepage of the WP-SpamFree Plugin at: <a href="http://www.hybrid6.com/webgeek/plugins/wp-spamfree/" target="_blank">http://www.hybrid6.com/webgeek/plugins/wp-spamfree/</a></p>
	
			<p>&nbsp;</p>
	
			<p><strong>How does it feel to blog without being bombarded by automated comment spam?</strong> If you're happy with WP-SpamFree, feel free to <a href="http://www.hybrid6.com/webgeek/2007/11/wp-spamfree-1-wordpress-plugin-released.php#comments" target="_blank">post a comment letting others know!</a></p>
	
			<p>&nbsp;</p>
			
			<strong>Download Plugin / Documentation</strong><br />
			Latest Version: <a href="http://www.hybrid6.com/webgeek/downloads/wp-spamfree.zip" target="_blank">Download Now</a><br />
			Plugin Homepage / Documentation: <a href="http://www.hybrid6.com/webgeek/plugins/wp-spamfree/">WP-SpamFree</a><br />
			Blog Post: <a href="http://www.hybrid6.com/webgeek/2007/11/wp-spamfree-1-wordpress-plugin-released.php">WP-SpamFree Release Announcement</a><br />
			WordPress.org Page: <a href="http://wordpress.org/extend/plugins/wp-spamfree/" target="_blank">WP-SpamFree</a>
	
			<p>&nbsp;</p>

			<p><em><?php echo $wpSpamFreeVerAdmin; ?></em></p>
	
			<p>&nbsp;</p>
			</div>
			<?php
			}

		function wp_head_intercept(){
			$wpSpamFreeVer=get_option('wp_spamfree_version');
			if ($wpSpamFreeVer!='') {
				$wpSpamFreeVerJS=' v'.$wpSpamFreeVer;
				}
			echo '<!-- WP-SpamFree'.$wpSpamFreeVerJS.' JS Code :: BEGIN -->'."\n";
			echo '<script type="text/javascript" src="'.get_option('siteurl').'/wp-content/plugins/wp-spamfree/js/wpSpamFreeJS.php"></script> '."\n";
			echo '<!-- WP-SpamFree'.$wpSpamFreeVerJS.' JS Code :: END -->'."\n";
			}
			
		function install_on_activation() {
			global $wpdb;
			$plugin_db_version = "1.5.2";
			$installed_ver = get_option('wp_spamfree_version');
			//only run installation if not installed or if previous version installed
			if ($installed_ver === false || $installed_ver != $plugin_db_version) {
			
				//add a database version number for future upgrade purposes
				update_option('wp_spamfree_version', $plugin_db_version);
				
				// Set Random Cookie Name
				$randomComValCodeCVN1 = spamfree_create_random_key();
				$randomComValCodeCVN2 = spamfree_create_random_key();
				$CookieValidationName = strtoupper($randomComValCodeCVN1.$randomComValCodeCVN2);
				// Set Random Cookie Value
				$randomComValCodeCKV1 = spamfree_create_random_key();
				$randomComValCodeCKV2 = spamfree_create_random_key();
				$CookieValidationKey = $randomComValCodeCKV1.$randomComValCodeCKV2;
				// Set Random Form Field Name
				$randomComValCodeJSFFN1 = spamfree_create_random_key();
				$randomComValCodeJSFFN2 = spamfree_create_random_key();
				$FormValidationFieldJS = $randomComValCodeJSFFN1.$randomComValCodeJSFFN2;
				// Set Random Form Field Value
				$randomComValCodeJS1 = spamfree_create_random_key();
				$randomComValCodeJS2 = spamfree_create_random_key();
				$FormValidationKeyJS = $randomComValCodeJS1.$randomComValCodeJS2;

				// Options array
				$spamfree_options_update = array (
					'cookie_validation_name' 		=> $CookieValidationName,
					'cookie_validation_key' 		=> $CookieValidationKey,
					'form_validation_field_js' 		=> $FormValidationFieldJS,
					'form_validation_key_js' 		=> $FormValidationKeyJS,
					'wp_cache' 						=> 0,
					'wp_super_cache' 				=> 0,
					'use_captcha_backup' 			=> 0,
					'block_all_trackbacks' 			=> 0,
					'block_all_pingbacks' 			=> 0,
					'use_trackback_verification' 	=> 0,
					);
				$spamfree_count = get_option('spamfree_count');
				if (!$spamfree_count) {
					update_option("spamfree_count", 0);
					}
				update_option('spamfree_options', $spamfree_options_update);

				}
			}
					
		}
	}



//instantiate the class
if (class_exists('wpSpamFree')) {
	$wpSpamFree = new wpSpamFree();
	}

?>