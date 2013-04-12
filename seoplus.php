<?php
/*
Plugin Name: SEO+
Plugin URI: http://www.ask-oracle.com/
Description: Generate meta robots based on the selected settings.
Author: Tapan Sodagar
Version: 0.2
Author URI: http://www.ask-oracle.com/
*/
include(dirname(__FILE__).'/class.admin.seoplus.php');
include(dirname(__FILE__).'/class.frontend.seoplus.php');
$seoplusadmin = new adminSEOPlus();
$seoplusfrontend = new frontendSEOPlus();
add_action('admin_menu', array($seoplusadmin, 'setup_seoplus_admin_menu'));
add_action('edit_post', array($seoplusadmin, 'meta_robots_save_post'));
add_action('wp_head', array($seoplusfrontend, 'add_meta_robots_tag_in_head_section'));
add_filter('bp_modify_page_title',array($seoplusfrontend, 'buddypress_custom_page_title'));
add_action('init', array($seoplusfrontend, 'seoplus_install'));
register_deactivation_hook(__FILE__, array($seoplusfrontend, 'seoplus_uninstall'));
?>