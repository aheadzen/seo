<?php
/*
Plugin Name: SEO+
Plugin URI: http://www.ask-oracle.com/
Description: Generate meta robots based on the selected settings.
Author: Tapan Sodagar
Version: 0.1
Author URI: http://www.ask-oracle.com/
*/
include(dirname(__FILE__).'/class.admin.seoplus.php');
$seoplusadmin = new adminSEOPlus();
add_action('admin_menu', array($seoplusadmin, 'setup_seoplus_admin_menu'));
?>