<?php
class adminSEOPlus
{
	const SEOPLUS_META_ROBOT_VALUE = "seoplus_meta_robot_value";
	const GLOBAL_OPTION_NOINDEX = "chk_robots_for_noindex";
	const GLOBAL_OPTION_NOFOLLOW = "chk_robots_for_nofollow";
	const GLOBAL_OPTION_TYPE = "chk_noindex_for_";
	
	function setup_seoplus_admin_menu()
	{
		add_submenu_page('options-general.php', 'SEO+ Options', 'SEO+', 'manage_options', 'seoplus',array(&$this, 'seoplus_settings_page'));
		$args = array('public' => true,'_builtin' => false);
		$output = 'names';
		$operator = 'and';
		$post_types = get_post_types($args,$output,$operator);
		foreach ($post_types  as $post_type)
		{
			add_meta_box('seoplus_meta_robots', 'SEO PLUS Meta Robots', array(&$this, 'seoplus_meta_robots_checkboxes'), $post_type, 'side', 'low');
		}
		add_meta_box('seoplus_meta_robots', 'SEO PLUS Meta Robots', array(&$this, 'seoplus_meta_robots_checkboxes'), 'post', 'side', 'low');
		add_meta_box('seoplus_meta_robots', 'SEO PLUS Meta Robots', array(&$this, 'seoplus_meta_robots_checkboxes'), 'page', 'side', 'low');
	}
	function seoplus_meta_robots_checkboxes()
	{
		global $post;
		$post_id = $post->ID;
		if(get_post_meta($post_id, adminSEOPlus::SEOPLUS_META_ROBOT_VALUE, true))
		{
			$local_settings_seoplus_meta_value = $this->local_setting_get_post_meta_robot_tag($post_id, adminSEOPlus::SEOPLUS_META_ROBOT_VALUE, true);
			$local_settings_seoplus_meta_value = explode(",",$local_settings_seoplus_meta_value);
			$noindex = $local_settings_seoplus_meta_value[0];
			$nofollow = $local_settings_seoplus_meta_value[1];
		}
		else
		{
			$set_chk_robots_value = adminSEOPlus::GLOBAL_OPTION_TYPE . $post->post_type;
			if(get_option($set_chk_robots_value) == "on")
				$noindex = "noindex";
			if(get_option($set_chk_robots_value) == "on")
				$nofollow = "nofollow";
		}
		if($noindex == "noindex")
			$chk_checked_noindex =  "checked=checked";
		if($nofollow == "nofollow")
			$chk_checked_nofollow =  "checked=checked";
		echo '<fieldset id="mycustom-div">';
		echo '<div>';
		echo '<p>';
		echo '<input type="checkbox" id="'.adminSEOPlus::GLOBAL_OPTION_NOINDEX.'" name="'.adminSEOPlus::GLOBAL_OPTION_NOINDEX.'" '.$chk_checked_noindex.'>&nbsp;&nbsp;&nbsp;&nbsp;NOINDEX<br />';
		echo '<input type="checkbox" id="'.adminSEOPlus::GLOBAL_OPTION_NOFOLLOW.'" name="'.adminSEOPlus::GLOBAL_OPTION_NOFOLLOW.'" '.$chk_checked_nofollow.'>&nbsp;&nbsp;&nbsp;&nbsp;NOFOLLOW';
		echo '</p>';
		echo '</div>';
		echo '</fieldset>';
	}
	function seoplus_settings_page()
	{
		global $bp,$post;
		include(dirname(__FILE__).'/admin.seoplus.settings.php');
	}
	function local_setting_get_post_meta_robot_tag($post_id, $meta_id, $boolean)
	{
		$meta_value_seoplus_robots_for_frontend = get_post_meta($post_id, $meta_id, $boolean);
		$meta_value_seoplus_robots_for_frontend = unserialize($meta_value_seoplus_robots_for_frontend);
		$noindex = "index";
		if($meta_value_seoplus_robots_for_frontend['noindex'] == true)
			$noindex = "noindex";
		$nofollow = "follow";
		if($meta_value_seoplus_robots_for_frontend['nofollow'] == true)
			$nofollow = "nofollow";
		return $noindex . "," . $nofollow;
	}
	function meta_robots_save_post()
	{
		global $post;
		$post_id = $post->ID;
		$noindex = $_POST[adminSEOPlus::GLOBAL_OPTION_NOINDEX];
		$nofollow = $_POST[adminSEOPlus::GLOBAL_OPTION_NOFOLLOW];
		
		if((isset($noindex) && !empty($noindex)) && (isset($nofollow) && !empty($nofollow)))
		{
			$value = array('noindex' => true, "nofollow" => true);
			$value = serialize($value);
		}	
		else if((!isset($noindex) && empty($noindex)) && (isset($nofollow) && !empty($nofollow)))
		{
			$value = array('noindex' => false, "nofollow" => true);
			$value = serialize($value);
		}	
		else if((isset($noindex) && !empty($noindex)) && (!isset($nofollow) && empty($nofollow)))
		{
			$value = array('noindex' => true, "nofollow" => false);
			$value = serialize($value);
		}	
		else
		{
			$value = array('noindex' => false, "nofollow" => false);
			$value = serialize($value);
		}
		$new_meta_value = ( isset( $value ) ? $value : '' );
		$meta_key = adminSEOPlus::SEOPLUS_META_ROBOT_VALUE;
		$meta_value = get_post_meta($post_id, $meta_key, true);
				
		if($new_meta_value && '' == $meta_value)
		{
			add_post_meta($post_id, $meta_key, $new_meta_value, true);
		}
		elseif($new_meta_value && $new_meta_value != $meta_value)
		{
			update_post_meta($post_id, $meta_key, $new_meta_value);	
		}	
		elseif ('' == $new_meta_value && $meta_value)
		{
			delete_post_meta($post_id, $meta_key, $meta_value);
		}	
	}	
}
?>