<?php

$user = $vars['user'];

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

echo "<div class='mbm'>" . elgg_echo('elggchat:usersettings:enable_chat');
echo elgg_view('input/select', array(
	'name' => 'params[enableChat]',
	'options_values' => array(
		'yes' => elgg_echo("option:yes"),
		'no' => elgg_echo("option:no"),
	),
	'value' => $enable_chat,
)) . "</div>";

echo "<div class='mbm'>" . elgg_echo('elggchat:usersettings:allow_contact_from');
echo elgg_view('input/select', array(
	'name' => 'params[allow_contact_from]',
	'options_values' => array(
		'all' => elgg_echo("elggchat:usersettings:allow_contact_from:all"),
		'friends' => elgg_echo("elggchat:usersettings:allow_contact_from:friends"),
		'none' => elgg_echo("elggchat:usersettings:allow_contact_from:none"),
	),
	'value' => $allow_contact_from,
)) . "</div>";

echo "<div class='mbm'>" . elgg_echo('elggchat:usersettings:show_offline_user');
echo elgg_view('input/select', array(
	'name' => 'params[show_offline_user]',
	'options_values' => array(
		'yes' => elgg_echo("option:yes"),
		'no' => elgg_echo("option:no"),
	),
	'value' => $show_offline_user,
)) . "</div>";

echo "<div class='elgg-foot'>" . elgg_view('input/hidden', array('name' => 'guid', 'value' => $user->guid));
echo elgg_view('input/submit', array('value' => elgg_echo('save')))  . "</div>";
