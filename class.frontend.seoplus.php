<?php
class frontendSEOPlus
{
	const SEOPLUS_META_ROBOT_VALUE = "seoplus_meta_robot_value";

	const SEOPLUS_COMMON_OPTION_NAME = "chk_robots_for_";
	const SEOPLUS_COMMON_NOFOLLOW = "chk_nofollow_for_";
	const SEOPLUS_COMMON_NOINDEX = "chk_noindex_for_";
	const SEOPLUS_COMMON_OVERRIDE_LOCAL = "chk_overide_local_setting_for_";
	
	const SEOPLUS_OPTION_NAME_PAGE = "page";
	const SEOPLUS_OPTION_NAME_POST = "post";
	const SEOPLUS_OPTION_NAME_MEMBERS_ACTIVITY = "members_activity";
	const SEOPLUS_OPTION_NAME_MEMBERS_MENTIONS = "members_mentions";
	const SEOPLUS_OPTION_NAME_MEMBERS_FAVORITES = "members_favorites";
	const SEOPLUS_OPTION_NAME_MEMBERS_FRIENDS = "members_friends";
	const SEOPLUS_OPTION_NAME_MEMBERS_GROUPS = "members_groups";
	const SEOPLUS_OPTION_NAME_FORUM_TOPICS = "topics";
	const SEOPLUS_OPTION_NAME_FORUM_REPLIED = "replied";
	const SEOPLUS_OPTION_NAME_PROFILE_PULIC = "public";
	const SEOPLUS_OPTION_NAME_FRIENDS = "friends";
	const SEOPLUS_OPTION_NAME_GROUPS = "groups";
	const SEOPLUS_OPTION_NAME_ACTIVITY = "activity";
	const SEOPLUS_OPTION_NAME_FORUMS = "forums";
	const SEOPLUS_OPTION_NAME_GROUPS_MAIN = "groups_main";
	
	
	function add_meta_robots_tag_in_head_section()
	{
		global $post;
		$post_id = $post->ID;
		$post_type = $post->post_type;
		if(trim($post->post_type) == "page")
		{
			if(bp_is_blog_page())
				$this->override_local_setting_section_to_display_frontend_robot(frontendSEOPlus::SEOPLUS_OPTION_NAME_PAGE);
			else
			{
				global $bp;
				if(bp_is_page('activity'))
					$this->display_frontend_robots_tag(frontendSEOPlus::SEOPLUS_OPTION_NAME_ACTIVITY);
				if(bp_is_page('forums'))
					$this->display_frontend_robots_tag(frontendSEOPlus::SEOPLUS_OPTION_NAME_FORUMS);
				if(bp_is_page('groups'))
				{
					if($bp->groups->current_group->id)
					{
						$group_id = $bp->groups->current_group->id;
						$group = groups_get_group(array('group_id' => $group_id));
						if($group->status == "private")
						{
							$noindex = "noindex";
							$nofollow = "nofollow";
							$this->output_meta_tag($nofollow,$noindex);
						}
						else
						{
							$this->display_frontend_robots_tag(frontendSEOPlus::SEOPLUS_OPTION_NAME_GROUPS_MAIN);
						}
					}
					else
					{
						$this->display_frontend_robots_tag(frontendSEOPlus::SEOPLUS_OPTION_NAME_GROUPS_MAIN);
					}
				}
				if(bp_is_user_activity())
				{
					$curr_action_for_activity = strtolower(bp_current_action());
					if($curr_action_for_activity == "just-me")
						$this->display_frontend_robots_tag(frontendSEOPlus::SEOPLUS_OPTION_NAME_MEMBERS_ACTIVITY);
					if($curr_action_for_activity == "mentions")
						$this->display_frontend_robots_tag(frontendSEOPlus::SEOPLUS_OPTION_NAME_MEMBERS_MENTIONS);
					if($curr_action_for_activity == "favorites")
						$this->display_frontend_robots_tag(frontendSEOPlus::SEOPLUS_OPTION_NAME_MEMBERS_FAVORITES);
					if($curr_action_for_activity == "friends")
						$this->display_frontend_robots_tag(frontendSEOPlus::SEOPLUS_OPTION_NAME_MEMBERS_FRIENDS);
					if($curr_action_for_activity == "groups")
						$this->display_frontend_robots_tag(frontendSEOPlus::SEOPLUS_OPTION_NAME_MEMBERS_GROUPS);
				}
				else if(bp_is_user_profile())
				{
					global $current_user;
					$curr_action_for_profile = strtolower(bp_current_action());
					$user_id = $current_user->ID;
					$field = xprofile_get_field_data('3', $user_id);
					if(strtolower($field) == "yes")
					{
						$noindex = "noindex";
						$nofollow = "nofollow";
						$this->output_meta_tag($nofollow,$noindex);
					}
					else
					{
						if($curr_action_for_profile == "public")
							$this->display_frontend_robots_tag(frontendSEOPlus::SEOPLUS_OPTION_NAME_PROFILE_PULIC);
					}
				}
				else if(bp_is_user_friends())
				{
					$curr_action_for_friends = strtolower(bp_current_action());					
					if($curr_action_for_friends == "my-friends")
						$this->display_frontend_robots_tag(frontendSEOPlus::SEOPLUS_OPTION_NAME_FRIENDS);
				}
				else if(bp_is_user_groups())
				{
					$curr_action_for_groups = strtolower(bp_current_action());
					if($curr_action_for_groups == "my-groups")
						$this->display_frontend_robots_tag(frontendSEOPlus::SEOPLUS_OPTION_NAME_GROUPS);
				}
				else if(bp_is_user_forums())
				{
					$curr_action_for_forums = strtolower(bp_current_action());
					if($curr_action_for_forums == "topics")
						$this->display_frontend_robots_tag(frontendSEOPlus::SEOPLUS_OPTION_NAME_FORUM_TOPICS);
					else if($curr_action_for_forums == "replies")
						$this->display_frontend_robots_tag(frontendSEOPlus::SEOPLUS_OPTION_NAME_FORUM_REPLIED);
				}
			}
		}
		else if(trim($post->post_type) == "post")
		{
			$this->override_local_setting_section_to_display_frontend_robot(frontendSEOPlus::SEOPLUS_OPTION_NAME_POST);
		}
		else
		{
			if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) && woocommerce_get_page_id('shop') && is_shop())
			{				
				$this->override_local_setting_section_to_display_frontend_robot(frontendSEOPlus::SEOPLUS_OPTION_NAME_POST);
			}
			else
			{
				$args = array('public' => true,'_builtin' => false);
				$output = 'names';
				$operator = 'and';
				$post_types = get_post_types($args,$output,$operator);
				$this->override_local_setting_section_to_display_frontend_robot($post_type);
			}
		}
	}
	
	
	function override_local_setting_section_to_display_frontend_robot($field_prefix)
	{
		global $post;
		
		if(is_shop())
		{
			$shop_page = get_post(woocommerce_get_page_id('shop'));
			$post_id = $shop_page->ID;
		}
		else
		{
			$post_id = $post->ID;
		}
		
		$option_name_for_post_type = frontendSEOPlus::SEOPLUS_COMMON_OPTION_NAME . $field_prefix;
		$option_name_for_global_override_local = frontendSEOPlus::SEOPLUS_COMMON_OVERRIDE_LOCAL . $field_prefix;
		$option_name_noindex_for_post_type = frontendSEOPlus::SEOPLUS_COMMON_NOINDEX . $field_prefix;
		$option_name_nofollow_for_post_type = frontendSEOPlus::SEOPLUS_COMMON_NOFOLLOW . $field_prefix;
		

		if(get_option("$option_name_for_post_type") == "on")
		{
			if(get_option("$option_name_for_global_override_local") == "on")
			{
				$noindex = "index";
				if(get_option("$option_name_noindex_for_post_type") == "on")
					$noindex = "noindex";
				$nofollow = "follow";
				if(get_option("$option_name_nofollow_for_post_type") == "on")
					$nofollow = "nofollow";
				if(!($noindex == "index" && $nofollow == "follow"))
				{
					$this->output_meta_tag($nofollow,$noindex);
				}
			}
			else
			{
				if(get_post_meta($post_id, frontendSEOPlus::SEOPLUS_META_ROBOT_VALUE, true))
				{
					$this->set_post_meta_robot_tag($post_id, frontendSEOPlus::SEOPLUS_META_ROBOT_VALUE, true);
				}
			}
		}
	}
		
	function display_frontend_robots_tag($field_prefix)
	{
		$option_name_for_post_type = frontendSEOPlus::SEOPLUS_COMMON_OPTION_NAME . $field_prefix;
		$option_name_noindex_for_post_type = frontendSEOPlus::SEOPLUS_COMMON_NOINDEX . $field_prefix;
		$option_name_nofollow_for_post_type = frontendSEOPlus::SEOPLUS_COMMON_NOFOLLOW . $field_prefix;
	
		if(get_option($option_name_for_post_type) == "on")
		{
			$noindex = "index";
			if(get_option("$option_name_noindex_for_post_type") == "on")
				$noindex = "noindex";
			$nofollow = "follow";
			if(get_option("$option_name_nofollow_for_post_type") == "on")
				$nofollow = "nofollow";
			if(!($noindex == "index" && $nofollow == "follow"))
			{
				$this->output_meta_tag($nofollow,$noindex);
			}
		}
	}
	
	function set_post_meta_robot_tag($post_id, $meta_id, $boolean)
	{
		$meta_value_onsite_robots_for_frontend = get_post_meta($post_id, $meta_id, $boolean);
		$meta_value_onsite_robots_for_frontend = unserialize($meta_value_onsite_robots_for_frontend);
		
		$noindex = "index";
		if($meta_value_onsite_robots_for_frontend['noindex'] == true)
			$noindex = "noindex";
		$nofollow = "follow";	
		if($meta_value_onsite_robots_for_frontend['nofollow'] == true)
			$nofollow = "nofollow";
		$meta_value_onsite_robots_for_frontend =  $noindex . ", " . $nofollow;
		if($meta_value_onsite_robots_for_frontend != "index, follow")
		{
			$this->output_meta_tag($noindex,$nofollow);
		}
	}
	
	function output_meta_tag($nofollow,$noindex)
	{
		echo '<!-- SEO+ plugin -->';
		echo '<meta name="robots" content="'.$nofollow. ', ' . $noindex.'" />'."\n";
	}
	
}
?>