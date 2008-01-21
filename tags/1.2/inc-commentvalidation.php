<?php
// CHECK COOKIE TO PREVENT COMMENT SPAM FROM BOTS :: BEGIN
$WPCommentValidationJS=$_COOKIE['WPCOMVALJ'];

// STATUS VERIFICATION
if ($WPCommentValidationJS!='1') {
    wp_die( __('Sorry, there was an error. Please enable JavaScript and Cookies in your browser and try again.') );
	}
// CHECK COOKIE TO PREVENT COMMENT SPAM FROM BOTS :: END
?>