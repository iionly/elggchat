<?php

$current_user = elgg_get_logged_in_user_entity();

$user_guid = (int) get_input('guid', 0);
$user = get_user($user_guid);
$plugin = elgg_get_plugin_from_id('elggchat');
$plugin_name = $plugin->getDisplayName();

if (!$user || ($user->guid != $current_user->guid) && !$current_user->isAdmin()) {
	return elgg_error_response(elgg_echo('elggchat:usersettings:save:error', [$plugin_name]), REFERER);
}

$params = get_input('params');

$result = false;

foreach ($params as $name => $value) {
	$result = $user->setPluginSetting($plugin->getID(), $name, $value);
	if (!$result) {
		return elgg_error_response(elgg_echo('elggchat:usersettings:save:error', [$plugin_name]), REFERER);
	}
}

return elgg_ok_response('', elgg_echo('elggchat:usersettings:save:success', [$plugin_name]), REFERER);
