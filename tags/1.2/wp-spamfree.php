<?php
/*
Plugin Name: WP-SpamFree
Plugin URI: http://www.hybrid6.com/webgeek/plugins/wp-spamfree/
Description: A powerful anti-spam plugin that virtually eliminates automated comment spam from bots. Finally, you can enjoy a spam-free WordPress blog!
Author: Scott Allen, aka WebGeek
Version: 1.2
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

if (!class_exists('wgSpamFree')) {
    class wgSpamFree {

	    function wgSpamFree(){
		add_action("admin_menu", array(&$this,"add_admin_pages"));
		add_action('wp_head', array(&$this, 'wp_head_intercept'));
        }
	
		function add_admin_pages(){
		add_submenu_page("plugins.php","WP-SpamFree","WP-SpamFree",10, __FILE__, array(&$this,"output_existing_menu_sub_admin_page"));
		}
		
		function output_existing_menu_sub_admin_page(){
		?>
			<div class="wrap">
			<h2>WP-SpamFree</h2>
			
			<p><strong>Installation Instructions</strong></p>

<ol>
    <li>After downloading, unzip file and upload the enclosed 'wp-spamfree' directory to your WordPress plugins directory: '/wp-content/plugins/'.<br />&nbsp;</li>
	<li>Open <strong>wp-comments-post.php</strong> in the root directory of your WordPress install. Near the beginning of the file and <strong>immediately</strong> after the line with <strong>nocache_headers();</strong> (located somewhere around lines 4-10), add this line to your code:<br /><br />
	
	<code>include( dirname(__FILE__) . "/wp-content/plugins/wp-spamfree/inc-commentvalidation.php" );</code><br />&nbsp;</li>
	<li>As always, <strong>activate</strong> the plugin on your WordPress plugins page.</li>
</ol>	

<p>You're done! Sit back and see what it feels like to live without comment spam!</p>

<p><strong>Note:</strong> Each time you upgrade WordPress, be sure to repeat step #2 after the update, as it will have overwritten your changes to <strong>wp-comments-post.php</strong>.</p>
					
	<p>&nbsp;</p>
	
	<p><strong>Troubleshooting</strong></p>
If you're having trouble getting things to work after installing the plugin, here are a few things to check:
<ol>
<li>If you haven't yet, please upgrade to the latest version.<br />&nbsp;</li>
<li>Clear your browser's cache and clear your cookies. Then reload the page.<br />&nbsp;</li>
<li>Make sure <em>JavaScript</em> and <em>cookies</em> are enabled. (JavaScript is different from Java. Java is not required.)<br />&nbsp;</li>
<li>If you have JavaScript and cookies enabled, and get a WordPress error message of &ldquo;Sorry, there was an error. Please enable JavaScript and Cookies in your browser and try again.&rdquo;, then there may be a JavaScript conflict that is preventing the WP-SpamFree code from setting a cookie. If you are familiar with JavaScript, view the source code of your page. JavaScript code containing "window.onload" that appears after the line of code calling the wpSpamFree.js file may be conflicting with the WP-SpamFree code.<br />&nbsp;</li>
<li>If you have recently upgraded WordPress, you will need to repeat step #2 from the installation instructions, as the update will have overwritten your changes to <strong>wp-comments-post.php</strong>.<br />&nbsp;</li>
<li>If have checked these, and still can't quite get it working, please either post a support request in the comments section of the <a href="http://www.hybrid6.com/webgeek/2007/11/wp-spamfree-1-wordpress-plugin-released.php" target="_blank">WP-SpamFree release announcement</a> blog post, or <a href="mailto:scott@hybrid6.com?subject=WP-SpamFree Support Request">send an email</a>.</li>
</ol>
<p>&nbsp;</p>			

			
			
  	<p>For updates and documentation, visit the homepage of the WP-SpamFree Plugin at: <a href="http://www.hybrid6.com/webgeek/plugins/wp-spamfree/" target="_blank">http://www.hybrid6.com/webgeek/plugins/wp-spamfree/</a></p>
	
	<p>&nbsp;</p>
	
	<p><strong>How does it feel to live without automated comment spam?</strong> If you're happy with WP-SpamFree, feel free to <a href="http://www.hybrid6.com/webgeek/2007/11/wp-spamfree-1-wordpress-plugin-released.php#comments" target="_blank">post a comment letting others know!</a></p>
	
	<p>&nbsp;</p>
	
	<p><em>Version 1.2</em></p>
	
			<p>&nbsp;</p>
			</div>
		<?php
		}


function wp_head_intercept(){
	echo '<script type="text/javascript" src="'.get_option('siteurl').'/wp-content/plugins/wp-spamfree/js/wpSpamFree.js"></script>';
}


    }
}

//instantiate the class
if (class_exists('wgSpamFree')) {
	$wgSpamFree = new wgSpamFree();
}

?>