<?php
/*
Plugin Name: WP-SpamFree
Plugin URI: http://www.hybrid6.com/webgeek/plugins/wp-spamfree
Description: A powerful anti-spam plugin that virtually eliminates automated comment spam from bots. Finally, you can enjoy a spam-free WordPress blog!
Author: Scott Allen, aka WebGeek
Version: 1.6.6
Author URI: http://www.hybrid6.com/webgeek/
*/

/*  Copyright 2007-2008    Scott Allen  (email : scott@hybrid6.com)

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
	session_start();
	$wpSpamFreeVer='1.6.6';
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
		);
	update_option('spamfree_options', $spamfree_options_update);		
	}
	
function spamfree_count() {
	$spamfree_count = get_option('spamfree_count');	
	return $spamfree_count;
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
	
function spamfree_check_comment_type($commentdata) {
	$spamfree_options			= get_option('spamfree_options');
	$BlockAllTrackbacks 		= $spamfree_options['block_all_trackbacks'];
	$BlockAllPingbacks 			= $spamfree_options['block_all_pingbacks'];	
	
	$content_filter_status		= spamfree_content_filter($commentdata);
	
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
	$commentdata_comment_author				= $commentdata['comment_author'];
	$commentdata_comment_author_lc			= strtolower($commentdata_comment_author);
	$commentdata_comment_author_email		= $commentdata['comment_author_email'];
	$commentdata_comment_author_email_lc	= strtolower($commentdata_comment_author_email);
	$commentdata_comment_author_url			= $commentdata['comment_author_url'];
	$commentdata_comment_author_url_lc		= strtolower($commentdata_comment_author_url);
	$commentdata_comment_content			= $commentdata['comment_content'];
	$commentdata_comment_content_lc			= strtolower($commentdata_comment_content);
	$commentdata_comment_type				= $commentdata['comment_type'];
	
	// Simple Filters
	
	// Filter 1: Number of occurrences of 'http://' in comment_content
	$filter_1_count = substr_count($commentdata_comment_content_lc, 'http://');
	$filter_1_limit = 5;
	$filter_1_trackback_limit = 1;
	
	// Viagra-Related Filters
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
	
	// Sex-Related Filter
	// Filter 104: Number of occurrences of 'porn' in comment_content
	$filter_104_count = substr_count($commentdata_comment_content_lc, 'porn');
	$filter_104_limit = 5;
	// Filter 105: Number of occurrences of 'teen porn' in comment_content
	$filter_105_count = substr_count($commentdata_comment_content_lc, 'teen porn');
	$filter_105_limit = 1;
	// Filter 106: Number of occurrences of 'rape porn' in comment_content
	$filter_106_count = substr_count($commentdata_comment_content_lc, 'rape porn');
	$filter_106_limit = 1;
	// Filter 107: Number of occurrences of 'incest porn' in comment_content
	$filter_107_count = substr_count($commentdata_comment_content_lc, 'incest porn');
	$filter_107_limit = 1;
	// Filter 108: Number of occurrences of 'hentai' in comment_content
	$filter_108_count = substr_count($commentdata_comment_content_lc, 'hentai');
	$filter_108_limit = 2;
	// Filter 109: Number of occurrences of 'sex movie' in comment_content
	$filter_109_count = substr_count($commentdata_comment_content_lc, 'sex movie');
	$filter_109_limit = 2;
	// Filter 110: Number of occurrences of 'sex tape' in comment_content
	$filter_110_count = substr_count($commentdata_comment_content_lc, 'sex tape');
	$filter_110_limit = 2;
	// Filter 111: Number of occurrences of 'sex' in comment_content
	$filter_111_count = substr_count($commentdata_comment_content_lc, 'sex');
	$filter_111_limit = 5;
	// Filter 112: Number of occurrences of 'sex' in comment_content
	$filter_112_count = substr_count($commentdata_comment_content_lc, 'pussy');
	$filter_112_limit = 3;
	// Filter 113: Number of occurrences of 'penis' in comment_content
	$filter_113_count = substr_count($commentdata_comment_content_lc, 'penis');
	$filter_113_limit = 3;
	// Filter 114: Number of occurrences of 'vagina' in comment_content
	$filter_114_count = substr_count($commentdata_comment_content_lc, 'vagina');
	$filter_114_limit = 3;
	// Filter 115: Number of occurrences of 'gay porn' in comment_content
	$filter_115_count = substr_count($commentdata_comment_content_lc, 'gay porn');
	$filter_115_limit = 2;
	// Filter 116: Number of occurrences of 'torture porn' in comment_content
	$filter_116_count = substr_count($commentdata_comment_content_lc, 'torture porn');
	$filter_116_limit = 1;
	// Filter 117: Number of occurrences of 'masturbation' in comment_content
	$filter_117_count = substr_count($commentdata_comment_content_lc, 'masturbation');
	$filter_117_limit = 3;
	// Filter 118: Number of occurrences of 'masterbation' in comment_content
	$filter_118_count = substr_count($commentdata_comment_content_lc, 'masterbation');
	$filter_118_limit = 2;
	// Filter 119: Number of occurrences of 'masturbate' in comment_content
	$filter_119_count = substr_count($commentdata_comment_content_lc, 'masturbate');
	$filter_119_limit = 3;
	// Filter 120: Number of occurrences of 'masterbate' in comment_content
	$filter_120_count = substr_count($commentdata_comment_content_lc, 'masterbate');
	$filter_120_limit = 2;
	// Filter 121: Number of occurrences of 'masturbating' in comment_content
	$filter_121_count = substr_count($commentdata_comment_content_lc, 'masturbating');
	$filter_121_limit = 3;
	// Filter 122: Number of occurrences of 'masterbating' in comment_content
	$filter_122_count = substr_count($commentdata_comment_content_lc, 'masterbating');
	$filter_122_limit = 2;
	// Filter 123: Number of occurrences of 'anal sex' in comment_content
	$filter_123_count = substr_count($commentdata_comment_content_lc, 'anal sex');
	$filter_123_limit = 3;

	// Pingback/Trackback Filters
	// Filter 200: Pingback: Blank data in comment_content: [...]  [...]
	$filter_200_count = substr_count($commentdata_comment_content_lc, '[...]  [...]');
	$filter_200_limit = 1;
	$filter_200_trackback_limit = 1;
	
	// Complex Filters
	// Check for Optimized URL's and Keyword Phrases Ocurring in Author Name and Content
	
	$commentdata_comment_author_lc_spam_strong = '<strong>'.$commentdata_comment_author_lc.'</strong>'; // Trackbacks

	$Domains = array('.aero','.arpa','.asia','.biz','.cat','.com','.coop','.edu','.gov','.info','.int','.jobs','.mil','.mobi','.museum','.name','.net','.org','.pro','.tel','.travel','.ac','.ad','.ae','.af','.ai','.al','.am','.an','.ao','.aq','.ar','.as','.at','.au','.aw','.ax','.az','.ba','.bb','.bd','.be','.bf','.bg','.bh','.bi','.bj','.bl','.bm','.bn','.bo','.br','.bs','.bt','.bv','.bw','.by','.bz','.ca','.cc','.cf','.cg','.ch','.ci','.ck','.cl','.cm','.cn','.co','.cr','.cu','.cv','.cx','.cy','.cz','.de','.dj','.dk','.dm','.do','.dz','.ec','.ee','.eg','.eh','.er','.es','.et','.eu','.fi','.fj','.fk','.fm','.fo','.fr','.ga','.gb','.gd','.ge','.gf','.gg','.gh','.gi','.gl','.gm','.gn','.gp','.gq','.gr','.gs','.gt','.gu','.gw','.gy','.hk','.hm','.hn','.hr','.ht','.hu','.id','.ie','.il','.im','.in','.io','.iq','.ir','.is','.it','.je','.jm','.jo','.jp','.ke','.kg','.kh','.ki','.km','.km','.kp','.kr','.kw','.ky','.kz','.la','.lb','.lc','.li','.lk','.lr','.ls','.lt','.lu','.lv','.ly','.ma','.mc','.mc','.md','.me','.mf','.mg','.mh','.mk','.ml','.mm','.mn','.mo','.mq','.mr','.ms','.mt','.mu','.mv','.mw','.mx','.my','.mz','.na','.nc','.ne','.nf','.ng','.ni','.nl','.no','.np','.nr','.nu','.nz','.om','.pa','.pe','.pf','.pg','.ph','.pk','.pl','.pm','.pn','.pr','.ps','.pt','.pw','.py','.qa','.re','.ro','.rs','.ru','.rw','.sa','.sb','.sc','.sd','.se','.sg','.sh','.si','.sj','.sk','.sl','.sm','.sn','.so','.sr','.st','.su','.sv','.sy','.sz','.tc','.td','.tf','.tg','.th','.tj','.tk','.tl','.tm','.tn','.to','.tp','.tr','.tt','.tv','.tw','.tz','.ua','.ug','.uk','.um','.us','.uy','.uz','.va','.vc','.ve','.vg','.vi','.vn','.vu','.wf','.ws','.ye','.yt','.yu','.za','.zm','.zw');
	// from http://www.iana.org/domains/root/db/
	$ConversionSeparator = '-';
	$FilterElementsPrefix = array('http://www.','http://');
	$FilterElementsPage = array('.php','.asp','.cfm','.jsp','.html','.htm');
	$TempPhrase1 = str_replace($FilterElementsPrefix,'',$commentdata_comment_author_url_lc);
	$TempPhrase2 = str_replace($FilterElementsPage,'',$TempPhrase1);
	$TempPhrase3 = str_replace($Domains,'',$TempPhrase2);
	$TempPhrase4 = strtolower(str_replace($ConversionSeparator,' ',$TempPhrase3));
	$KeywordURLPhrases = explode('/',$TempPhrase4);
	$KeywordURLPhrasesCount = count($KeywordURLPhrases);
	$KeywordCommentAuthorPhrase1 = str_replace(' ','',$commentdata_comment_author_lc);
	$KeywordCommentAuthorPhrase2 = str_replace(' ','-',$commentdata_comment_author_lc);
	$SplogTrackbackPhrase1 = 'an interesting post today.Here’s a quick excerpt';
	$SplogTrackbackPhrase2 = 'an interesting post today. Here’s a quick excerpt';
	$SplogTrackbackPhrase3 = 'an interesting post today.Here\'s a quick excerpt';
	$SplogTrackbackPhrase4 = 'an interesting post today. Here\'s a quick excerpt';
	$SplogTrackbackPhrase5 = 'Read the rest of this great post here';
	$SplogTrackbackPhrase6 = 'here to see the original: ';
	
	$i = 0;
	
	// Execute Filter Test(s)
	if ( $filter_1_count >= $filter_1_limit ) {
		$content_filter_status = true;
		}
	else if ( $filter_2_count >= $filter_2_limit ) {
		$content_filter_status = true;
		}
	else if ( $filter_3_count >= $filter_3_limit ) {
		$content_filter_status = true;
		}
	else if ( $filter_4_count >= $filter_4_limit ) {
		$content_filter_status = true;
		}
	else if ( $filter_5_count >= $filter_5_limit ) {
		$content_filter_status = true;
		}
	else if ( $filter_6_count >= $filter_6_limit ) {
		$content_filter_status = true;
		}
	else if ( $filter_7_count >= $filter_7_limit ) {
		$content_filter_status = true;
		}
	else if ( $filter_8_count >= $filter_8_limit ) {
		$content_filter_status = true;
		}
	else if ( $filter_9_count >= $filter_9_limit ) {
		$content_filter_status = true;
		}
	else if ( $filter_10_count >= $filter_10_limit ) {
		$content_filter_status = true;
		}		
	else if ( $filter_104_count >= $filter_104_limit ) {
		$content_filter_status = true;
		}
	else if ( $filter_105_count >= $filter_105_limit ) {
		$content_filter_status = true;
		}
	else if ( $filter_106_count >= $filter_106_limit ) {
		$content_filter_status = true;
		}
	else if ( $filter_107_count >= $filter_107_limit ) {
		$content_filter_status = true;
		}
	else if ( $filter_108_count >= $filter_108_limit ) {
		$content_filter_status = true;
		}
	else if ( $filter_109_count >= $filter_109_limit ) {
		$content_filter_status = true;
		}
	else if ( $filter_110_count >= $filter_110_limit ) {
		$content_filter_status = true;
		}
	else if ( $filter_111_count >= $filter_111_limit ) {
		$content_filter_status = true;
		}
	else if ( $filter_112_count >= $filter_112_limit ) {
		$content_filter_status = true;
		}
	else if ( $filter_113_count >= $filter_113_limit ) {
		$content_filter_status = true;
		}
	else if ( $filter_114_count >= $filter_114_limit ) {
		$content_filter_status = true;
		}
	else if ( $filter_115_count >= $filter_115_limit ) {
		$content_filter_status = true;
		}
	else if ( $filter_116_count >= $filter_116_limit ) {
		$content_filter_status = true;
		}
	else if ( $filter_117_count >= $filter_117_limit ) {
		$content_filter_status = true;
		}
	else if ( $filter_118_count >= $filter_118_limit ) {
		$content_filter_status = true;
		}
	else if ( $filter_119_count >= $filter_119_limit ) {
		$content_filter_status = true;
		}
	else if ( $filter_120_count >= $filter_120_limit ) {
		$content_filter_status = true;
		}
	else if ( $filter_121_count >= $filter_121_limit ) {
		$content_filter_status = true;
		}
	else if ( $filter_122_count >= $filter_122_limit ) {
		$content_filter_status = true;
		}
	else if ( $filter_123_count >= $filter_123_limit ) {
		$content_filter_status = true;
		}
	// Test Pingbacks and Trackbacks
	else if ( $commentdata_comment_type == 'pingback' || $commentdata_comment_type == 'trackback' ) {
		if ( $filter_1_count >= $filter_1_trackback_limit ) {
			$content_filter_status = true;
			}
		else if ( $filter_200_count >= $filter_200_trackback_limit ) {
			$content_filter_status = true;
			}
		else if ( $KeywordCommentAuthorPhrase1 == $commentdata_comment_author_url_lc || $KeywordCommentAuthorPhrase2 == $commentdata_comment_author_url_lc ) {
			// Check to see if Comment Author is equal to keyword phrase in the url - spammers do this to get links with desired keyword anchor text.
			// Normal blogs will have a separator with the blog name at the beginning or end.
			$content_filter_status = true;
			}
		else if ( $commentdata_comment_author_url == $commentdata_comment_author_url_lc ) {
			// Check to see if Comment Author is lowercase. Normal blog pings Authors are properly capitalized. No brainer.
			$content_filter_status = true;
			}
		else if ( eregi( $SplogTrackbackPhrase1, $commentdata_comment_content_lc ) || eregi( $SplogTrackbackPhrase2, $commentdata_comment_content_lc ) || eregi( $SplogTrackbackPhrase3, $commentdata_comment_content_lc ) || eregi( $SplogTrackbackPhrase4, $commentdata_comment_content_lc ) || eregi( $SplogTrackbackPhrase5, $commentdata_comment_content_lc ) || eregi( $SplogTrackbackPhrase6, $commentdata_comment_content_lc ) ) {
			// Check to see if common patterns exist in comment content.
			$content_filter_status = true;
			}
		else if ( eregi( $commentdata_comment_author_lc_spam_strong, $commentdata_comment_content_lc ) ) {
			// Check to see if Comment Author is repeated in content, enclosed in <strong> tags.
			$content_filter_status = true;
			}
		else { 
			// Check to see if keyword phrases in url match Comment Author - spammers do this to get links with desired keyword anchor text.
			$i = 0;
			while ( $i <= $KeywordURLPhrasesCount ) {
				if ( $KeywordURLPhrases[$i] == $commentdata_comment_author_lc || $KeywordURLPhrases[$i] == $commentdata_comment_content_lc ) {
					$content_filter_status = true;
					}
				$i++;
				}
			}
		}
	// Miscellaneous
	else if ( $commentdata_comment_content == '[...]  [...]' ) {
		$content_filter_status = true;
		}
		
	return $content_filter_status;
	// CONTENT FILTERING :: END
	}

function spamfree_stats() {
	echo '<h3>WP-SpamFree</h3>';
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
						);
				update_option('spamfree_options', $spamfree_options_update);
				}
				$spamfree_options = get_option('spamfree_options');
			?>
			
			<p>&nbsp;</p>
			
			<p><strong>Options</strong></p>

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
			
			<p><strong>Installation Instructions</strong></p>

			<ol>
			    <li>After downloading, unzip file and upload the enclosed 'wp-spamfree' directory to your WordPress plugins directory: '/wp-content/plugins/'.<br />&nbsp;</li>
				<li>As always, <strong>activate</strong> the plugin on your WordPress plugins page.<br />&nbsp;</li>
				
				<li>Check to make sure the plugin is installed properly. 99.9% of all support requests for this plugin originate from improper installation and can be easily prevented. To check proper installation status, go to the WP-SpamFree page in your Admin. It's a submenu link on the Plugins page. Go the the 'Installation Status' area near the top and it will tell you if the plugin is installed correctly. If it tells you that the plugin is not installed correctly, please double-check what directory you have installed WP-SpamFree in, delete any WP-SpamFree files you have uploaded to your server, re-read the Installation Instructions, and start the Installation process over from step 1. If it is installed correctly, then move on to the next step.<br />&nbsp;<br />Currently your plugin is: <?php echo "<span style='color:".$wp_installation_status_color.";'>".$wp_installation_status_msg_main."</span>"; ?><br />&nbsp;</li>
				
				<li>Select desired configuration options. Due to popular request, I've added the option to block trackbacks and pingbacks if the user feels they are excessive. I'd recommend not doing this, but the choice is yours.</li>

			</ol>	
			<p>&nbsp;</p>
			<p>You're done! Sit back and see what it feels like to blog without comment spam!</p>
					
			<p>&nbsp;</p>
	
			<p><strong>Troubleshooting</strong></p>
			If you're having trouble getting things to work after installing the plugin, here are a few things to check:
			<ol>
				<li>If you haven't yet, please upgrade to the latest version.<br />&nbsp;</li>
				<li>Check to make sure the plugin is installed properly. 99.9% of all support requests for this plugin originate from improper installation and can be easily prevented. To check proper installation status, go to the WP-SpamFree page in your Admin. It's a submenu link on the Plugins page. Go the the 'Installation Status' area near the top and it will tell you if the plugin is installed correctly. If it tells you that the plugin is not installed correctly, please double-check what directory you have installed WP-SpamFree in, delete any WP-SpamFree files you have uploaded to your server, re-read the Installation Instructions, and start the Installation process over from step 1.<br />&nbsp;<br />Currently your plugin is: <?php echo "<span style='color:".$wp_installation_status_color.";'>".$wp_installation_status_msg_main."</span>"; ?><br />&nbsp;</li>
				<li>Clear your browser's cache, clear your cookies, and restart your browser. Then reload the page.<br />&nbsp;</li>
				<li>Make sure <em>JavaScript</em> and <em>cookies</em> are enabled. (JavaScript is different from Java. Java is not required.)<br />&nbsp;</li>
				<li>Check the options you have selected to make sure they are not disabling a feature you want to use.<br />&nbsp;</li>
				<li>If have checked these, and still can't quite get it working, please either post a support request in the comments section of the <a href="http://www.hybrid6.com/webgeek/2007/11/wp-spamfree-1-wordpress-plugin-released.php" target="_blank">WP-SpamFree release announcement</a> blog post, or <a href="mailto:scott@hybrid6.com?subject=WP-SpamFree Support Request, v<?php echo $wpSpamFreeVerAdmin; ?>">send a support email</a>.</li>
			</ol>
			<p>&nbsp;</p>			

			
			
  			<p>For updates and documentation, visit the homepage of the WP-SpamFree Plugin at: <a href="http://www.hybrid6.com/webgeek/plugins/wp-spamfree" target="_blank">http://www.hybrid6.com/webgeek/plugins/wp-spamfree</a></p>
	
			<p>&nbsp;</p>
	
			<p><strong>How does it feel to blog without being bombarded by automated comment spam?</strong> If you're happy with WP-SpamFree, feel free to <a href="http://www.hybrid6.com/webgeek/2007/11/wp-spamfree-1-wordpress-plugin-released.php#comments" target="_blank">post a comment letting others know!</a></p>
	
			<p>&nbsp;</p>
			
			<strong>Download Plugin / Documentation</strong><br />
			Latest Version: <a href="http://www.hybrid6.com/webgeek/downloads/wp-spamfree.zip" target="_blank">Download Now</a><br />
			Plugin Homepage / Documentation: <a href="http://www.hybrid6.com/webgeek/plugins/wp-spamfree">WP-SpamFree</a><br />
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
			echo "\n";
			echo '<!-- WP-SpamFree'.$wpSpamFreeVerJS.' JS Code :: BEGIN -->'."\n";
			echo '<script type="text/javascript" src="'.get_option('siteurl').'/wp-content/plugins/wp-spamfree/js/wpSpamFreeJS.php"></script> '."\n";
			echo '<!-- WP-SpamFree'.$wpSpamFreeVerJS.' JS Code :: END -->'."\n";
			echo "\n";
			// Modified following line in 1.6.3
			// update_option( 'ak_count_pre', get_option('akismet_spam_count') );
			}
			
		function install_on_activation() {
			global $wpdb;
			$plugin_db_version = "1.6.6";
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