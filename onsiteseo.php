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
			if(get_option('chk_robots_for_pages') == "on")
			{
				if(get_option('chk_overide_local_setting_for_pages') == "on")
				{
					if(get_option('chk_noindex_for_pages') == "on")
					{
						$noindex = "noindex";
					}
					else
					{
						$noindex = "index";
					}
					if(get_option('chk_nofollow_for_pages') == "on")
					{
						$nofollow = "nofollow";
					}
					else
					{
						$nofollow = "follow";
					}
					if(!($noindex == "index" && $nofollow == "follow"))
					{
						echo '<meta name="robots" content="'.$nofollow. ', ' . $noindex.'" />'."\n";
					}
				}
				else
				{
					if(get_post_meta($post_id, "onsite_robots_for_frontend", true))
					{					
						$meta_value_onsite_robots_for_frontend = get_post_meta($post_id, "onsite_robots_for_frontend", true);
						if($meta_value_onsite_robots_for_frontend != "index, follow")
						{
							echo '<meta name="robots" content="'.$meta_value_onsite_robots_for_frontend.'" />'."\n";
						}
					}
				}
			}
		}
		else if(trim($post->post_type) == "post")
		{
			if(get_option('chk_robots_for_post') == "on")
			{
				if(get_option('chk_overide_local_setting_for_post') == "on")
				{
					if(get_option('chk_noindex_for_post') == "on")
					{
						$noindex = "noindex";
					}
					else
					{
						$noindex = "index";
					}
					if(get_option('chk_nofollow_for_post') == "on")
					{
						$nofollow = "nofollow";
					}
					else
					{
						$nofollow = "follow";
					}
					if(!($noindex == "index" && $nofollow == "follow"))
					{
						echo '<meta name="robots" content="'.$nofollow. ', ' . $noindex.'" />'."\n";
					}
				}
				else
				{
					if(get_post_meta($post_id, "onsite_robots_for_frontend", true))
					{
						$meta_value_onsite_robots_for_frontend = get_post_meta($post_id, "onsite_robots_for_frontend", true);
						if($meta_value_onsite_robots_for_frontend != "index, follow")
						{
							echo '<meta name="robots" content="'.$meta_value_onsite_robots_for_frontend.'" />'."\n";
						}
					}
				}
			}	
		}
		else
		{
			$args=array('public'   => true,'_builtin' => false);
			$output = 'names'; // names or objects, note names is the default
			$operator = 'and'; // 'and' or 'or'
			$post_types=get_post_types($args,$output,$operator);
			$chk_overide_local_setting_for_custom_post_type = 'chk_overide_local_setting_for_' . $post->post_type;
			$chk_robots_for_custom_post_type = "chk_robots_for_" . $post->post_type;
				if(get_option($chk_robots_for_custom_post_type) == "on")
				{
					if(get_option($chk_overide_local_setting_for_custom_post_type) == "on")
					{
						$noindex_post_type = 'chk_noindex_for_' . $post->post_type;
						$nofollow_post_type = 'chk_nofollow_for_' . $post->post_type;
						if(get_option($noindex_post_type) == "on")
						{
							$noindex = "noindex";
						}
						else
						{
							$noindex = "index";
						}
						if(get_option($nofollow_post_type) == "on")
						{
							$nofollow = "nofollow";
						}
						else
						{
							$nofollow = "follow";
						}
						if(!($noindex == "index" && $nofollow == "follow"))
						{
							echo '<meta name="robots" content="'.$nofollow. ', ' . $noindex.'" />'."\n";
						}
					}
					else
					{
						if(get_post_meta($post_id, "onsite_robots_for_frontend", true))
						{
							$meta_value_onsite_robots_for_frontend = get_post_meta($post_id, "onsite_robots_for_frontend", true);
							if($meta_value_onsite_robots_for_frontend != "index, follow")
							{
								echo '<meta name="robots" content="'.$meta_value_onsite_robots_for_frontend.'" />'."\n";
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
									$value = "chk_robots_for_pages,chk_noindex_for_pages,chk_nofollow_for_pages,chk_robots_for_post,chk_noindex_for_post,chk_nofollow_for_post,chk_overide_local_setting_for_post,chk_overide_local_setting_for_pages," . $get_all_post_types;
							?>

									<input type="hidden" name="page_options" value="<?php echo $value;?>" />
							<?php 
								}
								else
								{
									$value = "chk_robots_for_pages,chk_noindex_for_pages,chk_nofollow_for_pages,chk_robots_for_post,chk_noindex_for_post,chk_nofollow_for_post,chk_overide_local_setting_for_post,chk_overide_local_setting_for_pages";
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
				$meta_value_onsite_robots_for_frontend = get_post_meta($post_id, "onsite_robots_for_frontend", true);
				$selected_robot_values = explode(",",$meta_value_onsite_robots_for_frontend);
				$noindex = trim($selected_robot_values[0]);
				$nofollow = trim($selected_robot_values[1]);
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
				$meta_value_onsite_robots_for_frontend = get_post_meta($post_id, "onsite_robots_for_frontend", true);
				$selected_robot_values = explode(",",$meta_value_onsite_robots_for_frontend);
				$noindex = trim($selected_robot_values[0]);
				$nofollow = trim($selected_robot_values[1]);			
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
				$meta_value_onsite_robots_for_frontend = get_post_meta($post_id, "onsite_robots_for_frontend", true);
				$selected_robot_values = explode(",",$meta_value_onsite_robots_for_frontend);
				$noindex = trim($selected_robot_values[0]);
				$nofollow = trim($selected_robot_values[1]);
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
			$value = "noindex" . ", " . "nofollow";
		}
		else if((!isset($noindex) && empty($noindex)) && (isset($nofollow) && !empty($nofollow)))
		{
			$value = "index" . ", " . "nofollow";
		}
		else if((isset($noindex) && !empty($noindex)) && (!isset($nofollow) && empty($nofollow)))
		{
			$value = "noindex" . ", " . "follow";
		}
		else
		{
			$value = "index" . ", " . "follow";
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
