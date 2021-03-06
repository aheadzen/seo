<?php
/*
Plugin Name: Onsite SEO
Plugin URI: http://www.ask-oracle.com/
Description: Admin Control for managining onpage seo items
Author: Tapan Sodagar
Version: 1.0
Author URI: http://www.ask-oracle.com/
*/
	function add_meta_robots_tag_for_custom_post()
	{
		global $post;
		$post_id = $post->ID;
		$post_type = $post->post_type;
		
						
		if(trim($post->post_type) == "page")
		{
			if(bp_is_blog_page())
			{
				$option_name_for_post_type = "chk_robots_for_pages";
				$option_name_for_global_override_local = "chk_overide_local_setting_for_pages";
				$option_name_noindex_for_post_type = "chk_noindex_for_pages";
				$option_name_nofollow_for_post_type = "chk_nofollow_for_pages";
				
				override_local_setting_section_to_display_frontend_robot($option_name_for_post_type,$option_name_for_global_override_local,$option_name_noindex_for_post_type,$option_name_nofollow_for_post_type);
			}
			else
			{
				global $bp;
				if(bp_is_page('activity'))
				{
					$option_name = "chk_robots_for_buddypress_activity";
					$option_name_noindex = "chk_noindex_for_buddypress_activity";
					$option_name_nofollow = "chk_nofollow_for_buddypress_activity";
					display_frontend_robots_tag($option_name,$option_name_noindex,$option_name_nofollow);
				}
				if(bp_is_page('forums'))
				{
					$option_name = "chk_robots_for_buddypress_forums";
					$option_name_noindex = "chk_noindex_for_buddypress_forums";
					$option_name_nofollow = "chk_nofollow_for_buddypress_forums";
					display_frontend_robots_tag($option_name,$option_name_noindex,$option_name_nofollow);
				}
				if(bp_is_page('groups'))
				{
					if($bp->groups->current_group->id)
					{
						$group_id = $bp->groups->current_group->id;
						$group = groups_get_group(array('group_id' => $group_id));
						if($group->status == "private")
						{
							echo '<!-- onsite seo plugin -->';
							echo '<meta name="robots" content="noindex, nofollow" />'."\n";
						}
						else
						{
							$option_name = "chk_robots_for_buddypress_groups_main";
							$option_name_noindex = "chk_noindex_for_buddypress_groups_main";
							$option_name_nofollow = "chk_nofollow_for_buddypress_groups_main";
							display_frontend_robots_tag($option_name,$option_name_noindex,$option_name_nofollow);
						}
					}
					else
					{
						$option_name = "chk_robots_for_buddypress_groups_main";
						$option_name_noindex = "chk_noindex_for_buddypress_groups_main";
						$option_name_nofollow = "chk_nofollow_for_buddypress_groups_main";
						display_frontend_robots_tag($option_name,$option_name_noindex,$option_name_nofollow);
					}
				}
				if(bp_is_user_activity())
				{
					$curr_action = bp_current_action();
					$curr_action_for_activity = strtolower($curr_action);				
					
					if($curr_action_for_activity == "just-me")
					{
						$option_name = "chk_robots_for_buddypress_members_activity";
						$option_name_noindex = "chk_noindex_for_buddypress_members_activity";
						$option_name_nofollow = "chk_nofollow_for_buddypress_members_activity";
						display_frontend_robots_tag($option_name,$option_name_noindex,$option_name_nofollow);
					}
					
					if($curr_action_for_activity == "mentions")
					{
						$option_name = "chk_robots_for_buddypress_members_mentions";
						$option_name_noindex = "chk_noindex_for_buddypress_members_mentions";
						$option_name_nofollow = "chk_nofollow_for_buddypress_members_mentions";
						display_frontend_robots_tag($option_name,$option_name_noindex,$option_name_nofollow);
					}

					if($curr_action_for_activity == "favorites")
					{
						$option_name = "chk_robots_for_buddypress_members_favorites";
						$option_name_noindex = "chk_noindex_for_buddypress_members_favorites";
						$option_name_nofollow = "chk_nofollow_for_buddypress_members_favorites";
						display_frontend_robots_tag($option_name,$option_name_noindex,$option_name_nofollow);					
					}
					
					if($curr_action_for_activity == "friends")
					{
						$option_name = "chk_robots_for_buddypress_members_friends";
						$option_name_noindex = "chk_noindex_for_buddypress_members_friends";
						$option_name_nofollow = "chk_nofollow_for_buddypress_members_friends";
						display_frontend_robots_tag($option_name,$option_name_noindex,$option_name_nofollow);
					}
					if($curr_action_for_activity == "groups")
					{
						$option_name = "chk_robots_for_buddypress_members_groups";
						$option_name_noindex = "chk_noindex_for_buddypress_members_groups";
						$option_name_nofollow = "chk_nofollow_for_buddypress_members_groups";
						display_frontend_robots_tag($option_name,$option_name_noindex,$option_name_nofollow);					
					}
				}
				else if(bp_is_user_profile())
				{
					global $current_user;
					$curr_action = bp_current_action();
					$curr_action_for_profile = strtolower($curr_action);
					$user_id = $current_user->ID;
					$field = xprofile_get_field_data('3', $user_id);
					if(strtolower($field) == "yes")
					{
						echo '<!-- onsite seo plugin -->';
						echo '<meta name="robots" content="noindex, nofollow" />'."\n";
					}
					else
					{
						if($curr_action_for_profile == "public")
						{
							$option_name = "chk_robots_for_buddypress_profile_public";
							$option_name_noindex = "chk_noindex_for_buddypress_profile_public";
							$option_name_nofollow = "chk_nofollow_for_buddypress_profile_public";
							display_frontend_robots_tag($option_name,$option_name_noindex,$option_name_nofollow);
						}
					}					
				}
				else if(bp_is_user_friends())
				{
					$curr_action = bp_current_action();
					$curr_action_for_friends = strtolower($curr_action);
					
					if($curr_action_for_friends == "my-friends")
					{
						$option_name = "chk_robots_for_buddypress_friends_friendship";
						$option_name_noindex = "chk_noindex_for_buddypress_friends_friendship";
						$option_name_nofollow = "chk_nofollow_for_buddypress_friends_friendship";
						display_frontend_robots_tag($option_name,$option_name_noindex,$option_name_nofollow);					
					}
				}
				else if(bp_is_user_groups())
				{
					$curr_action = bp_current_action();
					$curr_action_for_groups = strtolower($curr_action);
					
					if($curr_action_for_groups == "my-groups")
					{
						$option_name = "chk_robots_for_buddypress_groups";
						$option_name_noindex = "chk_noindex_for_buddypress_groups";
						$option_name_nofollow = "chk_nofollow_for_buddypress_groups";
						display_frontend_robots_tag($option_name,$option_name_noindex,$option_name_nofollow);
					}
				}
				else if(bp_is_user_forums())
				{
					$curr_action = bp_current_action();
					$curr_action_for_forums = strtolower($curr_action);

					if($curr_action_for_forums == "topics")
					{
						$option_name = "chk_robots_for_buddypress_members_forums_topics";
						$option_name_noindex = "chk_noindex_for_buddypress_members_forums_topics";
						$option_name_nofollow = "chk_nofollow_for_buddypress_members_forums_topics";
						display_frontend_robots_tag($option_name,$option_name_noindex,$option_name_nofollow);					
					}
					else if($curr_action_for_forums == "replies")
					{
						$option_name = "chk_robots_for_buddypress_members_forums_replied";
						$option_name_noindex = "chk_noindex_for_buddypress_members_forums_replied";
						$option_name_nofollow = "chk_nofollow_for_buddypress_members_forums_replied";
						display_frontend_robots_tag($option_name,$option_name_noindex,$option_name_nofollow);
					}
				}
			}			
		}
		else if(trim($post->post_type) == "post")
		{
			$option_name_for_post_type = "chk_robots_for_post";
			$option_name_for_global_override_local = "chk_overide_local_setting_for_post";
			$option_name_noindex_for_post_type = "chk_noindex_for_post";
			$option_name_nofollow_for_post_type = "chk_nofollow_for_post";
				
			override_local_setting_section_to_display_frontend_robot($option_name_for_post_type,$option_name_for_global_override_local,$option_name_noindex_for_post_type,$option_name_nofollow_for_post_type);
		}
		else
		{	
			if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) && woocommerce_get_page_id('shop'))
			{
					$shop_page = get_post(woocommerce_get_page_id('shop'));
					$post_id = $shop_page->ID;
					
					$option_name_for_post_type = "chk_robots_for_pages";
					$option_name_for_global_override_local = "chk_overide_local_setting_for_pages";
					$option_name_noindex_for_post_type = "chk_noindex_for_pages";
					$option_name_nofollow_for_post_type = "chk_nofollow_for_pages";
											
					override_local_setting_section_to_display_frontend_robot($option_name_for_post_type,$option_name_for_global_override_local,$option_name_noindex_for_post_type,$option_name_nofollow_for_post_type);
			}	
			else
			{
				$args = array('public' => true,'_builtin' => false);
				$output = 'names';
				$operator = 'and';
				$post_types = get_post_types($args,$output,$operator);
				
				$option_name_for_post_type = "chk_robots_for_"  . $post->post_type;
				$option_name_for_global_override_local = "chk_overide_local_setting_for_" . $post->post_type;
				$option_name_noindex_for_post_type = "chk_noindex_for_" . $post->post_type;
				$option_name_nofollow_for_post_type = "chk_nofollow_for_" . $post->post_type;
					
				override_local_setting_section_to_display_frontend_robot($option_name_for_post_type,$option_name_for_global_override_local,$option_name_noindex_for_post_type,$option_name_nofollow_for_post_type);
			}
		}	
	}
	function setup_onsite_seo_admin_menus()
	{
		add_submenu_page('options-general.php', 'Onsite SEO Options', 'Onsite SEO', 'manage_options', 'onsite-seo','theme_onsiteseo_settings_page');
		$args = array('public' => true,'_builtin' => false);
		$output = 'names';
		$operator = 'and';
		$post_types = get_post_types($args,$output,$operator);
		foreach ($post_types  as $post_type)
		{
			add_meta_box('onsite_meta_robots', 'Onsite SEO Meta Robots', 'onsite_meta_robots_dropdown_box', $post_type, 'side', 'low');
		}
		add_meta_box('onsite_meta_robots', 'Onsite SEO Meta Robots', 'onsite_meta_robots_dropdown_box', 'post', 'side', 'low');
		add_meta_box('onsite_meta_robots', 'Onsite SEO Meta Robots', 'onsite_meta_robots_dropdown_box', 'page', 'side', 'low');
	}
	function theme_onsiteseo_settings_page()
	{
		global $bp,$post;
?>
    	<div class="wrap">
			<?php screen_icon('themes'); ?><h2>OnSite SEO Settings</h2>
			<form method="post" action="options.php">
				<?php wp_nonce_field('update-options') ?>  
				<table class="form-table">
					<tr valign="top">
						<td><input type="checkbox" id="chk_robots_for_pages" name="chk_robots_for_pages" <?php if(get_option('chk_robots_for_pages') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Pages</td>
						<td><input type="checkbox" id="chk_noindex_for_pages" name="chk_noindex_for_pages" <?php if(get_option('chk_noindex_for_pages') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
						<td><input type="checkbox" id="chk_nofollow_for_pages" name="chk_nofollow_for_pages" <?php if(get_option('chk_nofollow_for_pages') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
						<td><input type="checkbox" id="chk_overide_local_setting_for_pages" name="chk_overide_local_setting_for_pages" <?php if(get_option('chk_overide_local_setting_for_pages') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Global Override Local Setting</td>
						<?php $params = array('posttype'=> 'page', 'action' => 'delete' );?>
						<td><a href="<?php echo add_query_arg($params,admin_url('options-general.php?page=onsite-seo') );?>" class="button">Delete all local data</a></td>
					</tr>					
					<tr valign="top">
						<td><input type="checkbox" id="chk_robots_for_post" name="chk_robots_for_post" <?php if(get_option('chk_robots_for_post') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Posts</td>
						<td><input type="checkbox" id="chk_noindex_for_post" name="chk_noindex_for_post" <?php if(get_option('chk_noindex_for_post') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
						<td><input type="checkbox" id="chk_nofollow_for_post" name="chk_nofollow_for_post" <?php if(get_option('chk_nofollow_for_post') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
						<td><input type="checkbox" id="chk_overide_local_setting_for_post" name="chk_overide_local_setting_for_post" <?php if(get_option('chk_overide_local_setting_for_post') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Global Override Local Setting</td>
						<?php $params = array('posttype'=> 'post', 'action' => 'delete' );?>
						<td><a href="<?php echo add_query_arg($params,admin_url('options-general.php?page=onsite-seo') );?>" class="button">Delete all local data</a></td>
					</tr>
					<?php 
						$args=array(
						  'public'   => true,
						  '_builtin' => false
						); 
						$output = 'names'; // names or objects, note names is the default
						$operator = 'and'; // 'and' or 'or'
						$post_types=get_post_types($args,$output,$operator);
						$get_all_post_types = array();
						foreach ($post_types  as $post_type)
						{
							$get_all_post_types[] = "chk_robots_for_" . $post_type . ",chk_noindex_for_" . $post_type . ",chk_nofollow_for_" . $post_type . ",chk_overide_local_setting_for_" . $post_type;
					?>
							<tr valign="top">
								<td><input type="checkbox" id="chk_robots_for_<?php echo $post_type;?>" name="chk_robots_for_<?php echo $post_type;?>" <?php $custom_post_type_name = 'chk_robots_for_' . $post_type;if(get_option($custom_post_type_name) == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for <?php echo $post_type;?></td>
								<td><input type="checkbox" id="chk_noindex_for_<?php echo $post_type;?>" name="chk_noindex_for_<?php echo $post_type;?>" <?php $custom_post_type_name = 'chk_noindex_for_' . $post_type;if(get_option($custom_post_type_name) == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
								<td><input type="checkbox" id="chk_nofollow_for_<?php echo $post_type;?>" name="chk_nofollow_for_<?php echo $post_type;?>" <?php $custom_post_type_name = 'chk_nofollow_for_' . $post_type;if(get_option($custom_post_type_name) == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
								<td><input type="checkbox" id="chk_overide_local_setting_for_<?php echo $post_type;?>" name="chk_overide_local_setting_for_<?php echo $post_type;?>" <?php $dynamic_override_local_seetings = 'chk_overide_local_setting_for_' . $post_type;if(get_option($dynamic_override_local_seetings) == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Global Override Local Setting</td>
								<?php $params = array('posttype'=> $post_type, 'action' => 'delete' );?>
								<td><a href="<?php echo add_query_arg($params,admin_url('options-general.php?page=onsite-seo') );?>" class="button">Delete all local data</a></td>
							</tr>
					
					<?php
						}
						$get_all_post_types = implode(", ",$get_all_post_types);
					?>
					<?php
						if(defined('BP_VERSION'))
						{
							if(bp_is_active('members'))
							{
								echo "<tr><td colspan='5'><h3>Member Module Buddypress Options</h3></td><tr>";
								if(bp_is_active('activity'))
								{
					?>
									<tr valign="top">
										<td><input type="checkbox" id="chk_robots_for_buddypress_members_activity" name="chk_robots_for_buddypress_members_activity" <?php if(get_option('chk_robots_for_buddypress_members_activity') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Members Activity</td>
										<td><input type="checkbox" id="chk_noindex_for_buddypress_members_activity" name="chk_noindex_for_buddypress_members_activity" <?php if(get_option('chk_noindex_for_buddypress_members_activity') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
										<td><input type="checkbox" id="chk_nofollow_for_buddypress_members_activity" name="chk_nofollow_for_buddypress_members_activity" <?php if(get_option('chk_nofollow_for_buddypress_members_activity') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
									</tr>
									<tr valign="top">
										<td><input type="checkbox" id="chk_robots_for_buddypress_members_mentions" name="chk_robots_for_buddypress_members_mentions" <?php if(get_option('chk_robots_for_buddypress_members_mentions') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Members Activity -> Mentions</td>
										<td><input type="checkbox" id="chk_noindex_for_buddypress_members_mentions" name="chk_noindex_for_buddypress_members_mentions" <?php if(get_option('chk_noindex_for_buddypress_members_mentions') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
										<td><input type="checkbox" id="chk_nofollow_for_buddypress_members_mentions" name="chk_nofollow_for_buddypress_members_mentions" <?php if(get_option('chk_nofollow_for_buddypress_members_mentions') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
									</tr>
									<tr valign="top">
										<td><input type="checkbox" id="chk_robots_for_buddypress_members_favorites" name="chk_robots_for_buddypress_members_favorites" <?php if(get_option('chk_robots_for_buddypress_members_favorites') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Members Activity -> Favorites</td>
										<td><input type="checkbox" id="chk_noindex_for_buddypress_members_favorites" name="chk_noindex_for_buddypress_members_favorites" <?php if(get_option('chk_noindex_for_buddypress_members_favorites') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
										<td><input type="checkbox" id="chk_nofollow_for_buddypress_members_favorites" name="chk_nofollow_for_buddypress_members_favorites" <?php if(get_option('chk_nofollow_for_buddypress_members_favorites') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
									</tr>
									<?php
										if(bp_is_active('friends'))
										{
									?>
									<tr valign="top">
										<td><input type="checkbox" id="chk_robots_for_buddypress_members_friends" name="chk_robots_for_buddypress_members_friends" <?php if(get_option('chk_robots_for_buddypress_members_friends') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Members Activity -> Friends</td>
										<td><input type="checkbox" id="chk_noindex_for_buddypress_members_friends" name="chk_noindex_for_buddypress_members_friends" <?php if(get_option('chk_noindex_for_buddypress_members_friends') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
										<td><input type="checkbox" id="chk_nofollow_for_buddypress_members_friends" name="chk_nofollow_for_buddypress_members_friends" <?php if(get_option('chk_nofollow_for_buddypress_members_friends') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
									</tr>
									<?php
										}
									?>
									<?php
										if(bp_is_active('groups'))
										{
									?>
										<tr valign="top">
											<td><input type="checkbox" id="chk_robots_for_buddypress_members_groups" name="chk_robots_for_buddypress_members_groups" <?php if(get_option('chk_robots_for_buddypress_members_groups') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Members Activity -> Groups</td>
											<td><input type="checkbox" id="chk_noindex_for_buddypress_members_groups" name="chk_noindex_for_buddypress_members_groups" <?php if(get_option('chk_noindex_for_buddypress_members_groups') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
											<td><input type="checkbox" id="chk_nofollow_for_buddypress_members_groups" name="chk_nofollow_for_buddypress_members_groups" <?php if(get_option('chk_nofollow_for_buddypress_members_groups') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
										</tr>
									<?php
										}
									}	
									?>
									<?php
										if(bp_is_active('forums'))
										{
									?>									
									<tr valign="top">
										<td><input type="checkbox" id="chk_robots_for_buddypress_members_forums_topics" name="chk_robots_for_buddypress_members_forums_topics" <?php if(get_option('chk_robots_for_buddypress_members_forums_topics') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Members Forums -> Topics Started</td>
										<td><input type="checkbox" id="chk_noindex_for_buddypress_members_forums_topics" name="chk_noindex_for_buddypress_members_forums_topics" <?php if(get_option('chk_noindex_for_buddypress_members_forums_topics') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
										<td><input type="checkbox" id="chk_nofollow_for_buddypress_members_forums_topics" name="chk_nofollow_for_buddypress_members_forums_topics" <?php if(get_option('chk_nofollow_for_buddypress_members_forums_topics') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
									</tr>
									<tr valign="top">
										<td><input type="checkbox" id="chk_robots_for_buddypress_members_forums_replied" name="chk_robots_for_buddypress_members_forums_replied" <?php if(get_option('chk_robots_for_buddypress_members_forums_replied') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Members Forums -> Replied To</td>
										<td><input type="checkbox" id="chk_noindex_for_buddypress_members_forums_replied" name="chk_noindex_for_buddypress_members_forums_replied" <?php if(get_option('chk_noindex_for_buddypress_members_forums_replied') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
										<td><input type="checkbox" id="chk_nofollow_for_buddypress_members_forums_replied" name="chk_nofollow_for_buddypress_members_forums_replied" <?php if(get_option('chk_nofollow_for_buddypress_members_forums_replied') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
									</tr>
									<?php
										}
									?>																		
									<tr valign="top">
										<td><input type="checkbox" id="chk_robots_for_buddypress_profile_public" name="chk_robots_for_buddypress_profile_public" <?php if(get_option('chk_robots_for_buddypress_profile_public') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Members Profile -> Public</td>
										<td><input type="checkbox" id="chk_noindex_for_buddypress_profile_public" name="chk_noindex_for_buddypress_profile_public" <?php if(get_option('chk_noindex_for_buddypress_profile_public') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
										<td><input type="checkbox" id="chk_nofollow_for_buddypress_profile_public" name="chk_nofollow_for_buddypress_profile_public" <?php if(get_option('chk_nofollow_for_buddypress_profile_public') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
									</tr>
									<?php
										if(bp_is_active('friends'))
										{
									?>
									<tr valign="top">
										<td><input type="checkbox" id="chk_robots_for_buddypress_friends_friendship" name="chk_robots_for_buddypress_friends_friendship" <?php if(get_option('chk_robots_for_buddypress_friends_friendship') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Members Friends -> Friendship</td>
										<td><input type="checkbox" id="chk_noindex_for_buddypress_friends_friendship" name="chk_noindex_for_buddypress_friends_friendship" <?php if(get_option('chk_noindex_for_buddypress_friends_friendship') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
										<td><input type="checkbox" id="chk_nofollow_for_buddypress_friends_friendship" name="chk_nofollow_for_buddypress_friends_friendship" <?php if(get_option('chk_nofollow_for_buddypress_friends_friendship') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
									</tr>
									<?php
										}
									?>
									<?php
										if(bp_is_active('groups'))
										{
									?>
									<tr valign="top">
										<td><input type="checkbox" id="chk_robots_for_buddypress_groups" name="chk_robots_for_buddypress_groups" <?php if(get_option('chk_robots_for_buddypress_groups') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Members Groups</td>
										<td><input type="checkbox" id="chk_noindex_for_buddypress_groups" name="chk_noindex_for_buddypress_groups" <?php if(get_option('chk_noindex_for_buddypress_groups') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
										<td><input type="checkbox" id="chk_nofollow_for_buddypress_groups" name="chk_nofollow_for_buddypress_groups" <?php if(get_option('chk_nofollow_for_buddypress_groups') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
									</tr>
									<?php
										}
									?>
					<?php
							}
							if(bp_is_active('activity'))
							{
								echo "<tr><td colspan='5'><h3>Activity Module Buddypress Options</h3></td><tr>";
					?>
								<tr valign="top">
									<td><input type="checkbox" id="chk_robots_for_buddypress_activity" name="chk_robots_for_buddypress_activity" <?php if(get_option('chk_robots_for_buddypress_activity') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Buddypress Activity</td>
									<td><input type="checkbox" id="chk_noindex_for_buddypress_activity" name="chk_noindex_for_buddypress_activity" <?php if(get_option('chk_noindex_for_buddypress_activity') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
									<td><input type="checkbox" id="chk_nofollow_for_buddypress_activity" name="chk_nofollow_for_buddypress_activity" <?php if(get_option('chk_nofollow_for_buddypress_activity') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
								</tr>
					<?php			
							}
							if(bp_is_active('forums'))
							{
								echo "<tr><td colspan='5'><h3>Forums Module Buddypress Options</h3></td><tr>";
					?>
								<tr valign="top">
									<td><input type="checkbox" id="chk_robots_for_buddypress_forums" name="chk_robots_for_buddypress_forums" <?php if(get_option('chk_robots_for_buddypress_forums') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Buddypress Forums</td>
									<td><input type="checkbox" id="chk_noindex_for_buddypress_forums" name="chk_noindex_for_buddypress_forums" <?php if(get_option('chk_noindex_for_buddypress_forums') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
									<td><input type="checkbox" id="chk_nofollow_for_buddypress_forums" name="chk_nofollow_for_buddypress_forums" <?php if(get_option('chk_nofollow_for_buddypress_forums') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
								</tr>
					
					<?php
							}
							if(bp_is_active('groups'))
							{
								echo "<tr><td colspan='5'><h3>Groups Module Buddypress Options</h3></td><tr>";
					?>
								<tr valign="top">
									<td><input type="checkbox" id="chk_robots_for_buddypress_groups_main" name="chk_robots_for_buddypress_groups_main" <?php if(get_option('chk_robots_for_buddypress_groups_main') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Buddypress Groups</td>
									<td><input type="checkbox" id="chk_noindex_for_buddypress_groups_main" name="chk_noindex_for_buddypress_groups_main" <?php if(get_option('chk_noindex_for_buddypress_groups_main') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
									<td><input type="checkbox" id="chk_nofollow_for_buddypress_groups_main" name="chk_nofollow_for_buddypress_groups_main" <?php if(get_option('chk_nofollow_for_buddypress_groups_main') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
								</tr>
					<?php
							}
						}
					?>
					<tr valign="top">
						<td>
							<?php
								if($get_all_post_types != "")
								{
									$value = "chk_robots_for_pages,chk_noindex_for_pages,chk_nofollow_for_pages,chk_robots_for_post,chk_noindex_for_post,chk_nofollow_for_post,chk_overide_local_setting_for_post,chk_overide_local_setting_for_pages,chk_robots_for_buddypress_members_activity,chk_noindex_for_buddypress_members_activity,chk_nofollow_for_buddypress_members_activity,chk_robots_for_buddypress_members_mentions,chk_noindex_for_buddypress_members_mentions,chk_nofollow_for_buddypress_members_mentions,chk_robots_for_buddypress_members_favorites,chk_noindex_for_buddypress_members_favorites,chk_nofollow_for_buddypress_members_favorites,chk_robots_for_buddypress_members_friends,chk_noindex_for_buddypress_members_friends,chk_nofollow_for_buddypress_members_friends,chk_robots_for_buddypress_members_groups,chk_noindex_for_buddypress_members_groups,chk_nofollow_for_buddypress_members_groups,chk_robots_for_buddypress_members_forums_topics,chk_noindex_for_buddypress_members_forums_topics,chk_nofollow_for_buddypress_members_forums_topics,chk_robots_for_buddypress_members_forums_replied,chk_noindex_for_buddypress_members_forums_replied,chk_nofollow_for_buddypress_members_forums_replied,chk_robots_for_buddypress_profile_public,chk_noindex_for_buddypress_profile_public,chk_nofollow_for_buddypress_profile_public,chk_robots_for_buddypress_friends_friendship,chk_noindex_for_buddypress_friends_friendship,chk_nofollow_for_buddypress_friends_friendship,chk_robots_for_buddypress_groups,chk_noindex_for_buddypress_groups,chk_nofollow_for_buddypress_groups,chk_robots_for_buddypress_activity,chk_noindex_for_buddypress_activity,chk_nofollow_for_buddypress_activity,chk_robots_for_buddypress_forums,chk_noindex_for_buddypress_forums,chk_nofollow_for_buddypress_forums,chk_robots_for_buddypress_groups_main,chk_noindex_for_buddypress_groups_main,chk_nofollow_for_buddypress_groups_main," . $get_all_post_types;
							?>

									<input type="hidden" name="page_options" value="<?php echo $value;?>" />
							<?php 
								}
								else
								{
									$value = "chk_robots_for_pages,chk_noindex_for_pages,chk_nofollow_for_pages,chk_robots_for_post,chk_noindex_for_post,chk_nofollow_for_post,chk_overide_local_setting_for_post,chk_overide_local_setting_for_pages,chk_robots_for_buddypress_members_activity,chk_noindex_for_buddypress_members_activity,chk_nofollow_for_buddypress_members_activity,chk_robots_for_buddypress_members_mentions,chk_noindex_for_buddypress_members_mentions,chk_nofollow_for_buddypress_members_mentions,chk_robots_for_buddypress_members_favorites,chk_noindex_for_buddypress_members_favorites,chk_nofollow_for_buddypress_members_favorites,chk_robots_for_buddypress_members_friends,chk_noindex_for_buddypress_members_friends,chk_nofollow_for_buddypress_members_friends,chk_robots_for_buddypress_members_groups,chk_noindex_for_buddypress_members_groups,chk_nofollow_for_buddypress_members_groups,chk_robots_for_buddypress_members_forums_topics,chk_noindex_for_buddypress_members_forums_topics,chk_nofollow_for_buddypress_members_forums_topics,chk_robots_for_buddypress_members_forums_replied,chk_noindex_for_buddypress_members_forums_replied,chk_nofollow_for_buddypress_members_forums_replied,chk_robots_for_buddypress_profile_public,chk_noindex_for_buddypress_profile_public,chk_nofollow_for_buddypress_profile_public,chk_robots_for_buddypress_friends_friendship,chk_noindex_for_buddypress_friends_friendship,chk_nofollow_for_buddypress_friends_friendship,chk_robots_for_buddypress_groups,chk_noindex_for_buddypress_groups,chk_nofollow_for_buddypress_groups,chk_robots_for_buddypress_activity,chk_noindex_for_buddypress_activity,chk_nofollow_for_buddypress_activity,chk_robots_for_buddypress_forums,chk_noindex_for_buddypress_forums,chk_nofollow_for_buddypress_forums,chk_robots_for_buddypress_groups_main,chk_noindex_for_buddypress_groups_main,chk_nofollow_for_buddypress_groups_main";
							?>
									<input type="hidden" name="page_options" value="<?php echo $value;?>" />
							<?php
								}
							?>
							<input type="hidden" name="action" value="update" />
							<input type="submit" value="Save settings" class="button-primary"/>
						</td>
					</tr>					
				</table>
			</form>
<?php
	// Check that the user is allowed to update options  
		if (!current_user_can('manage_options'))
		{
			wp_die('You do not have sufficient permissions to access this page.');
		}
?>
		</div>
<?php
	}
?>
<?php	
	function onsite_meta_robots_dropdown_box($post)
	{
		global $post, $page;
		if(trim($post->post_type) == "page")
		{
			$post_id = $post->ID;
			if(get_post_meta($post_id, "onsite_robots_for_frontend", true))
			{
				// Use local settings
				$local_settings_onsite_meta_value = local_setting_set_post_meta_robot_tag($post_id, "onsite_robots_for_frontend", true);				
				$local_settings_onsite_meta_value = explode(",",$local_settings_onsite_meta_value);
				$noindex = $local_settings_onsite_meta_value[0];
				$nofollow = $local_settings_onsite_meta_value[1];
			}
			else
			{
				// Use global settings
				if(get_option('chk_noindex_for_pages') == "on")
				{
					$noindex = "noindex";
				}
				if(get_option('chk_nofollow_for_pages') == "on")
				{
					$nofollow = "nofollow";
				}
			}
		}
		else if(trim($post->post_type) == "post")
		{
			$post_id = $post->ID;
			if(get_post_meta($post_id, "onsite_robots_for_frontend", true))
			{
				// Use local settings
				$local_settings_onsite_meta_value = local_setting_set_post_meta_robot_tag($post_id, "onsite_robots_for_frontend", true);				
				$local_settings_onsite_meta_value = explode(",",$local_settings_onsite_meta_value);
				$noindex = $local_settings_onsite_meta_value[0];
				$nofollow = $local_settings_onsite_meta_value[1];
			}
			else
			{
				// Use global settings
				if(get_option('chk_noindex_for_post') == "on")
				{
					$noindex = "noindex";
				}
				if(get_option('chk_nofollow_for_post') == "on")
				{
					$nofollow = "nofollow";
				}
			}
		}
		else
		{
			$post_id = $post->ID;
			if(get_post_meta($post_id, "onsite_robots_for_frontend", true))
			{
				// Use local settings
				$local_settings_onsite_meta_value = local_setting_set_post_meta_robot_tag($post_id, "onsite_robots_for_frontend", true);				
				$local_settings_onsite_meta_value = explode(",",$local_settings_onsite_meta_value);
				$noindex = $local_settings_onsite_meta_value[0];
				$nofollow = $local_settings_onsite_meta_value[1];
			}
			else
			{
				// Use global settings
				$custom_post_type_vairable_name = 'chk_noindex_for_' . $post->post_type;
				if(get_option($custom_post_type_vairable_name) == "on")
				{
					$noindex = "noindex";
				}
				if(get_option($custom_post_type_vairable_name) == "on")
				{
					$nofollow = "nofollow";
				}
			}
		}
?>
		<fieldset id="mycustom-div">
		<div>
		<p>
			<input type="checkbox" id="chk_robots_for_noindex" name="chk_robots_for_noindex" <?php if($noindex == "noindex"){ echo "checked=checked";}?> />&nbsp;&nbsp;&nbsp;&nbsp;NOINDEX<br />
			<input type="checkbox" id="chk_robots_for_nofollow" name="chk_robots_for_nofollow" <?php if($nofollow == "nofollow"){ echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;&nbsp;NOFOLLOW
		</p>
		</div>
		</fieldset>
<?php
	}
	function meta_robots_save_post($post_id)
	{
		global $post, $page;
		$noindex = $_POST['chk_robots_for_noindex'];
		$nofollow = $_POST['chk_robots_for_nofollow'];

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
	
		/* Get the meta key. */
		$meta_key = 'onsite_robots_for_frontend';
	
		/* Get the meta value of the custom field key. */
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		
			
		/* If a new meta value was added and there was no previous value, add it. */
		if ( $new_meta_value && '' == $meta_value )
			add_post_meta( $post_id, $meta_key, $new_meta_value, true );
	
		/* If the new meta value does not match the old value, update it. */
		elseif ( $new_meta_value && $new_meta_value != $meta_value )
			update_post_meta( $post_id, $meta_key, $new_meta_value );
	
		/* If there is no new meta value but an old value exists, delete it. */
		elseif ( '' == $new_meta_value && $meta_value )
			delete_post_meta( $post_id, $meta_key, $meta_value );		
		
		
	}
	function deleteLocalRobotSetting($posttypevalues)
	{
		global $wpdb;
		$wpdb->query("UPDATE $wpdb->postmeta SET meta_value = '' where meta_key = 'onsite_robots_for_frontend' AND post_id IN (select ID from $wpdb->posts where post_type = '".$posttypevalues."' AND post_status = 'publish')");
		return true;
	}
	function my_admin_notice(){
		echo '<div class="updated">
		   <p>Local Records Deleted Successfully.</p>
		</div>';
	}
	function set_post_meta_robot_tag($post_id, $meta_id, $boolean)
	{
		$meta_value_onsite_robots_for_frontend = get_post_meta($post_id, $meta_id, $boolean);
		$meta_value_onsite_robots_for_frontend = unserialize($meta_value_onsite_robots_for_frontend);
		
		if($meta_value_onsite_robots_for_frontend['noindex'] == true)
		{
			$noindex = "noindex";
		}
		else
		{
			$noindex = "index";
		}
		if($meta_value_onsite_robots_for_frontend['nofollow'] == true)
		{
			$nofollow = "nofollow";
		}
		else
		{
			$nofollow = "follow";
		}
		$meta_value_onsite_robots_for_frontend =  $noindex . ", " . $nofollow;
		if($meta_value_onsite_robots_for_frontend != "index, follow")
		{
			echo '<!-- onsite seo plugin -->';
			echo '<meta name="robots" content="'.$meta_value_onsite_robots_for_frontend.'" />'."\n";
		}
	}
	function local_setting_set_post_meta_robot_tag($post_id, $meta_id, $boolean)
	{
		$meta_value_onsite_robots_for_frontend = get_post_meta($post_id, $meta_id, $boolean);
		$meta_value_onsite_robots_for_frontend = unserialize($meta_value_onsite_robots_for_frontend);
		if($meta_value_onsite_robots_for_frontend['noindex'] == true)
		{
			$noindex = "noindex";
		}
		else
		{
			$noindex = "index";
		}
		if($meta_value_onsite_robots_for_frontend['nofollow'] == true)
		{
			$nofollow = "nofollow";
		}
		else
		{
			$nofollow = "follow";
		}
		return $noindex . "," . $nofollow;
	}
	/* 
		Function override_local_setting_section_to_display_frontend_robot - Begins here
		Description :- 
	*/
	function override_local_setting_section_to_display_frontend_robot($option_name_for_post_type,$option_name_for_global_override_local,$option_name_noindex_for_post_type,$option_name_nofollow_for_post_type)
	{		
		if(get_option($option_name_for_post_type) == "on")
		{
			if(get_option($option_name_for_global_override_local) == "on")
			{
				if(get_option($option_name_noindex_for_post_type) == "on")
				{
					$noindex = "noindex";
				}
				else
				{
					$noindex = "index";
				}
				if(get_option($option_name_nofollow_for_post_type) == "on")
				{
					$nofollow = "nofollow";
				}
				else
				{
					$nofollow = "follow";
				}
				if(!($noindex == "index" && $nofollow == "follow"))
				{
					echo '<!-- onsite seo plugin -->';
					echo '<meta name="robots" content="'.$nofollow. ', ' . $noindex.'" />'."\n";
				}
			}
			else
			{
				if(get_post_meta($post_id, "onsite_robots_for_frontend", true))
				{
					set_post_meta_robot_tag($post_id, "onsite_robots_for_frontend", true);
				}
			}
		}		
	}
	/* 
		Function override_local_setting_section_to_display_frontend_robot - Ends here
	*/	
	/* 
		Function display_frontend_robots_tag - Begins here
		Description :- 
	*/
	function display_frontend_robots_tag($option_name,$option_name_noindex,$option_name_nofollow)
	{
		if(get_option($option_name) == "on")
		{
			if(get_option($option_name_noindex) == "on")
			{
				$noindex = "noindex";
			}
			else
			{
				$noindex = "index";
			}
			if(get_option($option_name_nofollow) == "on")
			{
				$nofollow = "nofollow";
			}
			else
			{
				$nofollow = "follow";
			}
			if(!($noindex == "index" && $nofollow == "follow"))
			{
				echo '<!-- onsite seo plugin -->';
				echo '<meta name="robots" content="'.$nofollow. ', ' . $noindex.'" />'."\n";
			}
		}
	}
	/* 
		Function display_frontend_robots_tag - Ends here
	*/		
?>
<?php
add_action("admin_menu", "setup_onsite_seo_admin_menus");
add_action("edit_post", "meta_robots_save_post");
add_action("wp_head", "add_meta_robots_tag_for_custom_post");
if(isset($_GET['posttype']) &&  $_GET['posttype'] != "" && $_GET['action'] == "delete")
{
	if(deleteLocalRobotSetting($_GET['posttype']))
	{
		add_action('admin_notices', 'my_admin_notice');
	}
}
?>