<?php

$current_user = elgg_get_logged_in_user_entity();

$guid = (int) get_input('guid', 0);
if (!$guid || !($user = get_entity($guid))) {
	forward();
}
if (($user->guid != $current_user->guid) && !$current_user->isAdmin()) {
	forward();
}

$params = get_input('params');

$plugin = elgg_get_plugin_from_id('elggchat');
$plugin_name = $plugin->getManifest()->getName();

foreach ($params as $k => $v) {
	$result = $plugin->setUserSetting($k, $v, $user->guid);

	if (!$result) {
		return elgg_error_response(elgg_echo('elggchat:usersettings:save:error', [$plugin_name]), REFERER);
	}
}

return elgg_ok_response('', elgg_echo('elggchat:usersettings:save:success', [$plugin_name]), REFERER);
