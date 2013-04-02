<?php
class adminSEOPlus
{
	const SEOPLUS_META_ROBOT_VALUE = "seoplus_meta_robot_value";
	function setup_seoplus_admin_menu()
	{
		add_submenu_page('options-general.php', 'SEO+ Options', 'SEO+', 'manage_options', 'seoplus',array(&$this, 'seoplus_settings_page'));
		$args = array('public' => true,'_builtin' => false);
		$output = 'names';
		$operator = 'and';
		$post_types = get_post_types($args,$output,$operator);
		foreach ($post_types  as $post_type)
		{
			add_meta_box('seoplus_meta_robots', 'SEO PLUS Meta Robots', 'seoplus_meta_robots_checkboxes', $post_type, 'side', 'low');
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
			$local_settings_seoplus_meta_value = local_setting_get_post_meta_robot_tag($post_id, adminSEOPlus::SEOPLUS_META_ROBOT_VALUE, true);
			$local_settings_seoplus_meta_value = explode(",",$local_settings_seoplus_meta_value);
			$noindex = $local_settings_seoplus_meta_value[0];
			$nofollow = $local_settings_seoplus_meta_value[1];
		}
		else
		{
			$set_chk_robots_value = 'chk_noindex_for_' . $post->post_type;
			if(get_option($set_chk_robots_value) == "on")
				$noindex = "noindex";
			if(get_option($set_chk_robots_value) == "on")
				$nofollow = "nofollow";
		}
		echo '<fieldset id="mycustom-div">';
		echo '<div>';
		echo '<p>';
		echo '<input type="checkbox" id="chk_robots_for_noindex" name="chk_robots_for_noindex" '.if($noindex == "noindex"){  "checked=checked";}.' />&nbsp;&nbsp;&nbsp;&nbsp;NOINDEX<br />';
		echo '<input type="checkbox" id="chk_robots_for_nofollow" name="chk_robots_for_nofollow" '.if($noindex == "nofollow"){  "checked=checked";}.' />&nbsp;&nbsp;&nbsp;&nbsp;NOFOLLOW';
		echo '</p>';
		echo '</div>';
		echo '</fieldset>';
	}
	function seoplus_settings_page()
	{
	
	}
}
?>