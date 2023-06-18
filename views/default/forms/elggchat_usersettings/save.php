<?php

$user = elgg_extract('user', $vars);
if (!$user || !$user->canEdit()) {
	return;
}

$enable_chat = elgg_get_plugin_user_setting('enableChat', $user->getGUID(), 'elggchat');
if (empty($enable_chat)) {
	$enable_chat = "yes";
}
$allow_contact_from = elgg_get_plugin_user_setting('allow_contact_from', $user->getGUID(), 'elggchat');
if (empty($allow_contact_from)) {
	$allow_contact_from = "friends";
}
$show_offline_user = elgg_get_plugin_user_setting('show_offline_user', $user->getGUID(), 'elggchat');
if (empty($show_offline_user)) {
	$show_offline_user = "no";
}

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
	'name' => 'guid',
	'value' => $user->guid,
]);

echo elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('save'),
	'class' => 'elgg-foot',
]);
