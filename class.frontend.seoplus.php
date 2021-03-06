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
	
	const SEOPLUS_OPTION_ACTIVITY_COMPONENT_ACTION = "txt_activity_component_action";	
	const SEOPLUS_OPTION_PROFILE_COMPONENT_ACTION = "txt_profile_component_action";
	const SEOPLUS_OPTION_FRIENDS_COMPONENT_ACTION = "txt_friends_component_action";
	const SEOPLUS_OPTION_GROUPS_COMPONENT_ACTION = "txt_groups_component_action";

	const SEOPLUS_OPTION_ACTIVITY_COMPONENT = "txt_activity_component";
	const SEOPLUS_OPTION_GROUPS_COMPONENT = "txt_groups_component";
	const SEOPLUS_OPTION_MEMBER_COMPONENT = "txt_member_component";
	
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
		
		if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) )
		{
			if(is_shop())
			{
				$shop_page = get_post(woocommerce_get_page_id('shop'));
				$post_id = $shop_page->ID;
			}
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
	/* This function will generate buddypress custom titles re-generate titles that best supports google */
	function buddypress_custom_page_title()
	{
		global $bp, $post, $wp_query, $current_blog;
		$title = "";

		if(isset($bp->current_component) && isset($bp->current_action) && !empty($bp->current_component) && !empty($bp->current_action))
		{
			if($bp->current_component == "activity")
			{
				if(bp_is_active('activity'))
				{
					$option_to_be_called = frontendSEOPlus::SEOPLUS_OPTION_ACTIVITY_COMPONENT_ACTION;
					$exclude_action_name = "just-me";
					$title = $this->generate_title_for_component_action_option($option_to_be_called,$exclude_action_name);
				}
			}
			else if($bp->current_component == "profile" || $bp->current_component == "xprofile")
			{
				if(bp_is_active('profile') || bp_is_active('xprofile'))
				{					
					$option_to_be_called = frontendSEOPlus::SEOPLUS_OPTION_PROFILE_COMPONENT_ACTION;
					$exclude_action_name = "public";
					$title = $this->generate_title_for_component_action_option($option_to_be_called,$exclude_action_name);
				}
			}
			else if($bp->current_component == "friends")
			{
				if(bp_is_active('friends'))
				{
					$option_to_be_called = frontendSEOPlus::SEOPLUS_OPTION_FRIENDS_COMPONENT_ACTION;
					$exclude_action_name = "";
					$title = $this->generate_title_for_component_action_option($option_to_be_called,$exclude_action_name);
				}
			}
			else if($bp->current_component == "groups")
			{
				if(bp_is_active('groups'))
				{
					$option_to_be_called = frontendSEOPlus::SEOPLUS_OPTION_GROUPS_COMPONENT_ACTION;
					$exclude_action_name = "";
					$title = $this->generate_title_for_component_action_option($option_to_be_called,$exclude_action_name);
				}
			}
		}
		else if(isset($bp->current_component) && !empty($bp->current_component))
		{
			if($bp->current_component == "activity")
			{			
				$option_to_be_called = frontendSEOPlus::SEOPLUS_OPTION_ACTIVITY_COMPONENT;
				$title = $this->generate_title_for_main_component_page($option_to_be_called);
			}
			else if($bp->current_component == "groups")
			{
				$option_to_be_called = frontendSEOPlus::SEOPLUS_OPTION_GROUPS_COMPONENT;
				$title = $this->generate_title_for_main_component_page($option_to_be_called);			
			}
			else if($bp->current_component == "members")
			{
				$option_to_be_called = frontendSEOPlus::SEOPLUS_OPTION_MEMBER_COMPONENT;
				$title = $this->generate_title_for_main_component_page($option_to_be_called);
			}
		}
		if(bp_is_activity_component() && isset($_REQUEST['acpage']) && intval($_REQUEST['acpage']) != 1)
		{
			$title .= 'Page ' . intval($_REQUEST['acpage']);
		}
		if(bp_is_members_component() && isset($_REQUEST['upage']) && intval($_REQUEST['upage']) != 1)
		{
			$title .= 'Page ' . intval($_REQUEST['upage']);
		}
		if(bp_is_forums_component() && isset($_REQUEST['p']) && intval($_REQUEST['p']) != 1)
		{
			$title .= 'Page ' . intval($_REQUEST['p']);
		}
		
		$title = preg_replace( '|<span>[0-9]+</span>|', '', $title );
		return $title;
	}
	/* This function will generate buddypress custom titles when back-end options are not set */
	function set_page_title_for_member_pages($ignore_action)
	{
		$curr_action = bp_current_action();
		$skip_action = array($ignore_action);
		if(!empty($curr_action) && !in_array($curr_action, $skip_action))
			$title_action = ' &raquo; ' . ucwords(bp_current_action());
		$title = strip_tags(sprintf( __( '%1$s | %2$s%4$s%3$s', 'buddy' ), bp_get_displayed_user_fullname(), ucwords( bp_current_component()), $title_action, ''));
		return $title;
	}
	/* This function will generate buddypress titles for main component pages */
	function generate_title_for_main_component_page()
	{
		$option_value = get_option($option_to_be_called);
		if(isset($option_value) && !empty($option_value))
		{
			$title = $option_value;
		}
		return $title;
	}
	/* This function will generate buddypress titles for component / action page based on the back-end options */
	function generate_title_for_component_action_option($option_to_be_called,$exclude_action_name)
	{
		global $bp, $post, $wp_query, $current_blog;

		$option_for_component_action = get_option($option_to_be_called);
		if(isset($option_for_component_action) && !empty($option_for_component_action))
		{
			if(preg_match_all('/\%(.*?)\%/',$option_for_component_action,$match))
			{
				for($k=0;$k<count($match[1]);$k++)
				{
					if($match[1][$k] == "member_name")
					{										
						$search = "%" . "member_name" . "%";
						if($bp->displayed_user->fullname)
						{
							$replace = $bp->displayed_user->fullname;
						}
						$option_for_component_action = str_replace($search,$replace,$option_for_component_action);
					}
					else if($match[1][$k] == "component_name")
					{
						$search = "%" . "component_name" . "%";
						if(bp_current_component())
						{
							$replace = ucwords(bp_current_component());
						}
						$option_for_component_action = str_replace($search,$replace,$option_for_component_action);
					}
					else if($match[1][$k] == "action_name")
					{
						$search = "%" . "action_name" . "%";
						if(bp_current_action())
						{
							if($bp->current_component == "groups")
							{
								$replace = ucwords($bp->bp_options_nav[$bp->groups->current_group->slug][$bp->current_action]['name']);
							}
							else
							{
								$replace = ucwords(bp_current_action());
							}
						}
						$option_for_component_action = str_replace($search,$replace,$option_for_component_action);
					}
					else if($match[1][$k] == "group_name")
					{
						$search = "%" . "group_name" . "%";
						if($bp->bp_options_title)
						{
							$replace = $bp->bp_options_title;
						}
						$option_for_component_action = str_replace($search,$replace,$option_for_component_action);
					}
				}
			}
			if (bp_is_current_action('forum') && bp_is_action_variable('topic', 0))
			{
				if (bp_has_forum_topic_posts())
				{
					$title = bp_get_the_topic_title() . " | ";
					$subnav = '';
					if(isset($_REQUEST['topic_page']) && intval($_REQUEST['topic_page']) != 1)
					{
						$title .= 'Page ' . intval( $_REQUEST['topic_page'] ) . ' | ';
					}
				}
			}
			else
			{
				$title = $option_for_component_action;
			}
		}
		else if(!empty($bp->displayed_user->fullname) && !is_404())
		{
			$title .= $this->set_page_title_for_member_pages($exclude_action_name);
		}
		else
		{
			$subnav = isset( $bp->bp_options_nav[$bp->groups->current_group->slug][$bp->current_action]['name'] ) ? $bp->bp_options_nav[$bp->groups->current_group->slug][$bp->current_action]['name'] : '';
			if (bp_is_current_action('forum') && bp_is_action_variable('topic', 0))
			{
				if (bp_has_forum_topic_posts())
				{
					$title = bp_get_the_topic_title() . " | ";
					$subnav = '';
					if ( isset($_REQUEST['topic_page']) && intval($_REQUEST['topic_page']) != 1 )
					{
						$title .= 'Page ' . intval( $_REQUEST['topic_page'] ) . ' | ';
					}
				}
			}
			else $title = '';
			$sep1 = ' | ';
			if($subnav == 'Home' || empty( $subnav))
			{
				$sep1 = '';
				$subnav = '';
			}
			$title .= sprintf(__('%1$s%3$s%2$s%4$s', 'buddypress'), $bp->bp_options_title, $subnav, $sep1 , '');
		}
		return $title;
	}
	function seoplus_install()
	{
		add_option(frontendSEOPlus::SEOPLUS_OPTION_ACTIVITY_COMPONENT,'Activity Streams Directory');
		add_option(frontendSEOPlus::SEOPLUS_OPTION_GROUPS_COMPONENT,'Group Streams Directory');
		add_option(frontendSEOPlus::SEOPLUS_OPTION_MEMBER_COMPONENT,'Member Streams Directory');

		add_option(frontendSEOPlus::SEOPLUS_OPTION_ACTIVITY_COMPONENT_ACTION,'%member_name% | %component_name% � %action_name%');
		add_option(frontendSEOPlus::SEOPLUS_OPTION_PROFILE_COMPONENT_ACTION,'%member_name% | %component_name% � %action_name%');
		add_option(frontendSEOPlus::SEOPLUS_OPTION_FRIENDS_COMPONENT_ACTION,'%member_name% | %component_name% � %action_name%');
		add_option(frontendSEOPlus::SEOPLUS_OPTION_GROUPS_COMPONENT_ACTION,'%group_name% | %component_name% � %action_name%');
	}
	function seoplus_uninstall()
	{
		delete_option(frontendSEOPlus::SEOPLUS_OPTION_ACTIVITY_COMPONENT);
		delete_option(frontendSEOPlus::SEOPLUS_OPTION_GROUPS_COMPONENT);
		delete_option(frontendSEOPlus::SEOPLUS_OPTION_MEMBER_COMPONENT);

		delete_option(frontendSEOPlus::SEOPLUS_OPTION_ACTIVITY_COMPONENT_ACTION);
		delete_option(frontendSEOPlus::SEOPLUS_OPTION_PROFILE_COMPONENT_ACTION);
		delete_option(frontendSEOPlus::SEOPLUS_OPTION_FRIENDS_COMPONENT_ACTION);
		delete_option(frontendSEOPlus::SEOPLUS_OPTION_GROUPS_COMPONENT_ACTION);	
	}
}
?>