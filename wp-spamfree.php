<?php
/*
Plugin Name: WP-SpamFree
Plugin URI: http://www.hybrid6.com/webgeek/plugins/wp-spamfree
Description: An extremely powerful anti-spam plugin that virtually eliminates comment spam. Finally, you can enjoy a spam-free WordPress blog! Includes spam-free contact form feature as well.
Author: Scott Allen, aka WebGeek
Version: 1.8.2
Author URI: http://www.hybrid6.com/webgeek/
*/

/*  Copyright 2007-2008    Scott Allen  (email : scott [at] hybrid6 [dot] com)

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

// Begin the Plugin

function spamfree_init() {
	$wpSpamFreeVer='1.8.2';
	update_option('wp_spamfree_version', $wpSpamFreeVer);
	spamfree_update_keys(0);
	}
	
function spamfree_create_random_key() {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
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

	// Set Random Cookie Name
	$CookieValidationName = $spamfree_options['cookie_validation_name'];
	if (!$CookieValidationName||$reset_keys==1) {
		$randomComValCodeCVN1 = spamfree_create_random_key();
		$randomComValCodeCVN2 = spamfree_create_random_key();
		$CookieValidationName = $randomComValCodeCVN1.$randomComValCodeCVN2;
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
		'form_include_website' 			=> $spamfree_options['form_include_website'],
		'form_require_website' 			=> $spamfree_options['form_require_website'],
		'form_include_phone' 			=> $spamfree_options['form_include_phone'],
		'form_require_phone' 			=> $spamfree_options['form_require_phone'],
		'form_message_width' 			=> $spamfree_options['form_message_width'],
		'form_message_height' 			=> $spamfree_options['form_message_height'],
		'form_message_min_length'		=> $spamfree_options['form_message_min_length'],
		);
	update_option('spamfree_options', $spamfree_options_update);		
	}
	
function spamfree_count() {
	$spamfree_count = get_option('spamfree_count');	
	return $spamfree_count;
	}
	

function spamfree_counter($counter_option) {
	$counter_option_max = 6;
	if ( !$counter_option || $counter_option > $counter_option_max ) {
		exit;
		}
	// Display Counter
	/* Implementation: <?php if ( function_exists(spamfree_counter) ) { spamfree_counter(1); } ?> */
	$spamfree_count = number_format( get_option('spamfree_count') );
	$counter_div_height = array('0','66','66','66','106','61','67');
	$counter_count_padding_top = array('0','11','11','11','79','14','17');
	?>
	
	<style type="text/css">
	
	#spamfree_counter_wrap {color:#ffffff;text-decoration:none;width:140px;}
	#spamfree_counter {background:url(<?php echo get_option('siteurl'); ?>/wp-content/plugins/wp-spamfree/counter/spamfree-counter-bg-<?php echo $counter_option; ?>.png) no-repeat top left;height:<?php echo $counter_div_height[$counter_option]; ?>px;width:140px;overflow:hidden;border-style:none;color:#ffffff;Arial,Helvetica,sans-serif;font-weight:bold;line-height:100%;text-align:center;padding-top:<?php echo $counter_count_padding_top[$counter_option]; ?>px;}
	
	</style>
	
	<div id="spamfree_counter_wrap" >
		<div id="spamfree_counter" >
		<?php 
			if ( $counter_option >= 1 && $counter_option <= 3 ) {
				echo '<strong style="color:#ffffff;font:Arial,Helvetica,sans-serif;font-weight:bold;line-height:100%;text-align:center;text-decoration:none;border-style:none;"><a href="http://www.hybrid6.com/webgeek/plugins/wp-spamfree" style="color:#ffffff;font:Arial,Helvetica,sans-serif;font-weight:bold;text-decoration:none;border-style:none;" rel="external" target="_blank" title="Spam Killed by WP-SpamFree" >';
				echo '<span style="color:#ffffff;font-size:20px;line-height:100%;font:Arial,Helvetica,sans-serif;font-weight:bold;text-decoration:none;border-style:none;">'.$spamfree_count.'</span><br />'; 
				echo '<span style="color:#ffffff;font-size:14px;line-height:110%;font:Arial,Helvetica,sans-serif;font-weight:bold;text-decoration:none;border-style:none;">SPAM KILLED</span><br />'; 
				echo '<span style="color:#ffffff;font-size:9px;line-height:120%;font:Arial,Helvetica,sans-serif;font-weight:bold;text-decoration:none;border-style:none;">BY WP-SPAMFREE</span>';
				echo '</a></strong>'; 
				}
			else if ( $counter_option == 4 ) {
				echo '<strong style="color:#000000;font:Arial,Helvetica,sans-serif;font-weight:bold;line-height:100%;text-align:center;text-decoration:none;border-style:none;"><a href="http://www.hybrid6.com/webgeek/plugins/wp-spamfree" style="color:#000000;font:Arial,Helvetica,sans-serif;font-weight:bold;text-decoration:none;border-style:none;" rel="external" target="_blank" title="Spam Killed by WP-SpamFree" >';
				echo '<span style="color:#000000;font-size:9px;line-height:100%;font:Arial,Helvetica,sans-serif;font-weight:bold;text-decoration:none;border-style:none;">'.$spamfree_count.' SPAM KILLED</span><br />'; 
				echo '</a></strong>'; 
				}
			else if ( $counter_option == 5 ) {
				echo '<strong style="color:#FEB22B;font:Arial,Helvetica,sans-serif;font-weight:bold;line-height:100%;text-align:center;text-decoration:none;border-style:none;"><a href="http://www.hybrid6.com/webgeek/plugins/wp-spamfree" style="color:#FEB22B;font:Arial,Helvetica,sans-serif;font-weight:bold;text-decoration:none;border-style:none;" rel="external" target="_blank" title="Spam Killed by WP-SpamFree" >';
				echo '<span style="color:#FEB22B;font-size:14px;line-height:100%;font:Arial,Helvetica,sans-serif;font-weight:bold;text-decoration:none;border-style:none;">'.$spamfree_count.'</span><br />'; 
				echo '</a></strong>'; 
				}
			else if ( $counter_option == 6 ) {
				echo '<strong style="color:#000000;font:Arial,Helvetica,sans-serif;font-weight:bold;line-height:100%;text-align:center;text-decoration:none;border-style:none;"><a href="http://www.hybrid6.com/webgeek/plugins/wp-spamfree" style="color:#000000;font:Arial,Helvetica,sans-serif;font-weight:bold;text-decoration:none;border-style:none;" rel="external" target="_blank" title="Spam Killed by WP-SpamFree" >';
				echo '<span style="color:#000000;font-size:14px;line-height:100%;font:Arial,Helvetica,sans-serif;font-weight:bold;text-decoration:none;border-style:none;">'.$spamfree_count.'</span><br />'; 
				echo '</a></strong>'; 
				}

		?>
		</div>
	</div>
	
	<?php
	}

function spamfree_comment_form() {
	$spamfree_options			= get_option('spamfree_options');
	$FormValidationFieldJS 		= $spamfree_options['form_validation_field_js'];
	$FormValidationKeyJS 		= $spamfree_options['form_validation_key_js'];
	update_option( 'ak_count_pre', get_option('akismet_spam_count') );

	echo '<script type=\'text/javascript\'>'."\n";
	echo '//<![CDATA['."\n";
	echo 'document.write("<input type=\'hidden\' id=\''.$FormValidationFieldJS.'\' name=\''.$FormValidationFieldJS.'\' value=\''.$FormValidationKeyJS.'\' />");'."\n";
	echo '//]]>'."\n";
	echo '</script>'."\n";
	echo '<noscript><p><strong>Currently you have JavaScript disabled. In order to post comments, please make sure JavaScript and Cookies are enabled, and reload the page.</strong></p></noscript>';
	}
	
function spamfree_contact_form($content) {
	$spamfree_contact_form_url = $_SERVER['REQUEST_URI'];
	if ( $_SERVER['QUERY_STRING'] ) {
		$spamfree_contact_form_query_op = '&';
		}
	else {
		$spamfree_contact_form_query_op = '?';
		}
	$spamfree_contact_form_content = '';
	if ( is_page() && ( !is_home() && !is_feed() && !is_archive() && !is_search() && !is_404() ) ) {

		$spamfree_options			= get_option('spamfree_options');
		$CookieValidationName  		= $spamfree_options['cookie_validation_name'];
		$CookieValidationKey 		= $spamfree_options['cookie_validation_key'];
		$FormValidationFieldJS 		= $spamfree_options['form_validation_field_js'];
		$FormValidationKeyJS 		= $spamfree_options['form_validation_key_js'];
		$WPCommentValidationJS 		= $_COOKIE[$CookieValidationName];
		$WPFormValidationPost 		= $_POST[$FormValidationFieldJS]; //Comments Post Verification
		
		$FormIncludeWebsite			= $spamfree_options['form_include_website'];
		$FormRequireWebsite			= $spamfree_options['form_require_website'];
		$FormIncludePhone			= $spamfree_options['form_include_phone'];
		$FormRequirePhone			= $spamfree_options['form_require_phone'];
		$FormMessageWidth			= $spamfree_options['form_message_width'];
		$FormMessageHeight			= $spamfree_options['form_message_height'];
		$FormMessageMinLength		= $spamfree_options['form_message_min_length'];
		
		if ( $FormMessageWidth < 40 ) {
			$FormMessageWidth = 40;
			}
			
		if ( $FormMessageHeight < 5 ) {
			$FormMessageHeight = 5;
			}
		else if ( !$FormMessageHeight ) {
			$FormMessageHeight = 10;
			}
			
		if ( $FormMessageMinLength < 15 ) {
			$FormMessageMinLength = 15;
			}
		else if ( !$FormMessageMinLength ) {
			$FormMessageMinLength = 25;
			}

		if ( $_GET['form'] == 'response' ) {
		
			// PROCESSING CONTACT FORM :: BEGIN
			$wpsf_contact_name 		= Trim(stripslashes(strip_tags($_POST['wpsf_contact_name'])));
			$wpsf_contact_email 	= Trim(stripslashes(strip_tags($_POST['wpsf_contact_email'])));
			$wpsf_contact_website 	= Trim(stripslashes(strip_tags($_POST['wpsf_contact_website'])));
			$wpsf_contact_phone 	= Trim(stripslashes(strip_tags($_POST['wpsf_contact_phone'])));
			$wpsf_contact_subject 	= Trim(stripslashes(strip_tags($_POST['wpsf_contact_subject'])));
			$wpsf_contact_message 	= Trim(stripslashes(strip_tags($_POST['wpsf_contact_message'])));
			// PROCESSING CONTACT FORM :: END
			
			// FORM INFO :: BEGIN
			$wpsf_contact_form_to = get_option('admin_email');
			$wpsf_contact_form_to_name = $wpsf_contact_form_to;
			$wpsf_contact_form_subject = $wpsf_contact_subject;
			$wpsf_contact_form_msg_headers = "From: $wpsf_contact_name <$wpsf_contact_email>" . "\r\n" . "X-Mailer: PHP/" . phpversion();
			// FORM INFO :: END
			
			// TEST TO PREVENT CONTACT FORM SPAM FROM BOTS :: BEGIN
			
			if( $WPCommentValidationJS == $CookieValidationKey && $WPFormValidationPost == $FormValidationKeyJS ) { // Contact Form Message Allowed

				// ERROR CHECKING
							
				if ( !$wpsf_contact_name || !$wpsf_contact_email || !$wpsf_contact_subject || !$wpsf_contact_message || ( $FormIncludeWebsite && $FormRequireWebsite && !$wpsf_contact_website ) || ( $FormIncludePhone && $FormRequirePhone && !$wpsf_contact_phone ) ) {
					$BlankField=1;
					$contact_response_status_message_addendum .= '&bull; At least one required field was left blank.<br />&nbsp;<br />';
					}
					
				if (!eregi("^([-_\.a-z0-9])+@([-a-z0-9]+\.)+([a-z]{2}|com|net|org|edu|gov|mil|int|biz|pro|info|arpa|aero|coop|name|museum)$",$wpsf_contact_email)) {
					$InvalidValue=1;
					$BadEmail=1;
					$contact_response_status_message_addendum .= '&bull; Please enter a valid email address.<br />&nbsp;<br />';
					}
					
				$MessageLength = strlen( $wpsf_contact_message );
				if ( $MessageLength < $FormMessageMinLength ) {
					$MessageShort=1;
					$contact_response_status_message_addendum .= '&bull; Message too short. Please enter a complete message.<br />&nbsp;<br />';
					}
				
				if ( !$BlankField && !$InvalidValue && !$MessageShort ) {  
				
					$wpsf_contact_form_msg .= "Message: $wpsf_contact_message"."\n";
					
					$wpsf_contact_form_msg .= "\n";
				
					$wpsf_contact_form_msg .= "Name: $wpsf_contact_name"."\n";
					$wpsf_contact_form_msg .= "Email: $wpsf_contact_email"."\n";
					if ( $FormIncludePhone ) {
						$wpsf_contact_form_msg .= "Phone: $wpsf_contact_phone"."\n";
						}
					if ( $FormIncludeWebsite ) {
						$wpsf_contact_form_msg .= "Website: $wpsf_contact_website"."\n";
						}
					$wpsf_contact_form_msg .= "\n";					
					$wpsf_contact_form_msg .= "User-Agent (Browser/OS): ".$_SERVER['HTTP_USER_AGENT']."\n";
					$wpsf_contact_form_msg .= "\n";
					$wpsf_contact_form_msg .= "Referrer: ".$_SERVER['HTTP_REFERER']."\n";
					$wpsf_contact_form_msg .= "\n";
					$wpsf_contact_form_msg .= "IP Address: ".$_SERVER['REMOTE_ADDR']."\n";
					$wpsf_contact_form_msg .= "Server: ".$_SERVER['REMOTE_HOST']."\n";
					$wpsf_contact_form_msg .= "Reverse DNS: ".gethostbyaddr($_SERVER['REMOTE_ADDR'])."\n";
					$wpsf_contact_form_msg .= "IP Address Lookup: http://www.dnsstuff.com/tools/ipall.ch?ip=".$_SERVER['REMOTE_ADDR']."\n";
					$wpsf_contact_form_msg .= "\n";
					$wpsf_contact_form_msg .= "\n";
					
					// SEND MESSAGE
					mail( $wpsf_contact_form_to, $wpsf_contact_subject, $wpsf_contact_form_msg, $wpsf_contact_form_msg_headers );
					
					$contact_response_status = 'thank-you';
					
					}
				
				}
			// TEST TO PREVENT CONTACT FORM SPAM FROM BOTS :: END
		
			if ( $contact_response_status == 'thank-you' ) {
				$spamfree_contact_form_content .= '<p>Your message was sent successfully. Thank you.<p>&nbsp;</p>'."\n";
				}
			else {
				if ( eregi ( '\&form\=response', $spamfree_contact_form_url ) ) {
					$spamfree_contact_form_back_url = str_replace('&form=response','',$spamfree_contact_form_url );
					}
				else if ( eregi ( '\?form\=response', $spamfree_contact_form_url ) ) {
					$spamfree_contact_form_back_url = str_replace('?form=response','',$spamfree_contact_form_url );
					}
				$contact_response_status_message_addendum .= '<noscript><br />&nbsp;<br />&bull; Currently you have JavaScript disabled.</noscript>';
				$spamfree_contact_form_content .= '<p><strong>Please return to the <a href="'.$spamfree_contact_form_back_url.'" >contact form</a> and fill out all required fields. Please make sure JavaScript and Cookies are enabled in your browser.<br />&nbsp;<br />'.$contact_response_status_message_addendum.'</strong><p>&nbsp;</p>'."\n";
				}
			$content_new = str_replace($content, $spamfree_contact_form_content, $content);
			}
		else {		
			$spamfree_contact_form_content .= '<div id="wpsf" name="wpsf">';
			$spamfree_contact_form_content .= '<form action="'.$spamfree_contact_form_url.$spamfree_contact_form_query_op.'form=response" method="post" style="text-align:left;" >'."\n";

			$spamfree_contact_form_content .= '<p><label><strong>Name</strong> *<br />'."\n";

			$spamfree_contact_form_content .= '<input type="text" id="wpsf_contact_name" name="wpsf_contact_name" value="" size="40" /> </label></p>'."\n";
			$spamfree_contact_form_content .= '<p><label><strong>Email</strong> *<br />'."\n";
			$spamfree_contact_form_content .= '<input type="text" id="wpsf_contact_email" name="wpsf_contact_email" value="" size="40" /> </label></p>'."\n";
			
			if ( $FormIncludeWebsite ) {
				$spamfree_contact_form_content .= '<p><label><strong>Website</strong> ';
				if ( $FormRequireWebsite ) { 
					$spamfree_contact_form_content .= '*'; 
					}
				$spamfree_contact_form_content .= '<br />'."\n";
				$spamfree_contact_form_content .= '<input type="text" id="wpsf_contact_website" name="wpsf_contact_website" value="" size="40" /> </label></p>'."\n";
				}
				
			if ( $FormIncludePhone ) {
				$spamfree_contact_form_content .= '<p><label><strong>Phone</strong> ';
				if ( $FormRequirePhone ) { 
					$spamfree_contact_form_content .= '*'; 
					}
				$spamfree_contact_form_content .= '<br />'."\n";
				$spamfree_contact_form_content .= '<input type="text" id="wpsf_contact_phone" name="wpsf_contact_phone" value="" size="40" /> '."\n";
				}

			$spamfree_contact_form_content .= '</label></p>'."\n";
			$spamfree_contact_form_content .= '<p><label><strong>Subject</strong> *<br />';
    		$spamfree_contact_form_content .= '<input type="text" id="wpsf_contact_subject" name="wpsf_contact_subject" value="" size="40" /> </label></p>'."\n";
			$spamfree_contact_form_content .= '<p><label><strong>Your Message</strong> *<br />'."\n";
			
			$spamfree_contact_form_content .= '<textarea id="wpsf_contact_message" name="wpsf_contact_message" cols="'.$FormMessageWidth.'" rows="'.$FormMessageHeight.'"></textarea> </label></p>'."\n";

			$spamfree_contact_form_content .= '<p><input type="submit" value="Send" /></p>'."\n";
			$spamfree_contact_form_content .= '<script type=\'text/javascript\'>'."\n";
			$spamfree_contact_form_content .= '//<![CDATA['."\n";
			$spamfree_contact_form_content .= 'document.write("<input type=\'hidden\' id=\''.$FormValidationFieldJS.'\' name=\''.$FormValidationFieldJS.'\' value=\''.$FormValidationKeyJS.'\' />");'."\n";
			$spamfree_contact_form_content .= '//]]>'."\n";
			$spamfree_contact_form_content .= '</script>'."\n";

			$spamfree_contact_form_content .= '</form>'."\n";
			$spamfree_contact_form_content .= '</div>'."\n";
			$spamfree_contact_form_content .= '<p>* Required Field</p>'."\n";
			$spamfree_contact_form_content .= '<p>&nbsp;</p>'."\n";
		
			$spamfree_contact_form_content .= '<noscript><p><strong>Currently you have JavaScript disabled. In order to use this contact form, please make sure JavaScript and Cookies are enabled, and reload the page.</strong></p></noscript><p>&nbsp;</p>'."\n";
			
			$content_new = str_replace('<!--spamfree-contact-->', $spamfree_contact_form_content, $content);
			}

		}
	if ( $_GET['form'] == response ) {
		$content_new = str_replace($content, $spamfree_contact_form_content, $content);
		}
	else {
		$content_new = str_replace('<!--spamfree-contact-->', $spamfree_contact_form_content, $content);
		}
	return $content_new;
	}
	
function spamfree_check_comment_type($commentdata) {
	$spamfree_options			= get_option('spamfree_options');
	$BlockAllTrackbacks 		= $spamfree_options['block_all_trackbacks'];
	$BlockAllPingbacks 			= $spamfree_options['block_all_pingbacks'];	
	
	$content_filter_status		= spamfree_content_filter($commentdata);
	
	global $userdata, $user_login, $user_level, $user_ID, $user_email, $user_url, $user_identity;
	get_currentuserinfo();
	
	if ( $user_level < 9 ) {
		if ($content_filter_status) {
			add_filter('pre_comment_approved', 'spamfree_denied_post', 1);
			}	
		else if ( ( $commentdata['comment_type'] != 'trackback' && $commentdata['comment_type'] != 'pingback' ) || ( $BlockAllTrackbacks && $BlockAllPingbacks ) || ( $BlockAllTrackbacks && $commentdata['comment_type'] == 'trackback' ) || ( $BlockAllPingbacks && $commentdata['comment_type'] == 'pingback' ) ) {
			// If Comment is not a trackback or pingback, or 
			// Trackbacks and Pingbacks are blocked, or 
			// Trackbacks are blocked and comment is Trackback, or 
			// Pingbacks are blocked and comment is Pingback
			add_filter('pre_comment_approved', 'spamfree_allowed_post', 1);
			}
		}

	return $commentdata;
	}

function spamfree_allowed_post($approved) {
	// TEST TO PREVENT COMMENT SPAM FROM BOTS :: BEGIN
	//$BlogWPVersion				= bloginfo('version');
	$spamfree_options			= get_option('spamfree_options');
	$CookieValidationName  		= $spamfree_options['cookie_validation_name'];
	$CookieValidationKey 		= $spamfree_options['cookie_validation_key'];
	$FormValidationFieldJS 		= $spamfree_options['form_validation_field_js'];
	$FormValidationKeyJS 		= $spamfree_options['form_validation_key_js'];
	$WPCommentValidationJS 		= $_COOKIE[$CookieValidationName];
	//$WPFormValidationPost 		= $_POST[$FormValidationFieldJS]; //Comments Post Verification
	if( $WPCommentValidationJS == $CookieValidationKey ) { // Comment allowed - Quick-Fix for 2.5
	// if( $WPCommentValidationJS == $CookieValidationKey && $WPFormValidationPost == $FormValidationKeyJS ) { // Comment allowed
		// Clear Key Values and Update
		spamfree_update_keys(1);
		return $approved;
		}
	/*	
	else if( $BlogWPVersion >= '2.5' && $WPCommentValidationJS == $CookieValidationKey ) {
		spamfree_update_keys(1);
		return $approved;
		}
	*/	
	else { // Comment spam killed
	
		// Update Count
		update_option( 'spamfree_count', get_option('spamfree_count') + 1 );
		// Akismet Accuracy Fix :: BEGIN
		// Akismet's counter is currently taking credit for some spams killed by WP-SpamFree - the following ensures accurate reporting.
		// The reason for this fix is that Akismet may have marked the same comment as spam, but WP-SpamFree actually kills it - with or without Akismet.
		$ak_count_pre	= get_option('ak_count_pre');
		$ak_count_post	= get_option('akismet_spam_count');
		if ($ak_count_post > $ak_count_pre) {
			update_option( 'akismet_spam_count', $ak_count_pre );
			}
		// Akismet Accuracy Fix :: END

    	wp_die( __('Sorry, there was an error. Please enable JavaScript and Cookies in your browser and try again.') );
		return false;
		}
	// TEST TO PREVENT COMMENT SPAM FROM BOTS :: END
	}
	
function spamfree_denied_post($approved) {
	// REJECT SPAM :: BEGIN
	
	// Update Count
	update_option( 'spamfree_count', get_option('spamfree_count') + 1 );
	// Akismet Accuracy Fix :: BEGIN
	// Akismet's counter is currently taking credit for some spams killed by WP-SpamFree - the following ensures accurate reporting.
	// The reason for this fix is that Akismet may have marked the same comment as spam, but WP-SpamFree actually kills it - with or without Akismet.
	$ak_count_pre	= get_option('ak_count_pre');
	$ak_count_post	= get_option('akismet_spam_count');
	if ($ak_count_post > $ak_count_pre) {
		update_option( 'akismet_spam_count', $ak_count_pre );
		}
	// Akismet Accuracy Fix :: END

	wp_die( __('Comments have been temporarily disabled to prevent spam. Please try again later.') ); // Stop spammers without revealing why.
	return false;
	// REJECT SPAM :: END
	}

function spamfree_content_filter($commentdata) {
	// Supplementary Defense - Blocking the Obvious to Improve Pingback/Trackback Defense
	// CONTENT FILTERING :: BEGIN
	$CurrentWordPressVersion = '2.5';
	

	// CONTENT FILTERING :: BEGIN
	//$ThisBlogWPVersion					= bloginfo('version');
	$commentdata_comment_author				= $commentdata['comment_author'];
	$commentdata_comment_author_lc			= strtolower($commentdata_comment_author);
	$commentdata_comment_author_email		= $commentdata['comment_author_email'];
	$commentdata_comment_author_email_lc	= strtolower($commentdata_comment_author_email);
	$commentdata_comment_author_url			= $commentdata['comment_author_url'];
	$commentdata_comment_author_url_lc		= strtolower($commentdata_comment_author_url);
	$commentdata_comment_content			= $commentdata['comment_content'];
	$commentdata_comment_content_lc			= strtolower($commentdata_comment_content);
	$commentdata_comment_type				= $commentdata['comment_type'];
	
	// Altered to Accommodate WP 2.5+
	$commentdata_user_agent					= $_SERVER['HTTP_USER_AGENT'];
	$commentdata_user_agent_lc				= strtolower($commentdata_user_agent);
	$commentdata_remote_addr				= $_SERVER['REMOTE_ADDR'];
	$commentdata_remote_addr_lc				= strtolower($commentdata_remote_addr);
	$commentdata_remote_host				= $_SERVER['REMOTE_HOST'];
	$commentdata_remote_host_lc				= strtolower($commentdata_remote_host);
	$commentdata_referrer					= $_SERVER['HTTP_REFERER'];
	$commentdata_referrer_lc				= strtolower($commentdata_referrer);
	$commentdata_blog						= get_option('siteurl');
	$commentdata_blog_lc					= strtolower($commentdata_blog);
	$commentdata_php_self					= $_SERVER['PHP_SELF'];
	$commentdata_php_self_lc				= strtolower($commentdata_php_self);
	
	// Simple Filters
	
	$blacklist_word_combo_total_limit = 10;
	$blacklist_word_combo_total = 0;
	
	// Filter 1: Number of occurrences of 'http://' in comment_content
	$filter_1_count = substr_count($commentdata_comment_content_lc, 'http://');
	$filter_1_limit = 5;
	$filter_1_trackback_limit = 1;
	
	// Medical-Related Filters
	
	/*
	// Filter 2: Number of occurrences of 'viagra' in comment_content
	$filter_2_count = substr_count($commentdata_comment_content_lc, 'viagra');
	$filter_2_limit = 2;
	// Filter 3: Number of occurrences of 'v1agra' in comment_content
	$filter_3_count = substr_count($commentdata_comment_content_lc, 'v1agra');
	$filter_3_limit = 1;
	// Filter 4: Number of occurrences of 'cialis' in comment_content
	$filter_4_count = substr_count($commentdata_comment_content_lc, 'cialis');
	$filter_4_limit = 2;
	// Filter 5: Number of occurrences of 'c1alis' in comment_content
	$filter_5_count = substr_count($commentdata_comment_content_lc, 'c1alis');
	$filter_5_limit = 1;
	// Filter 6: Number of occurrences of 'levitra' in comment_content
	$filter_6_count = substr_count($commentdata_comment_content_lc, 'levitra');
	$filter_6_limit = 2;
	// Filter 7: Number of occurrences of 'lev1tra' in comment_content
	$filter_7_count = substr_count($commentdata_comment_content_lc, 'lev1tra');
	$filter_7_limit = 1;
	// Filter 8: Number of occurrences of 'erectile dysfunction ' in comment_content
	$filter_8_count = substr_count($commentdata_comment_content_lc, 'erectile dysfunction ');
	$filter_8_limit = 2;
	// Filter 9: Number of occurrences of 'erection' in comment_content
	$filter_9_count = substr_count($commentdata_comment_content_lc, 'erection');
	$filter_9_limit = 2;
	// Filter 10: Number of occurrences of 'erectile' in comment_content
	$filter_10_count = substr_count($commentdata_comment_content_lc, 'erectile');
	$filter_10_limit = 2;
	// Filter 11: Number of occurrences of 'xanax' in comment_content
	$filter_11_count = substr_count($commentdata_comment_content_lc, 'xanax');
	$filter_11_limit = 5;
	// Filter 12: Number of occurrences of 'valium' in comment_content
	$filter_12_count = substr_count($commentdata_comment_content_lc, 'valium');
	$filter_12_limit = 5;
	*/
	
	$filter_2_term = 'viagra';
	$filter_2_count = substr_count($commentdata_comment_content_lc, $filter_2_term);
	$filter_2_limit = 2;
	$filter_2_trackback_limit = 1;
	$filter_2_author_count = substr_count($commentdata_comment_author_lc, $filter_2_term);
	$filter_2_author_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_2_count;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_2_author_count;
	// Filter 3: Number of occurrences of 'v1agra' in comment_content
	$filter_3_term = 'v1agra';
	$filter_3_count = substr_count($commentdata_comment_content_lc, $filter_3_term);
	$filter_3_limit = 1;
	$filter_3_trackback_limit = 1;
	$filter_3_author_count = substr_count($commentdata_comment_author_lc, $filter_3_term);
	$filter_3_author_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_3_count;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_3_author_count;
	// Filter 4: Number of occurrences of 'cialis' in comment_content
	$filter_4_term = 'cialis';
	$filter_4_count = substr_count($commentdata_comment_content_lc, $filter_4_term);
	$filter_4_limit = 2;
	$filter_4_trackback_limit = 1;
	$filter_4_author_count = substr_count($commentdata_comment_author_lc, $filter_4_term);
	$filter_4_author_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_4_count;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_4_author_count;
	// Filter 5: Number of occurrences of 'c1alis' in comment_content
	$filter_5_term = 'c1alis';
	$filter_5_count = substr_count($commentdata_comment_content_lc, $filter_5_term);
	$filter_5_limit = 1;
	$filter_5_trackback_limit = 1;
	$filter_5_author_count = substr_count($commentdata_comment_author_lc, $filter_5_term);
	$filter_5_author_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_5_count;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_5_author_count;
	// Filter 6: Number of occurrences of 'levitra' in comment_content
	$filter_6_term = 'levitra';
	$filter_6_count = substr_count($commentdata_comment_content_lc, $filter_6_term);
	$filter_6_limit = 2;
	$filter_6_trackback_limit = 1;
	$filter_6_author_count = substr_count($commentdata_comment_author_lc, $filter_6_term);
	$filter_6_author_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_6_count;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_6_author_count;
	// Filter 7: Number of occurrences of 'lev1tra' in comment_content
	$filter_7_term = 'lev1tra';
	$filter_7_count = substr_count($commentdata_comment_content_lc, $filter_7_term);
	$filter_7_limit = 1;
	$filter_7_trackback_limit = 1;
	$filter_7_author_count = substr_count($commentdata_comment_author_lc, $filter_7_term);
	$filter_7_author_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_7_count;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_7_author_count;
	// Filter 8: Number of occurrences of 'erectile dysfunction' in comment_content
	$filter_8_term = 'erectile dysfunction';
	$filter_8_count = substr_count($commentdata_comment_content_lc, $filter_8_term);
	$filter_8_limit = 2;
	$filter_8_trackback_limit = 1;
	$filter_8_author_count = substr_count($commentdata_comment_author_lc, $filter_8_term);
	$filter_8_author_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_8_count;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_8_author_count;
	// Filter 9: Number of occurrences of 'erection' in comment_content
	$filter_9_term = 'erection';
	$filter_9_count = substr_count($commentdata_comment_content_lc, $filter_9_term);
	$filter_9_limit = 2;
	$filter_9_trackback_limit = 1;
	$filter_9_author_count = substr_count($commentdata_comment_author_lc, $filter_9_term);
	$filter_9_author_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_9_count;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_9_author_count;
	// Filter 10: Number of occurrences of 'erectile' in comment_content
	$filter_10_term = 'erectile';
	$filter_10_count = substr_count($commentdata_comment_content_lc, $filter_10_term);
	$filter_10_limit = 2;
	$filter_10_trackback_limit = 1;
	$filter_10_author_count = substr_count($commentdata_comment_author_lc, $filter_10_term);
	$filter_10_author_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_10_count;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_10_author_count;
	// Filter 11: Number of occurrences of 'xanax' in comment_content
	$filter_11_term = 'xanax';
	$filter_11_count = substr_count($commentdata_comment_content_lc, $filter_11_term);
	$filter_11_limit = 3;
	$filter_11_trackback_limit = 2;
	$filter_11_author_count = substr_count($commentdata_comment_author_lc, $filter_11_term);
	$filter_11_author_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_11_count;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_11_author_count;
	// Filter 12: Number of occurrences of 'zithromax' in comment_content
	$filter_12_term = 'zithromax';
	$filter_12_count = substr_count($commentdata_comment_content_lc, $filter_12_term);
	$filter_12_limit = 3;
	$filter_12_trackback_limit = 2;
	$filter_12_author_count = substr_count($commentdata_comment_author_lc, $filter_12_term);
	$filter_12_author_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_12_count;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_12_author_count;
	// Filter 13: Number of occurrences of 'phentermine' in comment_content
	$filter_13_term = 'phentermine';
	$filter_13_count = substr_count($commentdata_comment_content_lc, $filter_13_term);
	$filter_13_limit = 3;
	$filter_13_trackback_limit = 2;
	$filter_13_author_count = substr_count($commentdata_comment_author_lc, $filter_13_term);
	$filter_13_author_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_13_count;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_13_author_count;
	// Filter 14: Number of occurrences of ' soma ' in comment_content
	$filter_14_term = ' soma ';
	$filter_14_count = substr_count($commentdata_comment_content_lc, $filter_14_term);
	$filter_14_limit = 3;
	$filter_14_trackback_limit = 2;
	$filter_14_author_count = substr_count($commentdata_comment_author_lc, $filter_14_term);
	$filter_14_author_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_14_count;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_14_author_count;
	// Filter 15: Number of occurrences of ' soma.' in comment_content
	$filter_15_term = ' soma.';
	$filter_15_count = substr_count($commentdata_comment_content_lc, $filter_15_term);
	$filter_15_limit = 3;
	$filter_15_trackback_limit = 2;
	$filter_15_author_count = substr_count($commentdata_comment_author_lc, $filter_15_term);
	$filter_15_author_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_15_count;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_15_author_count;
	// Filter 16: Number of occurrences of 'prescription' in comment_content
	$filter_16_term = 'prescription';
	$filter_16_count = substr_count($commentdata_comment_content_lc, $filter_16_term);
	$filter_16_limit = 3;
	$filter_16_trackback_limit = 2;
	$filter_16_author_count = substr_count($commentdata_comment_author_lc, $filter_16_term);
	$filter_16_author_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_16_count;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_16_author_count;
	// Filter 17: Number of occurrences of 'tramadol' in comment_content
	$filter_17_term = 'tramadol';
	$filter_17_count = substr_count($commentdata_comment_content_lc, $filter_17_term);
	$filter_17_limit = 3;
	$filter_17_trackback_limit = 2;
	$filter_17_author_count = substr_count($commentdata_comment_author_lc, $filter_17_term);
	$filter_17_author_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_17_count;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_17_author_count;
	// Filter 18: Number of occurrences of 'penis enlargement' in comment_content
	$filter_18_term = 'penis enlargement';
	$filter_18_count = substr_count($commentdata_comment_content_lc, $filter_18_term);
	$filter_18_limit = 2;
	$filter_18_trackback_limit = 1;
	$filter_18_author_count = substr_count($commentdata_comment_author_lc, $filter_18_term);
	$filter_18_author_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_18_count;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_18_author_count;
	// Filter 19: Number of occurrences of 'buy pills' in comment_content
	$filter_19_term = 'buy pills';
	$filter_19_count = substr_count($commentdata_comment_content_lc, $filter_19_term);
	$filter_19_limit = 3;
	$filter_19_trackback_limit = 2;
	$filter_19_author_count = substr_count($commentdata_comment_author_lc, $filter_19_term);
	$filter_19_author_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_19_count;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_19_author_count;
	// Filter 20: Number of occurrences of 'diet pill' in comment_content
	$filter_20_term = 'diet pill';
	$filter_20_count = substr_count($commentdata_comment_content_lc, $filter_20_term);
	$filter_20_limit = 3;
	$filter_20_trackback_limit = 2;
	$filter_20_author_count = substr_count($commentdata_comment_author_lc, $filter_20_term);
	$filter_20_author_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_20_count;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_20_author_count;
	// Filter 21: Number of occurrences of 'weight loss pill' in comment_content
	$filter_21_term = 'weight loss pill';
	$filter_21_count = substr_count($commentdata_comment_content_lc, $filter_21_term);
	$filter_21_limit = 3;
	$filter_21_trackback_limit = 2;
	$filter_21_author_count = substr_count($commentdata_comment_author_lc, $filter_21_term);
	$filter_21_author_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_21_count;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_21_author_count;
	// Filter 22: Number of occurrences of 'pill' in comment_content
	$filter_22_term = 'pill';
	$filter_22_count = substr_count($commentdata_comment_content_lc, $filter_22_term);
	$filter_22_limit = 10;
	$filter_22_trackback_limit = 2;
	$filter_22_author_count = substr_count($commentdata_comment_author_lc, $filter_22_term);
	$filter_22_author_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_22_count;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_22_author_count;
	// Filter 23: Number of occurrences of ' pill,' in comment_content
	$filter_23_term = ' pill,';
	$filter_23_count = substr_count($commentdata_comment_content_lc, $filter_23_term);
	$filter_23_limit = 5;
	$filter_23_trackback_limit = 2;
	$filter_23_author_count = substr_count($commentdata_comment_author_lc, $filter_23_term);
	$filter_23_author_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_23_count;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_23_author_count;
	// Filter 24: Number of occurrences of ' pills,' in comment_content
	$filter_24_term = ' pills,';
	$filter_24_count = substr_count($commentdata_comment_content_lc, $filter_24_term);
	$filter_24_limit = 5;
	$filter_24_trackback_limit = 2;
	$filter_24_author_count = substr_count($commentdata_comment_author_lc, $filter_24_term);
	$filter_24_author_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_24_count;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_24_author_count;

	// Sex-Related Filter
	// Filter 104: Number of occurrences of 'porn' in comment_content
	$filter_104_count = substr_count($commentdata_comment_content_lc, 'porn');
	$filter_104_limit = 5;
	$filter_104_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_104_count;
	// Filter 105: Number of occurrences of 'teen porn' in comment_content
	$filter_105_count = substr_count($commentdata_comment_content_lc, 'teen porn');
	$filter_105_limit = 1;
	$filter_105_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_105_count;
	// Filter 106: Number of occurrences of 'rape porn' in comment_content
	$filter_106_count = substr_count($commentdata_comment_content_lc, 'rape porn');
	$filter_106_limit = 1;
	$filter_106_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_106_count;
	// Filter 107: Number of occurrences of 'incest porn' in comment_content
	$filter_107_count = substr_count($commentdata_comment_content_lc, 'incest porn');
	$filter_107_limit = 1;
	$filter_107_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_107_count;
	// Filter 108: Number of occurrences of 'hentai' in comment_content
	$filter_108_count = substr_count($commentdata_comment_content_lc, 'hentai');
	$filter_108_limit = 2;
	$filter_108_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_108_count;
	// Filter 109: Number of occurrences of 'sex movie' in comment_content
	$filter_109_count = substr_count($commentdata_comment_content_lc, 'sex movie');
	$filter_109_limit = 2;
	$filter_109_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_109_count;
	// Filter 110: Number of occurrences of 'sex tape' in comment_content
	$filter_110_count = substr_count($commentdata_comment_content_lc, 'sex tape');
	$filter_110_limit = 2;
	$filter_110_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_110_count;
	// Filter 111: Number of occurrences of 'sex' in comment_content
	$filter_111_count = substr_count($commentdata_comment_content_lc, 'sex');
	$filter_111_limit = 5;
	$filter_111_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_111_count;
	// Filter 112: Number of occurrences of 'sex' in comment_content
	$filter_112_count = substr_count($commentdata_comment_content_lc, 'pussy');
	$filter_112_limit = 3;
	$filter_112_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_112_count;
	// Filter 113: Number of occurrences of 'penis' in comment_content
	$filter_113_count = substr_count($commentdata_comment_content_lc, 'penis');
	$filter_113_limit = 3;
	$filter_113_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_113_count;
	// Filter 114: Number of occurrences of 'vagina' in comment_content
	$filter_114_count = substr_count($commentdata_comment_content_lc, 'vagina');
	$filter_114_limit = 3;
	$filter_114_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_114_count;
	// Filter 115: Number of occurrences of 'gay porn' in comment_content
	$filter_115_count = substr_count($commentdata_comment_content_lc, 'gay porn');
	$filter_115_limit = 2;
	$filter_115_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_115_count;
	// Filter 116: Number of occurrences of 'torture porn' in comment_content
	$filter_116_count = substr_count($commentdata_comment_content_lc, 'torture porn');
	$filter_116_limit = 1;
	$filter_116_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_116_count;
	// Filter 117: Number of occurrences of 'masturbation' in comment_content
	$filter_117_count = substr_count($commentdata_comment_content_lc, 'masturbation');
	$filter_117_limit = 3;
	$filter_117_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_117_count;
	// Filter 118: Number of occurrences of 'masterbation' in comment_content
	$filter_118_count = substr_count($commentdata_comment_content_lc, 'masterbation');
	$filter_118_limit = 2;
	$filter_118_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_118_count;
	// Filter 119: Number of occurrences of 'masturbate' in comment_content
	$filter_119_count = substr_count($commentdata_comment_content_lc, 'masturbate');
	$filter_119_limit = 3;
	$filter_119_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_119_count;
	// Filter 120: Number of occurrences of 'masterbate' in comment_content
	$filter_120_count = substr_count($commentdata_comment_content_lc, 'masterbate');
	$filter_120_limit = 2;
	$filter_120_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_120_count;
	// Filter 121: Number of occurrences of 'masturbating' in comment_content
	$filter_121_count = substr_count($commentdata_comment_content_lc, 'masturbating');
	$filter_121_limit = 3;
	$filter_121_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_121_count;
	// Filter 122: Number of occurrences of 'masterbating' in comment_content
	$filter_122_count = substr_count($commentdata_comment_content_lc, 'masterbating');
	$filter_122_limit = 2;
	$filter_122_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_122_count;
	// Filter 123: Number of occurrences of 'anal sex' in comment_content
	$filter_123_count = substr_count($commentdata_comment_content_lc, 'anal sex');
	$filter_123_limit = 3;
	$filter_123_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_123_count;
	// Filter 124: Number of occurrences of 'xxx' in comment_content
	$filter_124_count = substr_count($commentdata_comment_content_lc, 'xxx');
	$filter_124_limit = 5;
	$filter_124_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_124_count;
	// Filter 125: Number of occurrences of 'naked' in comment_content
	$filter_125_count = substr_count($commentdata_comment_content_lc, 'naked');
	$filter_125_limit = 5;
	$filter_125_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_125_count;
	// Filter 126: Number of occurrences of 'nude' in comment_content
	$filter_126_count = substr_count($commentdata_comment_content_lc, 'nude');
	$filter_126_limit = 5;
	$filter_126_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_126_count;
	// Filter 127: Number of occurrences of 'fucking' in comment_content
	$filter_127_count = substr_count($commentdata_comment_content_lc, 'fucking');
	$filter_127_limit = 5;
	$filter_127_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_127_count;
	// Filter 128: Number of occurrences of 'orgasm' in comment_content
	$filter_128_count = substr_count($commentdata_comment_content_lc, 'orgasm');
	$filter_128_limit = 5;
	$filter_128_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_128_count;
	// Filter 129: Number of occurrences of 'pron' in comment_content
	$filter_129_count = substr_count($commentdata_comment_content_lc, 'pron');
	$filter_129_limit = 5;
	$filter_129_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_129_count;
	// Filter 130: Number of occurrences of 'bestiality' in comment_content
	$filter_130_count = substr_count($commentdata_comment_content_lc, 'bestiality');
	$filter_130_limit = 2;
	$filter_130_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_130_count;
	// Filter 131: Number of occurrences of 'animal sex' in comment_content
	$filter_131_count = substr_count($commentdata_comment_content_lc, 'animal sex');
	$filter_131_limit = 2;
	$filter_131_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_131_count;
	// Filter 132: Number of occurrences of 'dildo' in comment_content
	$filter_132_count = substr_count($commentdata_comment_content_lc, 'dildo');
	$filter_132_limit = 4;
	$filter_132_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_132_count;
	// Filter 133: Number of occurrences of 'ejaculate' in comment_content
	$filter_133_count = substr_count($commentdata_comment_content_lc, 'ejaculate');
	$filter_133_limit = 3;
	$filter_133_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_133_count;
	// Filter 134: Number of occurrences of 'ejaculation' in comment_content
	$filter_134_count = substr_count($commentdata_comment_content_lc, 'ejaculation');
	$filter_134_limit = 3;
	$filter_134_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_134_count;
	// Filter 135: Number of occurrences of 'ejaculating' in comment_content
	$filter_135_count = substr_count($commentdata_comment_content_lc, 'ejaculating');
	$filter_135_limit = 3;
	$filter_135_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_135_count;
	// Filter 136: Number of occurrences of 'lesbian' in comment_content
	$filter_136_count = substr_count($commentdata_comment_content_lc, 'lesbian');
	$filter_136_limit = 7;
	$filter_136_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_136_count;
	// Filter 137: Number of occurrences of 'sex video' in comment_content
	$filter_137_count = substr_count($commentdata_comment_content_lc, 'sex video');
	$filter_137_limit = 2;
	$filter_137_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_137_count;
	// Filter 138: Number of occurrences of ' anal ' in comment_content
	$filter_138_count = substr_count($commentdata_comment_content_lc, ' anal ');
	$filter_138_limit = 5;
	$filter_138_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_138_count;
	// Filter 139: Number of occurrences of '>anal ' in comment_content
	$filter_139_count = substr_count($commentdata_comment_content_lc, '>anal ');
	$filter_139_limit = 5;
	$filter_139_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_139_count;
	// Filter 140: Number of occurrences of 'desnuda' in comment_content
	$filter_140_count = substr_count($commentdata_comment_content_lc, 'desnuda');
	$filter_140_limit = 5;
	$filter_140_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_140_count;
	// Filter 141: Number of occurrences of 'cumshots' in comment_content
	$filter_141_count = substr_count($commentdata_comment_content_lc, 'cumshots');
	$filter_141_limit = 2;
	$filter_141_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_141_count;
	// Filter 142: Number of occurrences of 'porntube' in comment_content
	$filter_142_count = substr_count($commentdata_comment_content_lc, 'porntube');
	$filter_142_limit = 2;
	$filter_142_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_142_count;
	// Filter 143: Number of occurrences of 'fuck' in comment_content
	$filter_143_count = substr_count($commentdata_comment_content_lc, 'fuck');
	$filter_143_limit = 6;
	$filter_143_trackback_limit = 2;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_143_count;
	// Filter 144: Number of occurrences of 'celebrity' in comment_content
	$filter_144_count = substr_count($commentdata_comment_content_lc, 'celebrity');
	$filter_144_limit = 6;
	$filter_144_trackback_limit = 6;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_144_count;
	// Filter 145: Number of occurrences of 'celebrities' in comment_content
	$filter_145_count = substr_count($commentdata_comment_content_lc, 'celebrities');
	$filter_145_limit = 6;
	$filter_145_trackback_limit = 6;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_145_count;

	// Pingback/Trackback Filters
	// Filter 200: Pingback: Blank data in comment_content: [...]  [...]
	$filter_200_count = substr_count($commentdata_comment_content_lc, '[...]  [...]');
	$filter_200_limit = 1;
	$filter_200_trackback_limit = 1;
	
	/*
	// Medical-Related Filters
	$filter_set_2 = array(
						'viagra[::wpsf::]2[::wpsf::]2',
						'v1agra[::wpsf::]1[::wpsf::]1',
						'cialis[::wpsf::]2[::wpsf::]2',
						'c1alis[::wpsf::]1[::wpsf::]1',
						'levitra[::wpsf::]2[::wpsf::]2',
						'lev1tra[::wpsf::]1[::wpsf::]1',
						'erectile[::wpsf::]3[::wpsf::]3',
						'erectile dysfuntion[::wpsf::]2[::wpsf::]2',
						'erection[::wpsf::]2[::wpsf::]2',
						'valium[::wpsf::]5[::wpsf::]5',
						'xanax[::wpsf::]5[::wpsf::]5'
						);
	
	// Sex-Related Filters - Common Words occuring in Sex/Porn Spam
	$filter_set_3 = array(
						'porn[::wpsf::]5[::wpsf::]5',
						'teen porn[::wpsf::]1[::wpsf::]1',
						'rape porn[::wpsf::]1[::wpsf::]1',
						'incest porn[::wpsf::]1[::wpsf::]1',
						'torture porn[::wpsf::]1[::wpsf::]1',
						'hentai[::wpsf::]2[::wpsf::]2',
						'sex movie[::wpsf::]3[::wpsf::]3',
						'sex tape[::wpsf::]3[::wpsf::]3',
						'sex[::wpsf::]5[::wpsf::]5',
						'xxx[::wpsf::]5[::wpsf::]5',
						'nude[::wpsf::]5[::wpsf::]5',
						'naked[::wpsf::]5[::wpsf::]5',
						'fucking[::wpsf::]6[::wpsf::]6',
						'pussy[::wpsf::]3[::wpsf::]3',
						'penis[::wpsf::]3[::wpsf::]3',
						'vagina[::wpsf::]3[::wpsf::]3',
						'gay porn[::wpsf::]3[::wpsf::]3',
						'anal sex[::wpsf::]3[::wpsf::]3',
						'masturbation[::wpsf::]3[::wpsf::]3',
						'masterbation[::wpsf::]2[::wpsf::]2',
						'masturbating[::wpsf::]3[::wpsf::]3',
						'masterbating[::wpsf::]2[::wpsf::]2',
						'masturbate[::wpsf::]3[::wpsf::]3',
						'masterbate[::wpsf::]2[::wpsf::]2',
						'bestiality[::wpsf::]2[::wpsf::]2',
						'animal sex[::wpsf::]3[::wpsf::]3',
						'orgasm[::wpsf::]5[::wpsf::]5',
						'ejaculating[::wpsf::]3[::wpsf::]3',
						'ejaculation[::wpsf::]3[::wpsf::]3',
						'ejaculate[::wpsf::]3[::wpsf::]3',
						'dildo[::wpsf::]4[::wpsf::]4'
						);

	// Pingback/Trackback Filters
	$filter_set_4 = array( 
						'[...]  [...][::wpsf::]0[::wpsf::]1'
						);
		
	// Test Filters
	$filter_set_5 = array( 
						'wpsfteststring-3n44j57kkdsmks39248sje83njd839[::wpsf::]1[::wpsf::]1'
						);
	
	$filter_set_master = array_merge( $filter_set_1, $filter_set_2, $filter_set_3, $filter_set_4, $filter_set_5 );
	$filter_set_master_count = count($filter_set_master);
	*/
	
	// Complex Filters
	// Check for Optimized URL's and Keyword Phrases Ocurring in Author Name and Content
	
	// Filter 10001: Number of occurrences of 'this is something special' in comment_content
	$filter_10001_count = substr_count($commentdata_comment_content_lc, 'this is something special');
	$filter_10001_limit = 1;
	$filter_10001_trackback_limit = 1;
	// Filter 10002: Number of occurrences of 'http://groups.google.com/group/' in comment_content
	$filter_10002_count = substr_count($commentdata_comment_content_lc, 'http://groups.google.com/group/');
	$filter_10002_limit = 1;
	$filter_10002_trackback_limit = 1;
	// Filter 10003: Number of occurrences of 'youporn' in comment_content
	$filter_10003_count = substr_count($commentdata_comment_content_lc, 'youporn');
	$filter_10003_limit = 1;
	$filter_10003_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_10003_count;
	// Filter 10004: Number of occurrences of 'pornotube' in comment_content
	$filter_10004_count = substr_count($commentdata_comment_content_lc, 'pornotube');
	$filter_10004_limit = 1;
	$filter_10004_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_10004_count;
	// Filter 10005: Number of occurrences of 'porntube' in comment_content
	$filter_10005_count = substr_count($commentdata_comment_content_lc, 'porntube');
	$filter_10005_limit = 1;
	$filter_10005_trackback_limit = 1;
	$blacklist_word_combo_total = $blacklist_word_combo_total + $filter_10005_count;
	
	// Filter 20001: Number of occurrences of 'groups.google.com' in comment_author_url
	$filter_20001_count = substr_count($commentdata_comment_author_url_lc, 'groups.google.com');
	$filter_20001C_count = substr_count($commentdata_comment_content_lc, 'groups.google.com');
	$filter_20001_limit = 1;
	$filter_20001_trackback_limit = 1;
	// Filter 20002: Number of occurrences of 'groups.yahoo.com' in comment_author_url
	$filter_20002_count = substr_count($commentdata_comment_author_url_lc, 'groups.yahoo.com');
	$filter_20002C_count = substr_count($commentdata_comment_content_lc, 'groups.yahoo.com');
	$filter_20002_limit = 1;
	$filter_20002_trackback_limit = 1;
	// Filter 20003: Number of occurrences of '.phpbbserver.com' in comment_author_url
	$filter_20003_count = substr_count($commentdata_comment_author_url_lc, '.phpbbserver.com');
	$filter_20003C_count = substr_count($commentdata_comment_content_lc, '.phpbbserver.com');
	$filter_20003_limit = 1;
	$filter_20003_trackback_limit = 1;
	// Filter 20004: Number of occurrences of '.freehostia.com' in comment_author_url
	$filter_20004_count = substr_count($commentdata_comment_author_url_lc, '.freehostia.com');
	$filter_20004C_count = substr_count($commentdata_comment_content_lc, '.freehostia.com');
	$filter_20004_limit = 1;
	$filter_20004_trackback_limit = 1;
	
	$commentdata_comment_author_lc_spam_strong = '<strong>'.$commentdata_comment_author_lc.'</strong>'; // Trackbacks
	$commentdata_comment_author_lc_spam_strong_dot1 = '...</strong>'; // Trackbacks
	$commentdata_comment_author_lc_spam_strong_dot2 = '...</b>'; // Trackbacks
	$commentdata_comment_author_lc_spam_a1 = $commentdata_comment_author_lc.'</a>'; // Trackbacks/Pingbacks
	$commentdata_comment_author_lc_spam_a2 = $commentdata_comment_author_lc.' </a>'; // Trackbacks/Pingbacks
	
	$WPCommentsPostURL = $commentdata_blog_lc.'/wp-comments-post.php';

	$Domains = array('.aero','.arpa','.asia','.biz','.cat','.com','.coop','.edu','.gov','.info','.int','.jobs','.mil','.mobi','.museum','.name','.net','.org','.pro','.tel','.travel','.ac','.ad','.ae','.af','.ai','.al','.am','.an','.ao','.aq','.ar','.as','.at','.au','.aw','.ax','.az','.ba','.bb','.bd','.be','.bf','.bg','.bh','.bi','.bj','.bl','.bm','.bn','.bo','.br','.bs','.bt','.bv','.bw','.by','.bz','.ca','.cc','.cf','.cg','.ch','.ci','.ck','.cl','.cm','.cn','.co','.cr','.cu','.cv','.cx','.cy','.cz','.de','.dj','.dk','.dm','.do','.dz','.ec','.ee','.eg','.eh','.er','.es','.et','.eu','.fi','.fj','.fk','.fm','.fo','.fr','.ga','.gb','.gd','.ge','.gf','.gg','.gh','.gi','.gl','.gm','.gn','.gp','.gq','.gr','.gs','.gt','.gu','.gw','.gy','.hk','.hm','.hn','.hr','.ht','.hu','.id','.ie','.il','.im','.in','.io','.iq','.ir','.is','.it','.je','.jm','.jo','.jp','.ke','.kg','.kh','.ki','.km','.km','.kp','.kr','.kw','.ky','.kz','.la','.lb','.lc','.li','.lk','.lr','.ls','.lt','.lu','.lv','.ly','.ma','.mc','.mc','.md','.me','.mf','.mg','.mh','.mk','.ml','.mm','.mn','.mo','.mq','.mr','.ms','.mt','.mu','.mv','.mw','.mx','.my','.mz','.na','.nc','.ne','.nf','.ng','.ni','.nl','.no','.np','.nr','.nu','.nz','.om','.pa','.pe','.pf','.pg','.ph','.pk','.pl','.pm','.pn','.pr','.ps','.pt','.pw','.py','.qa','.re','.ro','.rs','.ru','.rw','.sa','.sb','.sc','.sd','.se','.sg','.sh','.si','.sj','.sk','.sl','.sm','.sn','.so','.sr','.st','.su','.sv','.sy','.sz','.tc','.td','.tf','.tg','.th','.tj','.tk','.tl','.tm','.tn','.to','.tp','.tr','.tt','.tv','.tw','.tz','.ua','.ug','.uk','.um','.us','.uy','.uz','.va','.vc','.ve','.vg','.vi','.vn','.vu','.wf','.ws','.ye','.yt','.yu','.za','.zm','.zw');
	// from http://www.iana.org/domains/root/db/
	$ConversionSeparator = '-';
	$ConversionSeparators = array('-','_');
	$FilterElementsPrefix = array('http://www.','http://');
	$FilterElementsPage = array('.php','.asp','.cfm','.jsp','.html','.htm','.shtml');
	$FilterElementsNum = array('1','2','3','4','5','6','7','8','9','0');
	$FilterElementsSlash = array('////','///','//');
	$TempPhrase1 = str_replace($FilterElementsPrefix,'',$commentdata_comment_author_url_lc);
	$TempPhrase2 = str_replace($FilterElementsPage,'',$TempPhrase1);
	$TempPhrase3 = str_replace($Domains,'',$TempPhrase2);
	$TempPhrase4 = str_replace($FilterElementsNum,'',$TempPhrase3);
	$TempPhrase5 = str_replace($FilterElementsSlash,'/',$TempPhrase4);
	$TempPhrase6 = strtolower(str_replace($ConversionSeparators,' ',$TempPhrase5));
	$KeywordURLPhrases = explode('/',$TempPhrase6);
	$KeywordURLPhrasesCount = count($KeywordURLPhrases);
	$KeywordCommentAuthorPhrasePunct = array('\:','\;','\+','\-','\!','\.','\,','\[','\]','\@','\#','\$','\%','\^','\&','\*','\(','\)','\/','\\','\|','\=','\_');
	$KeywordCommentAuthorTempPhrase = str_replace($KeywordCommentAuthorPhrasePunct,'',$commentdata_comment_author_lc);
	$KeywordCommentAuthorPhrase1 = str_replace(' ','',$KeywordCommentAuthorTempPhrase);
	$KeywordCommentAuthorPhrase2 = str_replace(' ','-',$KeywordCommentAuthorTempPhrase);
	$KeywordCommentAuthorPhrase3 = str_replace(' ','_',$KeywordCommentAuthorTempPhrase);
	$KeywordCommentAuthorPhraseURLVariation = $FilterElementsPage;
	$KeywordCommentAuthorPhraseURLVariation[] = '/';
	$KeywordCommentAuthorPhraseURLVariationCount = count($KeywordCommentAuthorPhraseURLVariation);
	$SplogTrackbackPhrase1 = 'an interesting post today.Here’s a quick excerpt';
	$SplogTrackbackPhrase2 = 'an interesting post today. Here’s a quick excerpt';
	$SplogTrackbackPhrase3 = 'an interesting post today.Here\'s a quick excerpt';
	$SplogTrackbackPhrase4 = 'an interesting post today. Here\'s a quick excerpt';
	$SplogTrackbackPhrase5 = 'an interesting post today onHere’s a quick excerpt';
	$SplogTrackbackPhrase6 = 'an interesting post today onHere\'s a quick excerpt';
	$SplogTrackbackPhrase7 = 'Read the rest of this great post here';
	$SplogTrackbackPhrase8 = 'here to see the original: ';
	$SplogTrackbackPhrase9a = 'an interesting post today on';
	$SplogTrackbackPhrase9b = 'Here\'s a quick excerpt';
	$SplogTrackbackPhrase9c = 'Here’s a quick excerpt';
	
	$blacklist_word_combo_limit = 7;
	$blacklist_word_combo = 0;

	$i = 0;
	
	// Execute Simple Filter Test(s)
	if ( $filter_1_count >= $filter_1_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 1';
		}
	if ( $filter_2_count >= $filter_2_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 2';
		}
	if ( $filter_2_count ) { $blacklist_word_combo++; }
	if ( $filter_3_count >= $filter_3_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 3';
		}
	if ( $filter_3_count ) { $blacklist_word_combo++; }
	if ( $filter_4_count >= $filter_4_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 4';
		}
	if ( $filter_4_count ) { $blacklist_word_combo++; }
	if ( $filter_5_count >= $filter_5_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 5';
		}
	if ( $filter_5_count ) { $blacklist_word_combo++; }
	if ( $filter_6_count >= $filter_6_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 6';
		}
	if ( $filter_6_count ) { $blacklist_word_combo++; }
	if ( $filter_7_count >= $filter_7_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 7';
		}
	if ( $filter_7_count ) { $blacklist_word_combo++; }
	if ( $filter_8_count >= $filter_8_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 8';
		}
	if ( $filter_8_count ) { $blacklist_word_combo++; }
	if ( $filter_9_count >= $filter_9_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 9';
		}
	if ( $filter_9_count ) { $blacklist_word_combo++; }
	if ( $filter_10_count >= $filter_10_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 10';
		}
	if ( $filter_10_count ) { $blacklist_word_combo++; }
	if ( $filter_11_count >= $filter_11_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 11';
		}
	if ( $filter_11_count ) { $blacklist_word_combo++; }
	if ( $filter_12_count >= $filter_12_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 12';
		}
	if ( $filter_12_count ) { $blacklist_word_combo++; }
	if ( $filter_13_count >= $filter_13_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 13';
		}
	if ( $filter_13_count ) { $blacklist_word_combo++; }	
	if ( $filter_14_count >= $filter_14_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 14';
		}
	if ( $filter_14_count ) { $blacklist_word_combo++; }	
	if ( $filter_15_count >= $filter_15_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 15';
		}
	if ( $filter_15_count ) { $blacklist_word_combo++; }	
	if ( $filter_16_count >= $filter_16_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 16';
		}
	if ( $filter_16_count ) { $blacklist_word_combo++; }
	if ( $filter_17_count >= $filter_17_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 17';
		}
	if ( $filter_17_count ) { $blacklist_word_combo++; }
	if ( $filter_18_count >= $filter_18_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 18';
		}
	if ( $filter_18_count ) { $blacklist_word_combo++; }
	if ( $filter_19_count >= $filter_19_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 19';
		}
	if ( $filter_19_count ) { $blacklist_word_combo++; }
	if ( $filter_20_count >= $filter_20_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 20';
		}
	if ( $filter_20_count ) { $blacklist_word_combo++; }
	if ( $filter_21_count >= $filter_21_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 21';
		}
	if ( $filter_21_count ) { $blacklist_word_combo++; }
	if ( $filter_22_count >= $filter_22_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 22';
		}
	if ( $filter_22_count ) { $blacklist_word_combo++; }
	if ( $filter_23_count >= $filter_23_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 23';
		}
	if ( $filter_23_count ) { $blacklist_word_combo++; }
	if ( $filter_24_count >= $filter_24_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 24';
		}
	if ( $filter_24_count ) { $blacklist_word_combo++; }
		
	if ( $filter_104_count >= $filter_104_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 104';
		}
	if ( $filter_104_count ) { $blacklist_word_combo++; }
	if ( $filter_105_count >= $filter_105_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 105';
		}
	if ( $filter_105_count ) { $blacklist_word_combo++; }
	if ( $filter_106_count >= $filter_106_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 106';
		}
	if ( $filter_106_count ) { $blacklist_word_combo++; }
	if ( $filter_107_count >= $filter_107_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 107';
		}
	if ( $filter_107_count ) { $blacklist_word_combo++; }
	if ( $filter_108_count >= $filter_108_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 108';
		}
	if ( $filter_108_count ) { $blacklist_word_combo++; }
	if ( $filter_109_count >= $filter_109_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 109';
		}
	if ( $filter_109_count ) { $blacklist_word_combo++; }
	if ( $filter_110_count >= $filter_110_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 110';
		}
	if ( $filter_110_count ) { $blacklist_word_combo++; }
	if ( $filter_111_count >= $filter_111_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 111';
		}
	if ( $filter_111_count ) { $blacklist_word_combo++; }
	if ( $filter_112_count >= $filter_112_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 112';
		}
	if ( $filter_112_count ) { $blacklist_word_combo++; }
	if ( $filter_113_count >= $filter_113_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 113';
		}
	if ( $filter_113_count ) { $blacklist_word_combo++; }
	if ( $filter_114_count >= $filter_114_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 114';
		}
	if ( $filter_114_count ) { $blacklist_word_combo++; }
	if ( $filter_115_count >= $filter_115_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 115';
		}
	if ( $filter_115_count ) { $blacklist_word_combo++; }
	if ( $filter_116_count >= $filter_116_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 116';
		}
	if ( $filter_116_count ) { $blacklist_word_combo++; }
	if ( $filter_117_count >= $filter_117_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 117';
		}
	if ( $filter_117_count ) { $blacklist_word_combo++; }
	if ( $filter_118_count >= $filter_118_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 118';
		}
	if ( $filter_118_count ) { $blacklist_word_combo++; }
	if ( $filter_119_count >= $filter_119_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 119';
		}
	if ( $filter_119_count ) { $blacklist_word_combo++; }
	if ( $filter_120_count >= $filter_120_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 120';
		}
	if ( $filter_120_count ) { $blacklist_word_combo++; }
	if ( $filter_121_count >= $filter_121_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 121';
		}
	if ( $filter_121_count ) { $blacklist_word_combo++; }
	if ( $filter_122_count >= $filter_122_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 122';
		}
	if ( $filter_122_count ) { $blacklist_word_combo++; }
	if ( $filter_123_count >= $filter_123_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 123';
		}
	if ( $filter_123_count ) { $blacklist_word_combo++; }
	if ( $filter_124_count >= $filter_124_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 124';
		}
	if ( $filter_124_count ) { $blacklist_word_combo++; }
	if ( $filter_125_count >= $filter_125_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 125';
		}
	if ( $filter_125_count ) { $blacklist_word_combo++; }
	if ( $filter_126_count >= $filter_126_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 126';
		}
	if ( $filter_126_count ) { $blacklist_word_combo++; }
	if ( $filter_127_count >= $filter_127_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 127';
		}
	if ( $filter_127_count ) { $blacklist_word_combo++; }
	if ( $filter_128_count >= $filter_128_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 128';
		}
	if ( $filter_128_count ) { $blacklist_word_combo++; }
	if ( $filter_129_count >= $filter_129_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 129';
		}
	if ( $filter_129_count ) { $blacklist_word_combo++; }
	if ( $filter_130_count >= $filter_130_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 130';
		}
	if ( $filter_130_count ) { $blacklist_word_combo++; }
	if ( $filter_131_count >= $filter_131_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 131';
		}
	if ( $filter_131_count ) { $blacklist_word_combo++; }
	if ( $filter_132_count >= $filter_132_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 132';
		}
	if ( $filter_132_count ) { $blacklist_word_combo++; }
	if ( $filter_133_count >= $filter_133_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 133';
		}
	if ( $filter_133_count ) { $blacklist_word_combo++; }
	if ( $filter_134_count >= $filter_134_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 134';
		}
	if ( $filter_134_count ) { $blacklist_word_combo++; }
	if ( $filter_135_count >= $filter_135_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 135';
		}
	if ( $filter_135_count ) { $blacklist_word_combo++; }
	if ( $filter_136_count >= $filter_136_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 136';
		}
	if ( $filter_136_count ) { $blacklist_word_combo++; }
	if ( $filter_137_count >= $filter_137_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 137';
		}
	if ( $filter_137_count ) { $blacklist_word_combo++; }
	if ( $filter_138_count >= $filter_138_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 138';
		}
	if ( $filter_138_count ) { $blacklist_word_combo++; }
	if ( $filter_139_count >= $filter_139_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 139';
		}
	if ( $filter_139_count ) { $blacklist_word_combo++; }
	if ( $filter_140_count >= $filter_140_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 140';
		}
	if ( $filter_140_count ) { $blacklist_word_combo++; }
	if ( $filter_141_count >= $filter_141_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 141';
		}
	if ( $filter_141_count ) { $blacklist_word_combo++; }
	if ( $filter_142_count >= $filter_142_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 142';
		}
	if ( $filter_142_count ) { $blacklist_word_combo++; }
	if ( $filter_143_count >= $filter_143_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 143';
		}
	if ( $filter_143_count ) { $blacklist_word_combo++; }
	if ( $filter_144_count >= $filter_144_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 144';
		}
	if ( $filter_144_count ) { $blacklist_word_combo++; }
	if ( $filter_145_count >= $filter_145_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 145';
		}
	if ( $filter_145_count ) { $blacklist_word_combo++; }
	

	/*
	// Execute Filter Test(s)

	$i = 0;
	while ( $i <= $filter_set_master_count ) {
		$filter_phrase_parameters = explode( '[::wpsf::]', $filter_set_master[$i] );
		$filter_phrase 					= $filter_phrase_parameters[0];
		$filter_phrase_limit 			= $filter_phrase_parameters[1];
		$filter_phrase_trackback_limit 	= $filter_phrase_parameters[2];
		$filter_phrase_count			= substr_count( $commentdata_comment_content_lc, $filter_phrase );
		if ( ( $filter_phrase_limit != 0 && $filter_phrase_count >= $filter_phrase_limit ) || ( $filter_phrase_limit == 1 && eregi( $filter_phrase, $commentdata_comment_author_lc ) ) || ( $commentdata_comment_author_lc == $filter_phrase ) ) {
			$content_filter_status = true;
			}
		$i++;
		}
	*/
	// Test Comment Author 
	// Words in Comment Author Repeated in Content - With Keyword Density
	$RepeatedTermsFilters = array('.','-',':');
	$RepeatedTermsTempPhrase = str_replace($RepeatedTermsFilters,'',$commentdata_comment_author_lc);
	$RepeatedTermsTest = explode(' ',$RepeatedTermsTempPhrase);
	$RepeatedTermsTestCount = count($RepeatedTermsTest);
	$CommentContentTotalWords = count( explode( ' ', $commentdata_comment_content_lc ) );
	$i = 0;
	while ( $i <= $RepeatedTermsTestCount ) {
		$RepeatedTermsInContentCount = substr_count( $commentdata_comment_content_lc, $RepeatedTermsTest[$i] );
		$RepeatedTermsInContentStrLength = strlen($RepeatedTermsTest[$i]);
		if ( $RepeatedTermsInContentCount > 1 && $CommentContentTotalWords < $RepeatedTermsInContentCount ) {
			$RepeatedTermsInContentCount = 1;
			}
		$RepeatedTermsInContentDensity = ( $RepeatedTermsInContentCount / $CommentContentTotalWords ) * 100;
		//$spamfree_error_code .= ' 9000-'.$i.' KEYWORD: '.$RepeatedTermsTest[$i].' DENSITY: '.$RepeatedTermsInContentDensity.'% TIMES WORD OCCURS: '.$RepeatedTermsInContentCount.' TOTAL WORDS: '.$CommentContentTotalWords;
		if ( $RepeatedTermsInContentCount >= 5 && $RepeatedTermsInContentStrLength >= 4 && $RepeatedTermsInContentDensity > 40 ) {		
			$content_filter_status = true;
			$spamfree_error_code .= ' 9000-'.$i;
			}
		$i++;
		}
	if ( $commentdata_comment_author_email_lc == 'aaron@yahoo.com' || $commentdata_comment_author_email_lc == 'asdf@yahoo.com' || $commentdata_comment_author_email_lc == 'bill@berlin.com' || $commentdata_comment_author_email_lc == 'dominic@mail.com' || $commentdata_comment_author_email_lc == 'heel@mail.com' || $commentdata_comment_author_email_lc == 'jane@mail.com' || $commentdata_comment_author_email_lc == 'neo@hotmail.com' || $commentdata_comment_author_email_lc == 'nick76@mailbox.com' ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 9200';
		}
	// Test Referrers
	if ( eregi( $commentdata_php_self_lc, $WPCommentsPostURL ) && $commentdata_referrer_lc == $WPCommentsPostURL ) {
		// Often spammers send the referrer as the URL for the wp-comments-post.php page. Nimrods.
		$content_filter_status = true;
		$spamfree_error_code .= ' 1000';
		}
	// Test User-Agents
	if ( !$commentdata_user_agent_lc  ) {
		// There is no reason for a blank UA String, unless it's been altered.
		$content_filter_status = true;
		$spamfree_error_code .= ' 1001';
		}
	// Test IPs
	if ( $commentdata_remote_addr_lc == '64.20.49.178' || $commentdata_remote_addr_lc == '206.123.92.245' || $commentdata_remote_addr_lc == '72.249.100.188' || $commentdata_remote_addr_lc == '61.24.158.174' || $commentdata_remote_addr_lc == '78.129.202.15' || $commentdata_remote_addr_lc == '89.113.78.6' ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 1002';
		}
	// Test Remote Hosts
	if ( eregi( '.svservers.com', $commentdata_remote_host_lc ) ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 1003';
		}
	// Test Pingbacks and Trackbacks
	if ( $commentdata_comment_type == 'pingback' || $commentdata_comment_type == 'trackback' ) {
	
		if ( $filter_1_count >= $filter_1_trackback_limit ) {
			$content_filter_status = true;
			$spamfree_error_code .= ' T1';
			}
		if ( $filter_200_count >= $filter_200_trackback_limit ) {
			$content_filter_status = true;
			$spamfree_error_code .= ' T200';
			}
		if ( $filter_200_count ) { $blacklist_word_combo++; }
		if ( $commentdata_comment_type == 'trackback' && eregi( 'WordPress', $commentdata_user_agent_lc ) ) {
			$content_filter_status = true;
			$spamfree_error_code .= ' T300';
			}
		if ( eregi( 'Incutio XML-RPC -- WordPress/', $commentdata_user_agent_lc ) ) {
			$commentdata_user_agent_lc_explode = explode( '/', $commentdata_user_agent_lc );
			if ( $commentdata_user_agent_lc_explode[1] > $CurrentWordPressVersion ) {
				$content_filter_status = true;
				$spamfree_error_code .= ' T1001';
				}
			}
		if ( $commentdata_comment_author == $commentdata_comment_author_lc ) {
			// Check to see if Comment Author is lowercase. Normal blog pings Authors are properly capitalized. No brainer.
			$content_filter_status = true;
			$spamfree_error_code .= ' T1010';
			}
		if ( $commentdata_comment_content == '[...] read more [...]' ) {
			$content_filter_status = true;
			$spamfree_error_code .= ' T1020';
			}
		if ( eregi( $SplogTrackbackPhrase1, $commentdata_comment_content_lc ) || eregi( $SplogTrackbackPhrase2, $commentdata_comment_content_lc ) || eregi( $SplogTrackbackPhrase3, $commentdata_comment_content_lc ) || eregi( $SplogTrackbackPhrase4, $commentdata_comment_content_lc ) || eregi( $SplogTrackbackPhrase5, $commentdata_comment_content_lc ) || eregi( $SplogTrackbackPhrase6, $commentdata_comment_content_lc ) || eregi( $SplogTrackbackPhrase7, $commentdata_comment_content_lc ) || eregi( $SplogTrackbackPhrase8, $commentdata_comment_content_lc ) || ( eregi( $SplogTrackbackPhrase9a, $commentdata_comment_content_lc ) && ( eregi( $SplogTrackbackPhrase9b, $commentdata_comment_content_lc ) || eregi( $SplogTrackbackPhrase9c, $commentdata_comment_content_lc ) ) ) ) {
			// Check to see if common patterns exist in comment content.
			$content_filter_status = true;
			$spamfree_error_code .= ' T2002';
			}
		if ( eregi( $commentdata_comment_author_lc_spam_strong, $commentdata_comment_content_lc ) ) {
			// Check to see if Comment Author is repeated in content, enclosed in <strong> tags.
			$content_filter_status = true;
			$spamfree_error_code .= ' T2003';
			}
		if ( eregi( $commentdata_comment_author_lc_spam_a1, $commentdata_comment_content_lc ) || eregi( $commentdata_comment_author_lc_spam_a2, $commentdata_comment_content_lc ) ) {
			// Check to see if Comment Author is repeated in content, enclosed in <a> tags.
			$content_filter_status = true;
			$spamfree_error_code .= ' T2004';
			}
		if ( eregi( $commentdata_comment_author_lc_spam_strong_dot1, $commentdata_comment_content_lc ) ) {
			// Check to see if Phrase... in bold is in content
			$content_filter_status = true;
			$spamfree_error_code .= ' T2005';
			}
		if ( eregi( $commentdata_comment_author_lc_spam_strong_dot2, $commentdata_comment_content_lc ) ) {
			// Check to see if Phrase... in bold is in content
			$content_filter_status = true;
			$spamfree_error_code .= ' T2006';
			}
		// Check to see if keyword phrases in url match Comment Author - spammers do this to get links with desired keyword anchor text.
		// Start with url and convert to text phrase for matching against author.
		$i = 0;
		while ( $i <= $KeywordURLPhrasesCount ) {
			if ( $KeywordURLPhrases[$i] == $commentdata_comment_author_lc ) {
				$content_filter_status = true;
				$spamfree_error_code .= ' T3001';
				}
			if ( $KeywordURLPhrases[$i] == $commentdata_comment_content_lc ) {
				$content_filter_status = true;
				$spamfree_error_code .= ' T3002';
				}
			$i++;
			}
		// Reverse check to see if keyword phrases in url match Comment Author. Start with author and convert to url phrases.
		$i = 0;
		while ( $i <= $KeywordCommentAuthorPhraseURLVariationCount ) {
			$KeywordCommentAuthorPhrase1Version = '/'.$KeywordCommentAuthorPhrase1.$KeywordCommentAuthorPhraseURLVariation[$i];
			$KeywordCommentAuthorPhrase2Version = '/'.$KeywordCommentAuthorPhrase2.$KeywordCommentAuthorPhraseURLVariation[$i];
			$KeywordCommentAuthorPhrase3Version = '/'.$KeywordCommentAuthorPhrase3.$KeywordCommentAuthorPhraseURLVariation[$i];
			$KeywordCommentAuthorPhrase1SubStrCount = substr_count($commentdata_comment_author_url_lc, $KeywordCommentAuthorPhrase1Version);
			$KeywordCommentAuthorPhrase2SubStrCount = substr_count($commentdata_comment_author_url_lc, $KeywordCommentAuthorPhrase2Version);
			$KeywordCommentAuthorPhrase3SubStrCount = substr_count($commentdata_comment_author_url_lc, $KeywordCommentAuthorPhrase3Version);
			if ( $KeywordCommentAuthorPhrase1SubStrCount >= 1 ) {
				$content_filter_status = true;
				$spamfree_error_code .= ' T3003-1-'.$KeywordCommentAuthorPhrase1Version;
				}
			else if ( $KeywordCommentAuthorPhrase2SubStrCount >= 1 ) {
				$content_filter_status = true;
				$spamfree_error_code .= ' T3003-2-'.$KeywordCommentAuthorPhrase2Version;
				}
			else if ( $KeywordCommentAuthorPhrase3SubStrCount >= 1 ) {
				$content_filter_status = true;
				$spamfree_error_code .= ' T3003-3-'.$KeywordCommentAuthorPhrase3Version;
				}
			$i++;
			}
		/*
		$i = 0;
		while ( $i <= $filter_set_master_count ) {
			$filter_phrase_parameters = explode( '[::wpsf::]', $filter_set_master[$i] );
			$filter_phrase 					= $filter_phrase_parameters[0];
			$filter_phrase_limit 			= $filter_phrase_parameters[1];
			$filter_phrase_trackback_limit 	= $filter_phrase_parameters[2];
			$filter_phrase_count			= substr_count( $commentdata_comment_content_lc, $filter_phrase );
			if ( $filter_phrase_count >= $filter_phrase_trackback_limit ) {
				$content_filter_status = true;
				}
			$i++;
			}
		*/

		// Test Comment Author 
		// Words in Comment Author Repeated in Content		
		$RepeatedTermsFilters = array('.','-',':');
		$RepeatedTermsTempPhrase = str_replace($RepeatedTermsFilters,'',$commentdata_comment_author_lc);
		$RepeatedTermsTest = explode(' ',$RepeatedTermsTempPhrase);
		$RepeatedTermsTestCount = count($RepeatedTermsTest);
		$i = 0;
		while ( $i <= $RepeatedTermsTestCount ) {
			$RepeatedTermsInContentCount = substr_count( $commentdata_comment_content_lc, $RepeatedTermsTest[$i] );
			$RepeatedTermsInContentStrLength = strlen($RepeatedTermsTest[$i]);
			if ( $RepeatedTermsInContentCount >= 6 && $RepeatedTermsInContentStrLength >= 4 ) {		
				$content_filter_status = true;
				$spamfree_error_code .= ' T9000-'.$i;
				}
			$i++;
			}
		}
	// Miscellaneous
	if ( $commentdata_comment_content == '[...]  [...]' ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 5000';
		}

	// Execute Complex Filter Test(s)
	if ( $filter_10001_count >= $filter_10001_limit && $filter_10002_count >= $filter_10002_limit &&  ( $filter_10003_count >= $filter_10003_limit || $filter_10004_count >= $filter_10004_limit ) ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' CF10000';
		}
	if ( $filter_10003_count ) { $blacklist_word_combo++; }

	// Comment Author URL Tests
	if ( eregi( 'groups.google.com', $commentdata_comment_author_url_lc ) ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 20001';
		}
	if ( $filter_20001_count >= $filter_20001_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 20001A';
		}
	if ( $filter_20001C_count >= $filter_20001_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 20001C';
		}
	if ( eregi( 'groups.yahoo.com', $commentdata_comment_author_url_lc ) ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 20002';
		}
	if ( $filter_20002_count >= $filter_20002_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 20002A';
		}
	if ( $filter_20002C_count >= $filter_20002_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 20002C';
		}
	if ( eregi( ".?phpbbserver\.com", $commentdata_comment_author_url_lc ) ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 20003';
		}
	if ( $filter_20003_count >= $filter_20003_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 20003A';
		}
	if ( $filter_20003C_count >= $filter_20003_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 20003C';
		}
	if ( eregi( '.freehostia.com', $commentdata_comment_author_url_lc ) ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 20004';
		}
	if ( $filter_20004_count >= $filter_20004_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 20004A';
		}
	if ( $filter_20004C_count >= $filter_20004_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 20004C';
		}
	// Comment Author Tests
	if ( $filter_2_author_count >= 1 ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 2AUTH';
		}
	if ( $filter_2_count ) { $blacklist_word_combo++; }
	if ( $filter_3_author_count >= 1 ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 3AUTH';
		}
	if ( $$filter_3_count ) { $blacklist_word_combo++; }
	if ( $filter_4_author_count >= 1 ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 4AUTH';
		}
	if ( $$filter_4_count ) { $blacklist_word_combo++; }
	if ( $filter_5_author_count >= 1 ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 5AUTH';
		}
	if ( $$filter_5_count ) { $blacklist_word_combo++; }
	if ( $filter_6_author_count >= 1 ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 6AUTH';
		}
	if ( $$filter_6_count ) { $blacklist_word_combo++; }
	if ( $filter_7_author_count >= 1 ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 7AUTH';
		}
	if ( $$filter_7_count ) { $blacklist_word_combo++; }
	if ( $filter_8_author_count >= 1 ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 8AUTH';
		}
	if ( $$filter_8_count ) { $blacklist_word_combo++; }
	if ( $filter_9_author_count >= 1 ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 9AUTH';
		}
	if ( $$filter_9_count ) { $blacklist_word_combo++; }
	if ( $filter_10_author_count >= 1 ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 10AUTH';
		}
	if ( $$filter_10_count ) { $blacklist_word_combo++; }
	if ( $filter_11_author_count >= 1 ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 11AUTH';
		}
	if ( $$filter_11_count ) { $blacklist_word_combo++; }
	if ( $filter_12_author_count >= 1 ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 12AUTH';
		}
	if ( $$filter_12_count ) { $blacklist_word_combo++; }
	if ( $filter_13_author_count >= 1 ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 13AUTH';
		}
	if ( $$filter_13_count ) { $blacklist_word_combo++; }	
	if ( $filter_14_author_count >= 1 ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 14AUTH';
		}
	if ( $$filter_14_count ) { $blacklist_word_combo++; }	
	if ( $filter_15_author_count >= 1 ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 15AUTH';
		}
	if ( $$filter_15_count ) { $blacklist_word_combo++; }
	if ( $filter_16_author_count >= 1 ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 16AUTH';
		}
	if ( $$filter_16_count ) { $blacklist_word_combo++; }	
	if ( $filter_17_author_count >= 1 ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 17AUTH';
		}
	if ( $$filter_17_count ) { $blacklist_word_combo++; }
	if ( $filter_18_author_count >= 1 ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 18AUTH';
		}
	if ( $$filter_18_count ) { $blacklist_word_combo++; }
	if ( $filter_19_author_count >= 1 ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 19AUTH';
		}
	if ( $$filter_19_count ) { $blacklist_word_combo++; }
	if ( $filter_20_author_count >= 1 ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 20AUTH';
		}
	if ( $$filter_20_count ) { $blacklist_word_combo++; }
	if ( $filter_21_author_count >= 1 ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 21AUTH';
		}
	if ( $$filter_21_count ) { $blacklist_word_combo++; }
	if ( $filter_22_author_count >= 1 ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 22AUTH';
		}
	if ( $$filter_22_count ) { $blacklist_word_combo++; }
	if ( $filter_23_author_count >= 1 ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 23AUTH';
		}
	if ( $$filter_23_count ) { $blacklist_word_combo++; }
	if ( $filter_24_author_count >= 1 ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 24AUTH';
		}
	if ( $$filter_24_count ) { $blacklist_word_combo++; }	

	if ( eregi( 'buy', $commentdata_comment_author_lc ) && ( eregi( 'online', $commentdata_comment_author_lc ) || eregi( 'pill', $commentdata_comment_author_lc ) ) ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' 200AUTH';
		$blacklist_word_combo++;
		}
	
	// Blacklist Word Combinations
	if ( $blacklist_word_combo >= $blacklist_word_combo_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' BLC1000';
		}
	if ( $blacklist_word_combo_total >= $blacklist_word_combo_total_limit ) {
		$content_filter_status = true;
		$spamfree_error_code .= ' BLC1010';
		}
	
	if ( !$spamfree_error_code ) {
		$spamfree_error_code = 'No Error';
		}
	$spamfree_error_code = ltrim($spamfree_error_code);
	
	$spamfree_error_data = array( $spamfree_error_code, $blacklist_word_combo, $blacklist_word_combo_total );
	
	update_option( 'spamfree_error_data', $spamfree_error_data );
		
	return $content_filter_status;
	// CONTENT FILTERING :: END
	}

function spamfree_stats() {
	global $wp_version;
	$BlogWPVersion = $wp_version;
	if ($BlogWPVersion < '2.5') {
		echo '<h3>WP-SpamFree</h3>';
		}
	$spamfree_count = get_option('spamfree_count');
	if ( !$spamfree_count ) {
		echo '<p>No comment spam attempts have been detected yet.</p>';
		}
	else {
		echo '<p>'.sprintf(__('<a href="%1$s" target="_blank">WP-SpamFree</a> has blocked <strong>%2$s</strong> spam comments.'), 'http://www.hybrid6.com/webgeek/plugins/wp-spamfree/',  number_format($spamfree_count) ).'</p>';
		}
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
			add_filter('the_content', 'spamfree_contact_form', 10);
			//add_action('comment_form', 'spamfree_comment_form');
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
			$installation_plugins_get_test_1	= 'wp-spamfree/wp-spamfree.php';
			$installation_file_test_0 			= ABSPATH . 'wp-content/plugins/wp-spamfree/wp-spamfree.php';
			$installation_file_test_1 			= ABSPATH . 'wp-config.php';
			$installation_file_test_2 			= ABSPATH . 'wp-includes/wp-db.php';
			$installation_file_test_3 			= ABSPATH . 'wp-content/plugins/wp-spamfree/js/wpSpamFreeJS.php';
			clearstatcache();
			if ($installation_plugins_get_test_1==$_GET['page']&&file_exists($installation_file_test_0)&&file_exists($installation_file_test_1)&&file_exists($installation_file_test_2)&&file_exists($installation_file_test_3)) {
				$wp_installation_status = 1;
				$wp_installation_status_color = 'green';
				$wp_installation_status_bg_color = '#CCFFCC';
				$wp_installation_status_msg_main = 'Installed Correctly';
				$wp_installation_status_msg_text = strtolower($wp_installation_status_msg_main);
				}
			else {
				$wp_installation_status = 0;
				$wp_installation_status_color = 'red';
				$wp_installation_status_bg_color = '#FFCCCC';
				$wp_installation_status_msg_main = 'Not Installed Correctly';
				$wp_installation_status_msg_text = strtolower($wp_installation_status_msg_main);
				}
			?>
			
			<div style='width:600px;border-style:solid;border-width:1px;border-color:<?php echo $wp_installation_status_color; ?>;background-color:<?php echo $wp_installation_status_bg_color; ?>;padding:0px 15px 0px 15px;'>
			<p><strong>Installation Status: <?php echo "<span style='color:".$wp_installation_status_color.";'>".$wp_installation_status_msg_main."</span>"; ?></strong></p>
			</div>
			<br />
			
			<?php
			if ($spamCount) {
				echo "
				<div style='width:600px;border-style:solid;border-width:1px;border-color:#000033;background-color:#CCCCFF;padding:0px 15px 0px 15px;'>
				<p>Since we started counting, WP-SpamFree has blocked <strong>".number_format($spamCount)."</strong> spam comments!</p></div>
				";
				}
			$spamfree_options = get_option('spamfree_options');
			if ($_REQUEST['submitted']) {
				$spamfree_options_update = array (
						'cookie_validation_name' 			=> $spamfree_options['cookie_validation_name'],
						'cookie_validation_key' 			=> $spamfree_options['cookie_validation_key'],
						'form_validation_field_js' 			=> $spamfree_options['form_validation_field_js'],
						'form_validation_key_js' 			=> $spamfree_options['form_validation_key_js'],
						'cookie_get_function_name' 			=> $spamfree_options['cookie_get_function_name'],
						'cookie_set_function_name' 			=> $spamfree_options['cookie_set_function_name'],
						'cookie_delete_function_name' 		=> $spamfree_options['cookie_delete_function_name'],
						'comment_validation_function_name' 	=> $spamfree_options['comment_validation_function_name'],
						'wp_cache' 							=> $spamfree_options['wp_cache'],
						'wp_super_cache' 					=> $spamfree_options['wp_super_cache'],
						'use_captcha_backup' 				=> $spamfree_options['use_captcha_backup'],
						'block_all_trackbacks' 				=> $_REQUEST['block_all_trackbacks'],
						'block_all_pingbacks' 				=> $_REQUEST['block_all_pingbacks'],
						'use_trackback_verification' 		=> $spamfree_options['use_trackback_verification'],
						'form_include_website' 				=> $_REQUEST['form_include_website'],
						'form_require_website' 				=> $_REQUEST['form_require_website'],
						'form_include_phone' 				=> $_REQUEST['form_include_phone'],
						'form_require_phone' 				=> $_REQUEST['form_require_phone'],
						'form_message_width' 				=> $_REQUEST['form_message_width'],
						'form_message_height' 				=> $_REQUEST['form_message_height'],
						'form_message_min_length' 			=> $_REQUEST['form_message_min_length'],
						);
				update_option('spamfree_options', $spamfree_options_update);
				}
				$spamfree_options = get_option('spamfree_options');
				$SiteURL = get_option('siteurl');
			?>
			
			<p>&nbsp;</p>
			
			<p><strong>Spam Options</strong></p>

			<form name="wpsf" method="post">
			<input type="hidden" name="submitted" value="1" />

			<fieldset class="options">
				<ul>
					<li>
					<label for="block_all_trackbacks">
						<input type="checkbox" id="block_all_trackbacks" name="block_all_trackbacks" <?php echo ($spamfree_options['block_all_trackbacks']==true?"checked=\"checked\"":"") ?> />
						<strong>Disable trackbacks.</strong><br />(Use if trackback spam is excessive.)<br />&nbsp;
					</label>
					</li>
					<li>
					<label for="block_all_pingbacks">
						<input type="checkbox" id="block_all_pingbacks" name="block_all_pingbacks" <?php echo ($spamfree_options['block_all_pingbacks']==true?"checked=\"checked\"":"") ?> />
						<strong>Disable pingbacks.</strong><br />(Use if pingback spam is excessive. Disadvantage is reduction of communication between blogs.)<br />&nbsp;
					</label>
					</li>
				</ul>
			</fieldset>
			<p class="submit">
			<input type="submit" name="Submit" value="Update Options &raquo;" style="float:left;" />
			</p>
			</form>

			<p>&nbsp;</p>

			<p>&nbsp;</p>

			<p>&nbsp;</p>
			
			<p><strong>Contact Form Options</strong></p>

			<form name="wpsf" method="post">
			<input type="hidden" name="submitted" value="1" />

			<fieldset class="options">
				<ul>
					<li>
					<label for="form_include_website">
						<input type="checkbox" id="form_include_website" name="form_include_website" <?php echo ($spamfree_options['form_include_website']==true?"checked=\"checked\"":"") ?> />
						<strong>Include "Website" Field.</strong><br />&nbsp;
					</label>
					</li>
					<li>
					<label for="form_require_website">
						<input type="checkbox" id="form_require_website" name="form_require_website" <?php echo ($spamfree_options['form_require_website']==true?"checked=\"checked\"":"") ?> />
						<strong>Require "Website" Field.</strong><br />&nbsp;
					</label>
					</li>
					<li>
					<label for="form_include_phone">
						<input type="checkbox" id="form_include_phone" name="form_include_phone" <?php echo ($spamfree_options['form_include_phone']==true?"checked=\"checked\"":"") ?> />
						<strong>Include "Phone" Field.</strong><br />&nbsp;
					</label>
					</li>
					<li>
					<label for="form_require_phone">
						<input type="checkbox" id="form_require_phone" name="form_require_phone" <?php echo ($spamfree_options['form_require_phone']==true?"checked=\"checked\"":"") ?> />
						<strong>Require "Phone" Field.</strong><br />&nbsp;
					</label>
					</li>
					<li>
					<label for="form_message_width">
						<?php $FormMessageWidth = $spamfree_options['form_message_width']; ?>
						<input type="text" size="4" id="form_message_width" name="form_message_width" value="<?php if ( $FormMessageWidth && $FormMessageWidth >= 40 ) { echo $FormMessageWidth; } else { echo '40';} ?>" />
						<strong>"Your Message" Field width. (Minimum 40)</strong><br />&nbsp;
					</label>
					</li>
					<li>
					<label for="form_message_height">
						<?php $FormMessageHeight = $spamfree_options['form_message_height']; ?>
						<input type="text" size="4" id="form_message_height" name="form_message_height" value="<?php if ( $FormMessageHeight && $FormMessageHeight >= 5 ) { echo $FormMessageHeight; } else if ( !$FormMessageHeight ) { echo '10'; } else { echo '5';} ?>" />
						<strong>"Your Message" Field height. (Minimum 5, Default 10)</strong><br />&nbsp;
					</label>
					</li>
					<li>
					<label for="form_message_min_length">
						<?php $FormMessageMinLength = $spamfree_options['form_message_min_length']; ?>
						<input type="text" size="4" id="form_message_min_length" name="form_message_min_length" value="<?php if ( $FormMessageMinLength && $FormMessageMinLength >= 15 ) { echo $FormMessageMinLength; } else if ( !$FormMessageWidth ) { echo '25'; } else { echo '15';} ?>" />
						<strong>Minimum message length (# of characters). (Minimum 15, Default 25)</strong><br />&nbsp;
					</label>
					</li>
				</ul>
			</fieldset>
			<p class="submit">
			<input type="submit" name="Submit" value="Update Options &raquo;" style="float:left;" />
			</p>
			</form>
			
			<p>&nbsp;</p>
			
			<p>&nbsp;</p>
			
			<p>&nbsp;</p>
			
			<p><strong>Installation Instructions</strong></p>

			<ol>
			    <li>After downloading, unzip file and upload the enclosed 'wp-spamfree' directory to your WordPress plugins directory: '/wp-content/plugins/'.<br />&nbsp;</li>
				<li>As always, <strong>activate</strong> the plugin on your WordPress plugins page.<br />&nbsp;</li>
				<li>Check to make sure the plugin is installed properly. 99.9% of all support requests for this plugin originate from improper installation and can be easily prevented. To check proper installation status, go to the WP-SpamFree page in your Admin. It's a submenu link on the Plugins page. Go the the 'Installation Status' area near the top and it will tell you if the plugin is installed correctly. If it tells you that the plugin is not installed correctly, please double-check what directory you have installed WP-SpamFree in, delete any WP-SpamFree files you have uploaded to your server, re-read the Installation Instructions, and start the Installation process over from step 1. If it is installed correctly, then move on to the next step.<br />&nbsp;<br />Currently your plugin is: <?php echo "<span style='color:".$wp_installation_status_color.";'>".$wp_installation_status_msg_main."</span>"; ?><br />&nbsp;</li>
				<li>Select desired configuration options. Due to popular request, I've added the option to block trackbacks and pingbacks if the user feels they are excessive. I'd recommend not doing this, but the choice is yours.<br />&nbsp;</li>
				<li>If you are using front-end anti-spam plugins (CAPTCHA's, challenge questions, etc), be sure they are disabled since there's no longer a need for them, and these could likely conflict. (Back-end anti-spam plugins like Akismet are fine, although unnecessary.)</li>
			</ol>	
			<p>&nbsp;</p>
			<p>You're done! Sit back and see what it feels like to blog without comment spam!</p>
					
			<p>&nbsp;</p>


			<p><strong>Displaying Stats on Your Blog</strong></p>

			Want to show off your spam stats on your blog and tell others about WP-SpamFree? Simply add the following code to your WordPress theme where you'd like the stats displayed: <br />&nbsp;<br /><code>&lt;?php if ( function_exists(spamfree_counter) ) { spamfree_counter(1); } ?&gt;</code><br />&nbsp;<br /> where '1' is the style. Replace the '1' with a number from 1-6 that corresponds to one of the following sample styles you'd like to use.
			
			<ol>
			    <li>&nbsp;<br />&nbsp;
				<img src='<?php echo $SiteURL; ?>/wp-content/plugins/wp-spamfree/counter/spamfree-counter-bg-1-preview.png' style="margin-right: 10px; margin-top: 7px; margin-bottom: 7px;  width: 140px; height: 66px" border="0" width="140" height="66" /></li>
				
			    <li>&nbsp;<br />&nbsp;
				<img src='<?php echo $SiteURL; ?>/wp-content/plugins/wp-spamfree/counter/spamfree-counter-bg-2-preview.png' style="margin-right: 10px; margin-top: 7px; margin-bottom: 7px;  width: 140px; height: 66px" border="0" width="140" height="66" /></li>
				
			    <li>&nbsp;<br />&nbsp;
				<img src='<?php echo $SiteURL; ?>/wp-content/plugins/wp-spamfree/counter/spamfree-counter-bg-3-preview.png' style="margin-right: 10px; margin-top: 7px; margin-bottom: 7px; width: 140px; height: 66px" border="0" width="140" height="66" /></li>
				
			    <li>&nbsp;<br />&nbsp;
				<img src='<?php echo $SiteURL; ?>/wp-content/plugins/wp-spamfree/counter/spamfree-counter-bg-4-preview.png' style="margin-right: 10px; margin-top: 7px; margin-bottom: 7px; width: 140px; height: 106px" border="0" width="140" height="106" /></li>
				
			    <li>&nbsp;<br />&nbsp;
				<img src='<?php echo $SiteURL; ?>/wp-content/plugins/wp-spamfree/counter/spamfree-counter-bg-5-preview.png' style="margin-right: 10px; margin-top: 7px; margin-bottom: 7px; width: 140px; height: 61px" border="0" width="140" height="61" /></li>
				
			    <li>&nbsp;<br />&nbsp;
				<img src='<?php echo $SiteURL; ?>/wp-content/plugins/wp-spamfree/counter/spamfree-counter-bg-6-preview.png' style="margin-right: 10px; margin-top: 7px; margin-bottom: 7px; width: 140px; height: 67px" border="0" width="140" height="67" /></li>
			</ol>
						
			To add stats to individual posts, you'll need to install the <a href="http://wordpress.org/extend/plugins/exec-php/" rel="external" target="_blank" >Exec-PHP</a> plugin.	
			<p>&nbsp;</p>
			
			<p><strong>Adding a Comment Form to Your Blog</strong></p>

			First create a page (not post) where you want to have your comment form. Then, insert the following tag (using the HTML editing tab) and you're done: &lt;!--spamfree-contact--&gt;<br />&nbsp;<br />
			
			There is no need to configure the form, it allows you to simply drop it into the page you want to install it on. However, there are a few basic configuration options. You can choose whether or not to include Phone and Website fields and whether they should be required. You can also set the width and height of the Message box, as well as the minimum message length.<br />&nbsp;<br />

			<strong>What the Contact Form feature IS:</strong> A simple drop-in contact form that won't get spammed.<br />
			<strong>What the Contact Form feature is NOT:</strong> A configurable and full-featured plugin like some other contact form plugins out there.<br />
			<strong>Note:</strong> Please do not request new features for the contact form, as the main focus of the plugin is spam protection. Thank you.<br />
			
			<p>&nbsp;</p>	

			<p><strong>Troubleshooting</strong></p>
			If you're having trouble getting things to work after installing the plugin, here are a few things to check:
			<ol>
				<li>If you haven't yet, please upgrade to the latest version.<br />&nbsp;</li>
				<li>Check to make sure the plugin is installed properly. 99.9% of all support requests for this plugin originate from improper installation and can be easily prevented. To check proper installation status, go to the WP-SpamFree page in your Admin. It's a submenu link on the Plugins page. Go the the 'Installation Status' area near the top and it will tell you if the plugin is installed correctly. If it tells you that the plugin is not installed correctly, please double-check what directory you have installed WP-SpamFree in, delete any WP-SpamFree files you have uploaded to your server, re-read the Installation Instructions, and start the Installation process over from step 1.<br />&nbsp;<br />Currently your plugin is: <?php echo "<span style='color:".$wp_installation_status_color.";'>".$wp_installation_status_msg_main."</span>"; ?><br />&nbsp;</li>
				<li>Clear your browser's cache, clear your cookies, and restart your browser. Then reload the page.<br />&nbsp;</li>
				<li>Make sure <em>JavaScript</em> and <em>cookies</em> are enabled. (JavaScript is different from Java. Java is not required.)<br />&nbsp;</li>
				<li>Check the options you have selected to make sure they are not disabling a feature you want to use.<br />&nbsp;</li>
				<li>Make sure that you are not using other front-end anti-spam plugins (CAPTCHA's, challenge questions, etc) since there's no longer a need for them, and these could likely conflict. (Back-end anti-spam plugins like Akismet are fine, although unnecessary.)<br />&nbsp;</li>
				<li>Visit http://www.yourblog.com/wp-content/plugins/wp-spamfree/js/wpSpamFreeJS.php (where yourblog.com is your blog url) and check two things. First, see if the file comes normally or if it comes up blank or with errors. That would indicate a problem. Submit a support request (see last troubleshooting step) and copy and past any error messages on the page into your message. Second, check for a 403 Forbidden error. That means there is a problem with your file permissions. If the files in the wp-spamfree folder don't have standard permissions (at least 644 or higher) they won't work. This usually only happens by manual modification, but strange things do happen.<br />&nbsp;</li>
				<li>If have checked these, and still can't quite get it working, please either submit a support request at the <a href="http://www.hybrid6.com/webgeek/plugins/wp-spamfree/support" target="_blank" rel="external" >WP-SpamFree Support Page</a>, or <a href="mailto:scott@hybrid6.com?subject=WP-SpamFree Support Request [<?php echo $wpSpamFreeVerAdmin; ?>]">send a support email</a>.</li>
			</ol>
			<p>&nbsp;</p>			

			
			
  			<p>For updates and documentation, visit the homepage of the WP-SpamFree Plugin at: <a href="http://www.hybrid6.com/webgeek/plugins/wp-spamfree" target="_blank">http://www.hybrid6.com/webgeek/plugins/wp-spamfree</a></p>
	
			<p>&nbsp;</p>
	
			<p><strong>How does it feel to blog without being bombarded by automated comment spam?</strong> If you're happy with WP-SpamFree, feel free to <a href="http://www.hybrid6.com/webgeek/2007/11/wp-spamfree-1-wordpress-plugin-released.php#comments" target="_blank" >post a comment letting others know!</a></p>
	
			<p>&nbsp;</p>
			
			<a href="http://www.hybrid6.com/webgeek/plugins/wp-spamfree" target="_blank" rel="external" style="border-style:none;text-decoration:none;" ><img src="http://www.hybrid6.com/webgeek/images/wp-spamfree/end-blog-spam-button-01-black.png" alt="End Blog Spam! WP-SpamFree Comment Spam Protection for WordPress" border="0" style="border-style:none;text-decoration:none;" /></a><br />&nbsp;<br />
			
			<strong>Download Plugin / Documentation</strong><br />
			Latest Version: <a href="http://www.hybrid6.com/webgeek/downloads/wp-spamfree.zip" target="_blank" rel="external" >Download Now</a><br />
			Plugin Homepage / Documentation: <a href="http://www.hybrid6.com/webgeek/plugins/wp-spamfree" target="_blank" rel="external" >WP-SpamFree</a><br />
			Leave Comments: <a href="http://www.hybrid6.com/webgeek/2007/11/wp-spamfree-1-wordpress-plugin-released.php" target="_blank" rel="external" >WP-SpamFree Release Announcement Blog Post</a><br />
			WordPress.org Page: <a href="http://wordpress.org/extend/plugins/wp-spamfree/" target="_blank" rel="external" >WP-SpamFree</a><br />
			Tech Support/Questions: <a href="http://www.hybrid6.com/webgeek/plugins/wp-spamfree/support" target="_blank" rel="external" >WP-SpamFree Support Page</a><br />
			End Blog Spam: <a href="http://www.hybrid6.com/webgeek/plugins/wp-spamfree/end-blog-spam" target="_blank" rel="external" >Let Others Know About WP-SpamFree!</a>
	
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
			echo "\n";
			echo '<!-- WP-SpamFree'.$wpSpamFreeVerJS.' JS Code :: BEGIN -->'."\n";
			echo '<script type="text/javascript" src="'.get_option('siteurl').'/wp-content/plugins/wp-spamfree/js/wpSpamFreeJS.php"></script> '."\n";
			echo '<!-- WP-SpamFree'.$wpSpamFreeVerJS.' JS Code :: END -->'."\n";
			echo "\n";
			}
			
		function install_on_activation() {
			global $wpdb;
			$plugin_db_version = "1.8.2";
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
					'form_include_website' 			=> 1,
					'form_require_website' 			=> 0,
					'form_include_phone' 			=> 1,
					'form_require_phone' 			=> 0,
					'form_message_width' 			=> 40,
					'form_message_height' 			=> 10,
					'form_message_min_length'		=> 25,
					);
				$spamfree_count = get_option('spamfree_count');
				if (!$spamfree_count) {
					update_option("spamfree_count", 0);
					}
				update_option('spamfree_options', $spamfree_options_update);
				update_option( 'ak_count_pre', get_option('akismet_spam_count') );
				// Turn on Comment Moderation
				//update_option('comment_moderation', 1);
				//update_option('moderation_notify', 1);

				}
			}
					
		}
	}

//instantiate the class
if (class_exists('wpSpamFree')) {
	$wpSpamFree = new wpSpamFree();
	}

?>