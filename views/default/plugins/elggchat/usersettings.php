<?php

$user = elgg_get_page_owner_entity();

$enable_chat = elgg_get_plugin_user_setting('enableChat', $user->getGUID(), 'elggchat');
$allow_contact_from = elgg_get_plugin_user_setting('allow_contact_from', $user->getGUID(), 'elggchat');
$show_offline_user = elgg_get_plugin_user_setting('show_offline_user', $user->getGUID(), 'elggchat');

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('elggchat:usersettings:enable_chat'),
	'name' => 'params[enableChat]',
	'options_values' => [
		'yes' => elgg_echo("option:yes"),
		'no' => elgg_echo("option:no"),
	],
	'value' => $enable_chat,
]);

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('elggchat:usersettings:allow_contact_from'),
	'name' => 'params[allow_contact_from]',
	'options_values' => [
		'all' => elgg_echo("elggchat:usersettings:allow_contact_from:all"),
		'friends' => elgg_echo("elggchat:usersettings:allow_contact_from:friends"),
		'none' => elgg_echo("elggchat:usersettings:allow_contact_from:none"),
	],
	'value' => $allow_contact_from,
]);

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('elggchat:usersettings:show_offline_user'),
	'name' => 'params[show_offline_user]',
	'options_values' => [
		'yes' => elgg_echo("option:yes"),
		'no' => elgg_echo("option:no"),
	],
	'value' => $show_offline_user,
]);

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'user_guid',
	'value' => $user->guid,
]);

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'plugin_id',
	'value' => 'elggchat',
]);
