<style type="text/css">
	input[type="text"].seoplustext
	{
		width:500px;
	}
</style>
<div class="wrap">
			<?php screen_icon('themes'); ?><h2>SEO PLUS Settings</h2>
			<form method="post" action="options.php">
				<?php wp_nonce_field('update-options') ?>
				<table class="form-table">
					<tr valign="top">
						<td><input type="checkbox" id="chk_robots_for_page" name="chk_robots_for_page" <?php if(get_option('chk_robots_for_page') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Pages</td>
						<td><input type="checkbox" id="chk_noindex_for_page" name="chk_noindex_for_page" <?php if(get_option('chk_noindex_for_page') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
						<td><input type="checkbox" id="chk_nofollow_for_page" name="chk_nofollow_for_page" <?php if(get_option('chk_nofollow_for_page') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
						<td><input type="checkbox" id="chk_overide_local_setting_for_page" name="chk_overide_local_setting_for_page" <?php if(get_option('chk_overide_local_setting_for_page') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Global Override Local Setting</td>
						<?php $params = array('posttype'=> 'page', 'action' => 'delete' );?>
						<td><a href="<?php echo add_query_arg($params,admin_url('options-general.php?page=seoplus') );?>" class="button">Delete all local data</a></td>
					</tr>					
					<tr valign="top">
						<td><input type="checkbox" id="chk_robots_for_post" name="chk_robots_for_post" <?php if(get_option('chk_robots_for_post') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Posts</td>
						<td><input type="checkbox" id="chk_noindex_for_post" name="chk_noindex_for_post" <?php if(get_option('chk_noindex_for_post') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
						<td><input type="checkbox" id="chk_nofollow_for_post" name="chk_nofollow_for_post" <?php if(get_option('chk_nofollow_for_post') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
						<td><input type="checkbox" id="chk_overide_local_setting_for_post" name="chk_overide_local_setting_for_post" <?php if(get_option('chk_overide_local_setting_for_post') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Global Override Local Setting</td>
						<?php $params = array('posttype'=> 'post', 'action' => 'delete' );?>
						<td><a href="<?php echo add_query_arg($params,admin_url('options-general.php?page=seoplus') );?>" class="button">Delete all local data</a></td>
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
								<td><a href="<?php echo add_query_arg($params,admin_url('options-general.php?page=seoplus') );?>" class="button">Delete all local data</a></td>
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
										<td><input type="checkbox" id="chk_robots_for_members_activity" name="chk_robots_for_members_activity" <?php if(get_option('chk_robots_for_members_activity') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Members Activity</td>
										<td><input type="checkbox" id="chk_noindex_for_members_activity" name="chk_noindex_for_members_activity" <?php if(get_option('chk_noindex_for_members_activity') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
										<td><input type="checkbox" id="chk_nofollow_for_members_activity" name="chk_nofollow_for_members_activity" <?php if(get_option('chk_nofollow_for_members_activity') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
									</tr>
									<tr valign="top">
										<td><input type="checkbox" id="chk_robots_for_members_mentions" name="chk_robots_for_members_mentions" <?php if(get_option('chk_robots_for_members_mentions') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Members Activity -> Mentions</td>
										<td><input type="checkbox" id="chk_noindex_for_members_mentions" name="chk_noindex_for_members_mentions" <?php if(get_option('chk_noindex_for_members_mentions') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
										<td><input type="checkbox" id="chk_nofollow_for_members_mentions" name="chk_nofollow_for_members_mentions" <?php if(get_option('chk_nofollow_for_members_mentions') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
									</tr>
									<tr valign="top">
										<td><input type="checkbox" id="chk_robots_for_members_favorites" name="chk_robots_for_members_favorites" <?php if(get_option('chk_robots_for_members_favorites') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Members Activity -> Favorites</td>
										<td><input type="checkbox" id="chk_noindex_for_members_favorites" name="chk_noindex_for_members_favorites" <?php if(get_option('chk_noindex_for_members_favorites') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
										<td><input type="checkbox" id="chk_nofollow_for_members_favorites" name="chk_nofollow_for_members_favorites" <?php if(get_option('chk_nofollow_for_members_favorites') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
									</tr>
									<?php
										if(bp_is_active('friends'))
										{
									?>
									<tr valign="top">
										<td><input type="checkbox" id="chk_robots_for_members_friends" name="chk_robots_for_members_friends" <?php if(get_option('chk_robots_for_members_friends') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Members Activity -> Friends</td>
										<td><input type="checkbox" id="chk_noindex_for_members_friends" name="chk_noindex_for_members_friends" <?php if(get_option('chk_noindex_for_members_friends') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
										<td><input type="checkbox" id="chk_nofollow_for_members_friends" name="chk_nofollow_for_members_friends" <?php if(get_option('chk_nofollow_for_members_friends') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
									</tr>
									<?php
										}
									?>
									<?php
										if(bp_is_active('groups'))
										{
									?>
										<tr valign="top">
											<td><input type="checkbox" id="chk_robots_for_members_groups" name="chk_robots_for_members_groups" <?php if(get_option('chk_robots_for_members_groups') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Members Activity -> Groups</td>
											<td><input type="checkbox" id="chk_noindex_for_members_groups" name="chk_noindex_for_members_groups" <?php if(get_option('chk_noindex_for_members_groups') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
											<td><input type="checkbox" id="chk_nofollow_for_members_groups" name="chk_nofollow_for_members_groups" <?php if(get_option('chk_nofollow_for_members_groups') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
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
										<td><input type="checkbox" id="chk_robots_for_topics" name="chk_robots_for_topics" <?php if(get_option('chk_robots_for_topics') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Members Forums -> Topics Started</td>
										<td><input type="checkbox" id="chk_noindex_for_topics" name="chk_noindex_for_topics" <?php if(get_option('chk_noindex_for_topics') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
										<td><input type="checkbox" id="chk_nofollow_for_topics" name="chk_nofollow_for_topics" <?php if(get_option('chk_nofollow_for_topics') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
									</tr>
									<tr valign="top">
										<td><input type="checkbox" id="chk_robots_for_replied" name="chk_robots_for_replied" <?php if(get_option('chk_robots_for_replied') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Members Forums -> Replied To</td>
										<td><input type="checkbox" id="chk_noindex_for_replied" name="chk_noindex_for_replied" <?php if(get_option('chk_noindex_for_replied') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
										<td><input type="checkbox" id="chk_nofollow_for_replied" name="chk_nofollow_for_replied" <?php if(get_option('chk_nofollow_for_replied') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
									</tr>
									<?php
										}
									?>																		
									<tr valign="top">
										<td><input type="checkbox" id="chk_robots_for_public" name="chk_robots_for_public" <?php if(get_option('chk_robots_for_public') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Members Profile -> Public</td>
										<td><input type="checkbox" id="chk_noindex_for_public" name="chk_noindex_for_public" <?php if(get_option('chk_noindex_for_public') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
										<td><input type="checkbox" id="chk_nofollow_for_public" name="chk_nofollow_for_public" <?php if(get_option('chk_nofollow_for_public') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
									</tr>
									<?php
										if(bp_is_active('friends'))
										{
									?>
									<tr valign="top">
										<td><input type="checkbox" id="chk_robots_for_friends" name="chk_robots_for_friends" <?php if(get_option('chk_robots_for_friends') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Members Friends -> Friendship</td>
										<td><input type="checkbox" id="chk_noindex_for_friends" name="chk_noindex_for_friends" <?php if(get_option('chk_noindex_for_friends') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
										<td><input type="checkbox" id="chk_nofollow_for_friends" name="chk_nofollow_for_friends" <?php if(get_option('chk_nofollow_for_friends') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
									</tr>
									<?php
										}
									?>
									<?php
										if(bp_is_active('groups'))
										{
									?>
									<tr valign="top">
										<td><input type="checkbox" id="chk_robots_for_groups" name="chk_robots_for_groups" <?php if(get_option('chk_robots_for_groups') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Members Groups</td>
										<td><input type="checkbox" id="chk_noindex_for_groups" name="chk_noindex_for_groups" <?php if(get_option('chk_noindex_for_groups') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
										<td><input type="checkbox" id="chk_nofollow_for_groups" name="chk_nofollow_for_groups" <?php if(get_option('chk_nofollow_for_groups') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
									</tr>
									<?php
										}
									?>
									<tr valign="top">
										<td>Member Component Page Option</td>
										<td colspan="3"><input type="text" id="txt_member_component" name="txt_member_component" class="seoplustext" value="<?php echo get_option('txt_member_component');?>"/>
										</td>
									</tr>
									<tr valign="top">
										<td>Member Component / Action Page Option</td>
										<td colspan="3"><input type="text" id="txt_member_component_action" name="txt_member_component_action" class="seoplustext" value="<?php echo get_option('txt_member_component_action');?>"/>
										</td>
									</tr>
									<tr valign="top">
										<td>Member Component / Action / Paging Option</td>
										<td colspan="3"><input type="text" id="txt_member_component_paging" name="txt_member_component_paging" class="seoplustext" value="<?php echo get_option('txt_member_component_paging');?>"/>
										</td>
									</tr>
					<?php
							}
							if(bp_is_active('activity'))
							{
								echo "<tr><td colspan='5'><h3>Activity Module Buddypress Options</h3></td><tr>";
					?>
								<tr valign="top">
									<td><input type="checkbox" id="chk_robots_for_activity" name="chk_robots_for_activity" <?php if(get_option('chk_robots_for_activity') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Buddypress Activity</td>
									<td><input type="checkbox" id="chk_noindex_for_activity" name="chk_noindex_for_activity" <?php if(get_option('chk_noindex_for_activity') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
									<td><input type="checkbox" id="chk_nofollow_for_activity" name="chk_nofollow_for_activity" <?php if(get_option('chk_nofollow_for_activity') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
								</tr>
								<tr valign="top">
									<td>Activity Component Page Option</td>
									<td colspan="3"><input type="text" id="txt_activity_component" name="txt_activity_component" class="seoplustext" value="<?php echo get_option('txt_activity_component');?>"/>
									</td>
								</tr>
								<tr valign="top">
									<td>Activity Component / Action Page Option</td>
									<td colspan="3"><input type="text" id="txt_activity_component_action" name="txt_activity_component_action" class="seoplustext" value="<?php echo get_option('txt_activity_component_action');?>"/>
									</td>
								</tr>								
					<?php			
							}
							if(bp_is_active('forums'))
							{
								echo "<tr><td colspan='5'><h3>Forums Module Buddypress Options</h3></td><tr>";
					?>
								<tr valign="top">
									<td><input type="checkbox" id="chk_robots_for_forums" name="chk_robots_for_forums" <?php if(get_option('chk_robots_for_forums') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Buddypress Forums</td>
									<td><input type="checkbox" id="chk_noindex_for_forums" name="chk_noindex_for_forums" <?php if(get_option('chk_noindex_for_forums') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
									<td><input type="checkbox" id="chk_nofollow_for_forums" name="chk_nofollow_for_forums" <?php if(get_option('chk_nofollow_for_forums') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
								</tr>
					
					<?php
							}
							if(bp_is_active('groups'))
							{
								echo "<tr><td colspan='5'><h3>Groups Module Buddypress Options</h3></td><tr>";
					?>
								<tr valign="top">
									<td><input type="checkbox" id="chk_robots_for_groups_main" name="chk_robots_for_groups_main" <?php if(get_option('chk_robots_for_groups_main') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Buddypress Groups</td>
									<td><input type="checkbox" id="chk_noindex_for_groups_main" name="chk_noindex_for_groups_main" <?php if(get_option('chk_noindex_for_groups_main') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
									<td><input type="checkbox" id="chk_nofollow_for_groups_main" name="chk_nofollow_for_groups_main" <?php if(get_option('chk_nofollow_for_groups_main') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
								</tr>
								<tr valign="top">
									<td>Groups Component Page Option</td>
									<td colspan="3"><input type="text" id="txt_groups_component" name="txt_groups_component" class="seoplustext" value="<?php echo get_option('txt_groups_component');?>"/>
									</td>
								</tr>
								<tr valign="top">
									<td>Groups Component / Action Page Option</td>
									<td colspan="3"><input type="text" id="txt_groups_component_action" name="txt_groups_component_action" class="seoplustext" value="<?php echo get_option('txt_groups_component_action');?>"/>
									</td>
								</tr>
								<tr valign="top">
									<td>Groups Component / Action / Paging Option</td>
									<td colspan="3"><input type="text" id="txt_groups_component_paging" name="txt_groups_component_paging" class="seoplustext" value="<?php echo get_option('txt_groups_component_paging');?>"/>
									</td>
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
									$value = "chk_robots_for_page,chk_noindex_for_page,chk_nofollow_for_page,chk_robots_for_post,chk_noindex_for_post,chk_nofollow_for_post,chk_overide_local_setting_for_post,chk_overide_local_setting_for_page,chk_robots_for_members_activity,chk_noindex_for_members_activity,chk_nofollow_for_members_activity,chk_robots_for_members_mentions,chk_noindex_for_members_mentions,chk_nofollow_for_members_mentions,chk_robots_for_members_favorites,chk_noindex_for_members_favorites,chk_nofollow_for_members_favorites,chk_robots_for_members_friends,chk_noindex_for_members_friends,chk_nofollow_for_members_friends,chk_robots_for_members_groups,chk_noindex_for_members_groups,chk_nofollow_for_members_groups,chk_robots_for_topics,chk_noindex_for_topics,chk_nofollow_for_topics,chk_robots_for_replied,chk_noindex_for_replied,chk_nofollow_for_replied,chk_robots_for_public,chk_noindex_for_public,chk_nofollow_for_public,chk_robots_for_friends,chk_noindex_for_friends,chk_nofollow_for_friends,chk_robots_for_groups,chk_noindex_for_groups,chk_nofollow_for_groups,chk_robots_for_activity,chk_noindex_for_activity,chk_nofollow_for_activity,chk_robots_for_forums,chk_noindex_for_forums,chk_nofollow_for_forums,chk_robots_for_groups_main,chk_noindex_for_groups_main,chk_nofollow_for_groups_main,txt_member_component,txt_member_component_action,txt_member_component_paging,txt_groups_component,txt_groups_component_action,txt_groups_component_paging,txt_activity_component,txt_activity_component_action," . $get_all_post_types;
							?>

									<input type="hidden" name="page_options" value="<?php echo $value;?>" />
							<?php 
								}
								else
								{
									$value = "chk_robots_for_page,chk_noindex_for_page,chk_nofollow_for_page,chk_robots_for_post,chk_noindex_for_post,chk_nofollow_for_post,chk_overide_local_setting_for_post,chk_overide_local_setting_for_page,chk_robots_for_members_activity,chk_noindex_for_members_activity,chk_nofollow_for_members_activity,chk_robots_for_members_mentions,chk_noindex_for_members_mentions,chk_nofollow_for_members_mentions,chk_robots_for_members_favorites,chk_noindex_for_members_favorites,chk_nofollow_for_members_favorites,chk_robots_for_members_friends,chk_noindex_for_members_friends,chk_nofollow_for_members_friends,chk_robots_for_members_groups,chk_noindex_for_members_groups,chk_nofollow_for_members_groups,chk_robots_for_topics,chk_noindex_for_topics,chk_nofollow_for_topics,chk_robots_for_replied,chk_noindex_for_replied,chk_nofollow_for_replied,chk_robots_for_public,chk_noindex_for_public,chk_nofollow_for_public,chk_robots_for_friends,chk_noindex_for_friends,chk_nofollow_for_friends,chk_robots_for_groups,chk_noindex_for_groups,chk_nofollow_for_groups,chk_robots_for_activity,chk_noindex_for_activity,chk_nofollow_for_activity,chk_robots_for_forums,chk_noindex_for_forums,chk_nofollow_for_forums,chk_robots_for_groups_main,chk_noindex_for_groups_main,chk_nofollow_for_groups_main,txt_member_component,txt_member_component_action,txt_member_component_paging,txt_groups_component,txt_groups_component_action,txt_groups_component_paging,txt_activity_component,txt_activity_component_action";
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