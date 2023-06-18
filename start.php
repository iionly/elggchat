<?php
/**
 * ElggChat - Pure Elgg-based chat/IM
 *
 * Main initialization file
 *
 * @package elggchat
 * @author ColdTrick IT Solutions
 * @copyright Coldtrick IT Solutions 2009
 * @link http://www.coldtrick.com/
 *
 * for Elgg 1.8 and newer by iionly (iionly@gmx.de)
 * @copyright iionly 2014
 * @link https://github.com/iionly
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 */

define("ELGGCHAT_MEMBER", "elggchat_member");
define("ELGGCHAT_SESSION_SUBTYPE", "elggchat_session");
define("ELGGCHAT_SYSTEM_MESSAGE", "elggchat_system_message");
define("ELGGCHAT_MESSAGE", "elggchat_message");

require_once(dirname(__FILE__) . '/lib/events.php');
require_once(dirname(__FILE__) . '/lib/hooks.php');

elgg_register_event_handler('init', 'system', 'elggchat_init');

function elggchat_init() {

	// CSS
	elgg_extend_view('css/admin', 'elggchat/admin_css');
	elgg_extend_view('css/elgg','elggchat/css');

	// chat
	elgg_extend_view('page/elements/footer', 'elggchat/session_monitor');

	elgg_register_admin_menu_item('administer', 'elggchat', 'administer_utilities');

	elgg_register_plugin_hook_handler('register', 'menu:page', 'elggchat_usersettings_page');

	// Extend avatar hover menu
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'elggchat_user_hover_menu');

	// Register cron job
	elgg_register_plugin_hook_handler('cron', 'hourly', 'elggchat_session_cleanup');

	// Logout event handler
	elgg_register_event_handler('logout:before', 'user', 'elggchat_logout_handler');

	// Actions
	$action_path = elgg_get_plugins_path() . 'elggchat/actions';
	elgg_register_action("elggchat/create", "$action_path/create.php", "logged_in");
	elgg_register_action("elggchat/post_message", "$action_path/post_message.php", "logged_in");
	elgg_register_action("elggchat/poll", "$action_path/poll.php", "logged_in");
	elgg_register_action("elggchat/invite", "$action_path/invite.php", "logged_in");
	elgg_register_action("elggchat/leave", "$action_path/leave.php", "logged_in");
	elgg_register_action("elggchat/get_smiley", "$action_path/get_smiley.php", "logged_in");
	elgg_register_action("elggchat/admin_message", "$action_path/admin_message.php", "admin");
	elgg_register_action("elggchat/delete_session", "$action_path/delete_session.php", "admin");
	elgg_register_action("elggchat_usersettings/save", "$action_path/save.php", "logged_in");

	elgg_register_page_handler('elggchat', 'elggchat_page_handler');
}

function elggchat_page_handler($page) {

	$current_user = elgg_get_logged_in_user_entity();
	if (!isset($page[0])) {
		$page[0] = 'usersettings';
	}
	if (!isset($page[1])) {
		forward("elggchat/{$page[0]}/{$current_user->username}");
	}

	$vars['username'] = $page[1];

	switch ($page[0]) {
		case 'usersettings':
			echo elgg_view_resource('elggchat/usersettings', $vars);
			break;
		default:
			return false;
	}
	return true;
}
