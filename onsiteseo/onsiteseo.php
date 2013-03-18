<?php
/*
Plugin Name: Onsite SEO
Plugin URI: http://www.ask-oracle.com/
Description: Admin Control for managining onpage seo items
Author: Tapan Sodagar
Version: 1.0
Author URI: http://www.ask-oracle.com/
*/
	function setup_onsite_seo_admin_menus()
	{
		add_submenu_page('options-general.php', 'Onsite SEO Options', 'Onsite SEO', 'manage_options', 'onsite-seo','theme_onsiteseo_settings_page');
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
						<td><input type="checkbox" id="chk_robots_for_pages" name="chk_robots_for_pages"/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Pages</td>
						<td><input type="checkbox" id="chk_noindex_for_pages" name="chk_noindex_for_pages"/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
						<td><input type="checkbox" id="chk_nofollow_for_pages" name="chk_nofollow_for_pages"/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
					</tr>					
					<tr valign="top">
						<td><input type="checkbox" id="chk_robots_for_post" name="chk_robots_for_post"/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for Posts</td>
						<td><input type="checkbox" id="chk_noindex_for_post" name="chk_noindex_for_post"/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
						<td><input type="checkbox" id="chk_nofollow_for_post" name="chk_nofollow_for_post"/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
					</tr>
					<?php 
						$args=array(
						  'public'   => true,
						  '_builtin' => false
						); 
						$output = 'names'; // names or objects, note names is the default
						$operator = 'and'; // 'and' or 'or'
						$post_types=get_post_types($args,$output,$operator);
						foreach ($post_types  as $post_type)
						{
					?>
							<tr valign="top">
								<td><input type="checkbox" id="chk_robots_for_<?php echo $post_type;?>" name="chk_robots_for_<?php echo $post_type;?>"/>&nbsp;&nbsp;&nbsp;Set These Meta Robots tag for <?php echo $post_type;?></td>
								<td><input type="checkbox" id="chk_noindex_for_<?php echo $post_type;?>" name="chk_noindex_for_<?php echo $post_type;?>"/>&nbsp;&nbsp;&nbsp;NOINDEX</td>
								<td><input type="checkbox" id="chk_nofollow_for_<?php echo $post_type;?>" name="chk_nofollow_for_<?php echo $post_type;?>"/>&nbsp;&nbsp;&nbsp;NOFOLLOW</td>
							</tr>
					
					<?php
						}
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
							<input type="hidden" name="page_options" value="set_robots_for_page,set_robots_for_post,set_robots_for_custom_post" />
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
add_action("admin_menu", "setup_onsite_seo_admin_menus");
?>