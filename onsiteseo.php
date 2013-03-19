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
		$default_post_types = array('post','page','attachment','revision','nav_menu_item');
		$current_post_type = strtolower($post->post_type);
		if($current_post_type != "")
		{
			if(!in_array($current_post_type,$default_post_types))
			{
				if($post->onsite_meta_robots != "" || !empty($post->onsite_meta_robots))
				{
					echo '<meta name="robots" content="'.$post->onsite_meta_robots.'" />'."\n";
				}
				else
				{
					$custom_post_type_meta = "chk_robots_for_" . $current_post_type;
					if(get_option($custom_post_type_meta) == "on")
					{
						$noindex = "chk_noindex_for_" . $current_post_type;
						$nofollow = "chk_nofollow_for_" . $current_post_type;
						if(get_option($noindex) == "on" && get_option($nofollow) == "on")
						{
							echo '<meta name="robots" content="noindex, nofollow" />'."\n";
						}
						else if(get_option($noindex) == "on" && get_option($nofollow) != "on")
						{
							echo '<meta name="robots" content="noindex, follow" />'."\n";
						}
						else if(get_option($noindex) != "on" && get_option($nofollow) == "on")
						{
							echo '<meta name="robots" content="index, nofollow" />'."\n";
						}
						else
						{
							echo '<meta name="robots" content="index, follow" />'."\n";
						}
					}
				}	
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
	}
	function theme_onsiteseo_settings_page()
	{
		global $bp;
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
					</tr>					
					<tr valign="top">
						<td><input type="checkbox" id="chk_robots_for_post" name="chk_robots_for_post" <?php if(get_option('chk_robots_for_post') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Posts</td>
						<td><input type="checkbox" id="chk_noindex_for_post" name="chk_noindex_for_post" <?php if(get_option('chk_noindex_for_post') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
						<td><input type="checkbox" id="chk_nofollow_for_post" name="chk_nofollow_for_post" <?php if(get_option('chk_nofollow_for_post') == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
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
							$get_all_post_types[] = "chk_robots_for_" . $post_type . ",chk_noindex_for_" . $post_type . ",chk_nofollow_for_" . $post_type;
					?>
							<tr valign="top">
								<td><input type="checkbox" id="chk_robots_for_<?php echo $post_type;?>" name="chk_robots_for_<?php echo $post_type;?>" <?php $custom_post_type_name = 'chk_robots_for_' . $post_type;if(get_option($custom_post_type_name) == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for <?php echo $post_type;?></td>
								<td><input type="checkbox" id="chk_noindex_for_<?php echo $post_type;?>" name="chk_noindex_for_<?php echo $post_type;?>" <?php $custom_post_type_name = 'chk_noindex_for_' . $post_type;if(get_option($custom_post_type_name) == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
								<td><input type="checkbox" id="chk_nofollow_for_<?php echo $post_type;?>" name="chk_nofollow_for_<?php echo $post_type;?>" <?php $custom_post_type_name = 'chk_nofollow_for_' . $post_type;if(get_option($custom_post_type_name) == "on"){echo "checked=checked";}?>/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
							</tr>
					
					<?php
						}
						$get_all_post_types = implode(", ",$get_all_post_types);
					?>
					<?php
						if(defined('BP_VERSION'))
						{
							if(bp_is_active('groups'))
							{
					?>
								<tr valign="top">
									<td><input type="checkbox" id="chk_robots_for_groups" name="chk_robots_for_groups"/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Buddypress Group Members</td>
									<td><input type="checkbox" id="chk_noindex_for_groups" name="chk_noindex_for_groups"/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
									<td><input type="checkbox" id="chk_nofollow_for_groups" name="chk_nofollow_for_groups"/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
								</tr>
					<?php
							}
							if(bp_is_active('forums'))
							{							
					?>		
								<tr valign="top">
									<td><input type="checkbox" id="chk_robots_for_forums" name="chk_robots_for_forums"/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Buddypress Press Group Forums</td>
									<td><input type="checkbox" id="chk_noindex_for_forums" name="chk_noindex_for_forums"/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
									<td><input type="checkbox" id="chk_nofollow_for_forums" name="chk_nofollow_for_forums"/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
								</tr>
					<?php
							}
							if(bp_is_active('activity'))
							{
					?>			
								<tr valign="top">
									<td><input type="checkbox" id="chk_robots_for_activity" name="chk_robots_for_activity"/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Buddypress Group Activity</td>
									<td><input type="checkbox" id="chk_noindex_for_activity" name="chk_noindex_for_activity"/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
									<td><input type="checkbox" id="chk_nofollow_for_activity" name="chk_nofollow_for_activity"/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
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
									$value = "chk_robots_for_pages,chk_noindex_for_pages,chk_nofollow_for_pages,chk_robots_for_post,chk_noindex_for_post,chk_nofollow_for_post," . $get_all_post_types;
							?>

									<input type="hidden" name="page_options" value="<?php echo $value;?>" />
							<?php 
								}
								else
								{
									$value = "chk_robots_for_pages,chk_noindex_for_pages,chk_nofollow_for_pages,chk_robots_for_post,chk_noindex_for_post,chk_nofollow_for_post";																
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
	function onsite_meta_robots_addcolumn()
	{
		global $wpdb;
		if (false === $wpdb->query("SELECT onsite_meta_robots FROM $wpdb->posts LIMIT 0")) {
			$wpdb->query("ALTER TABLE $wpdb->posts ADD COLUMN onsite_meta_robots varchar(20)");
		}
	}
?>
<?php	
	function onsite_meta_robots_dropdown_box()
	{
		global $post;
		$onsite_meta_robots = $post->onsite_meta_robots;
?>
		<fieldset id="mycustom-div">
		<div>
		<p>
		<label for="onsite_meta_robots" ></label>
			<select name="onsite_meta_robots" id="onsite_meta_robots">
				<option value="">--select--</option>
				<option <?php if ($onsite_meta_robots == "index, follow") echo 'selected="selected"'?>>index, follow</option>
				<option <?php if ($onsite_meta_robots == "index, nofollow") echo 'selected="selected"'?>>index, nofollow</option>
				<option <?php if ($onsite_meta_robots == "noindex, follow") echo 'selected="selected"'?>>noindex, follow</option>
				<option <?php if ($onsite_meta_robots == "noindex, nofollow") echo 'selected="selected"'?>>noindex, nofollow</option>
			</select>
		</p>
		</div>
		</fieldset>
<?php	
	}
	function meta_robots_insert_post($pID)
	{
		global $wpdb;
		extract($_POST);
		$wpdb->query("UPDATE $wpdb->posts SET onsite_meta_robots = '$onsite_meta_robots' WHERE ID = $pID");
	}	
?>
<?php	
add_action('init', "onsite_meta_robots_addcolumn");
add_action("admin_menu", "setup_onsite_seo_admin_menus");
add_action('wp_insert_post', 'meta_robots_insert_post');
add_action('wp_head', "add_meta_robots_tag_for_custom_post");
?>