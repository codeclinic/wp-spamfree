<?php
/*
Plugin Name: WP-SpamFree
Plugin URI: http://www.hybrid6.com/webgeek/plugins/wp-spamfree/
Description: A powerful anti-spam plugin that virtually eliminates automated comment spam from bots. Finally, you can enjoy a spam-free WordPress blog!
Author: Scott Allen, aka WebGeek
Version: 1.3
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

// Prevent Spammers from overloading server - Set Delay
define('SPAMFREE_DELAY', 10);

function spamfree_init() {
	session_start();
	$wpSpamFreeVer="1.3";
	$_SESSION["wpSpamFreeVer"]=$wpSpamFreeVer;
	if (!isset($_SESSION["ServerRequestTime"])) {
		$_SESSION["ServerRequestTime"]=$_SERVER['REQUEST_TIME'];
		}

	if (!isset($_SESSION["FormValidationKeyJS"])) {
		$randomComValCodeJS1 = createRandomKey();
		$randomComValCodeJS2 = createRandomKey();
		$FormValidationKeyJS = $randomComValCodeJS1.'x16x'.$randomComValCodeJS2;
		$_SESSION["FormValidationKeyJS"]=$FormValidationKeyJS;
		}

	}
	
function createRandomKey() {
    $chars = "abcdefghijkmnopqrstuvwxyz023456789";
    srand((double)microtime()*1000000);
    $i = 0;
    $pass = '' ;

    while ($i <= 7) {
        $num = rand() % 33;
        $tmp = substr($chars, $num, 1);
        $keyCode = $keyCode . $tmp;
        $i++;
    }
    return $keyCode;
}

function spamfree_reset_key() {
	$_SESSION["FormValidationKeyJS"]='';
	$WPFormValidationKeyJS='';
	}

function spamfree_comment_form() {
	//$randomComValCodeJS1 = createRandomKey();
	//$randomComValCodeJS2 = createRandomKey();
	//$FormValidationKeyJS = $randomComValCodeJS1.'x16x'.$randomComValCodeJS2;
	//$_SESSION["FormValidationKeyJS"]=$FormValidationKeyJS;
	echo '<script type="text/javascript">'."\n";
	echo 'document.write(\'<input type="hidden" id="comment_post_verification_sf" name="comment_post_verification_sf" value="'.$_SESSION["FormValidationKeyJS"].'">\');'."\n";
	echo '</script>'."\n";
	echo '<noscript><p>Currently you have JavaScript disabled. In order to post comments, please make sure JavaScript and Cookies are enabled, and reload the page.</p></noscript>';
	}

function spamfree_allowed_post($approved) {
	// CHECK COOKIE TO PREVENT COMMENT SPAM FROM BOTS :: BEGIN
	$WPCommentValidationJS=$_COOKIE['WPCOMVALJ'];
	$WPFormValidationKeyJS=$_POST['comment_post_verification_sf'];	
	//	if($WPCommentValidationJS=='xTJ97pDzW3'&&$WPFormValidationKeyJS==$_SESSION["FormValidationKeyJS"]&&eregi('x16x',$WPFormValidationKeyJS)&&$_SESSION["FormValidationKeyJS"]!='') {
	if($WPCommentValidationJS=='xTJ97pDzW3') {
		//spamfree_reset_key();
		return $approved;
		}
	else {
		// STATUS VERIFICATION
		echo $WPCommentValidationJS."<br>";
		echo $_COOKIE['WPCOMVALJ']."<br>";
		echo $WPFormValidationKeyJS."<br>";
		echo $_POST['comment_post_verification_sf']."<br>";
		echo $_SESSION["FormValidationKeyJS"]."<br>";
		
		
		
		//spamfree_reset_key();
		//sleep(SPAMFREE_DELAY);
    	wp_die( __('Sorry, there was an error. Please enable JavaScript and Cookies in your browser and try again.') );
		return false;
		}
	// CHECK COOKIE TO PREVENT COMMENT SPAM FROM BOTS :: END
	}

if (!class_exists('wpSpamFree')) {
    class wpSpamFree {

	    function wpSpamFree(){
		add_action('init', 'spamfree_init');
		add_action('admin_menu', array(&$this,'add_admin_pages'));
		add_action('wp_head', array(&$this, 'wp_head_intercept'));
		add_action('comment_form', 'spamfree_comment_form');
		add_action('pre_comment_approved', 'spamfree_allowed_post');
        }

		function add_admin_pages(){
		add_submenu_page("plugins.php","WP-SpamFree","WP-SpamFree",10, __FILE__, array(&$this,"output_existing_menu_sub_admin_page"));
		}
		
		function output_existing_menu_sub_admin_page(){
			$wpSpamFreeVer=$_SESSION["wpSpamFreeVer"];
			if ($_SESSION["wpSpamFreeVer"]!='') {
				$wpSpamFreeVerAdmin='Version '.$wpSpamFreeVer;
				}
		?>
			<div class="wrap">
			<h2>WP-SpamFree</h2>
			
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
<li>Clear your browser's cache and clear your cookies. Then reload the page.<br />&nbsp;</li>
<li>Make sure <em>JavaScript</em> and <em>cookies</em> are enabled. (JavaScript is different from Java. Java is not required.)<br />&nbsp;</li>
<li>If have checked these, and still can't quite get it working, please either post a support request in the comments section of the <a href="http://www.hybrid6.com/webgeek/2007/11/wp-spamfree-1-wordpress-plugin-released.php" target="_blank">WP-SpamFree release announcement</a> blog post, or <a href="mailto:scott@hybrid6.com?subject=WP-SpamFree Support Request">send an email</a>.</li>
</ol>
<p>&nbsp;</p>			

			
			
  	<p>For updates and documentation, visit the homepage of the WP-SpamFree Plugin at: <a href="http://www.hybrid6.com/webgeek/plugins/wp-spamfree/" target="_blank">http://www.hybrid6.com/webgeek/plugins/wp-spamfree/</a></p>
	
	<p>&nbsp;</p>
	
	<p><strong>How does it feel to blog without being bombarded by automated comment spam?</strong> If you're happy with WP-SpamFree, feel free to <a href="http://www.hybrid6.com/webgeek/2007/11/wp-spamfree-1-wordpress-plugin-released.php#comments" target="_blank">post a comment letting others know!</a></p>
	
	<p>&nbsp;</p>
	
	<p><em><?=$wpSpamFreeVerAdmin?></em></p>
	
			<p>&nbsp;</p>
			</div>
		<?php
		}


		function wp_head_intercept(){
			$wpSpamFreeVer=$_SESSION["wpSpamFreeVer"];
			if ($_SESSION["wpSpamFreeVer"]!='') {
				$wpSpamFreeVerJS=' v'.$wpSpamFreeVer;
				}
			echo '<!-- WP-SpamFree'.$wpSpamFreeVerJS.' JS Code :: BEGIN -->'."\n";
			echo '<script type="text/javascript" src="'.get_option('siteurl').'/wp-content/plugins/wp-spamfree/js/wpSpamFree.js"></script> '."\n";
			echo '<!-- WP-SpamFree'.$wpSpamFreeVerJS.' JS Code :: END -->'."\n";
			}

    }
}


//instantiate the class
if (class_exists('wpSpamFree')) {
	$wpSpamFree = new wpSpamFree();
}

?>