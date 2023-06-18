<?php

use Elgg\DefaultPluginBootstrap;

class ElggchatBootstrap extends DefaultPluginBootstrap {

	public function init() {

		// CSS
		elgg_extend_view('css/admin', 'elggchat/admin_css');
		elgg_extend_view('css/elgg','elggchat/css');

		// chat
		elgg_extend_view('page/elements/footer', 'elggchat/session_monitor');

		elgg_register_plugin_hook_handler('register', 'menu:page', 'elggchat_administer_utilities_page');
		elgg_register_plugin_hook_handler('register', 'menu:page', 'elggchat_usersettings_page');

		// Extend avatar hover menu
		elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'elggchat_user_hover_menu');

		// Register cron job
		elgg_register_plugin_hook_handler('cron', 'hourly', 'elggchat_session_cleanup');

		// Logout event handler
		elgg_register_event_handler('logout:before', 'user', 'elggchat_logout_handler');
	}
}
