<?php
/**
 * ElggChat - Pure Elgg-based chat/IM
 *
 * Admin settings definition
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

$plugin = elgg_extract('entity', $vars);

$chatUpdateInterval = $plugin->chatUpdateInterval;
$maxChatUpdateInterval = $plugin->maxChatUpdateInterval;
$maxSessionAge = $plugin->maxSessionAge;
$keepsessions = $plugin->keepsessions;
$enableSounds = $plugin->enableSounds;
$enableFlashing = $plugin->enableFlashing;
$enableSmilies = $plugin->enableSmilies;
$enableExtensions = $plugin->enableExtensions;

if ($plugin->onlinestatus_inactive <= $plugin->onlinestatus_active) {
	$plugin->onlinestatus_inactive = $plugin->onlinestatus_active + 10;
}

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('elggchat:admin:settings:chatupdateinterval'),
	'name' => 'params[chatUpdateInterval]',
	'options_values' => [
		5  => '5',
		10 => '15',
		15 => '15',
		30 => '30',
	],
	'value' => $chatUpdateInterval,
]);

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('elggchat:admin:settings:maxchatupdateinterval'),
	'name' => 'params[maxChatUpdateInterval]',
	'options_values' => [
		15  => '15',
		30  => '30',
		45  => '45',
		60  => '60',
		120 => '120',
	],
	'value' => $maxChatUpdateInterval,
]);

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('elggchat:admin:settings:maxsessionage'),
	'name' => 'params[maxSessionAge]',
	'options_values' => [
		3600    => elgg_echo("elggchat:admin:settings:hour", [1]),
		21600   => elgg_echo("elggchat:admin:settings:hours", [6]),
		43200   => elgg_echo("elggchat:admin:settings:hours", [12]),
		86400   => elgg_echo("elggchat:admin:settings:hours", [24]),
		604800  => elgg_echo("elggchat:admin:settings:days", [7]),
	],
	'value' => $maxSessionAge,
]);

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('elggchat:admin:settings:keepsessions'),
	'name' => 'params[keepsessions]',
	'options_values' => [
		'yes' => elgg_echo("option:yes"),
		'no' => elgg_echo("option:no"),
	],
	'value' => $keepsessions,
]);

echo elgg_view_field([
	'#type' => 'number',
	'#label' => elgg_echo('elggchat:admin:settings:online_status:active'),
	'name' => 'params[onlinestatus_active]',
	'value' => $plugin->onlinestatus_active,
	'min' => 10,
	'max' => 300,
	'step' => 10,
]);

echo elgg_view_field([
	'#type' => 'number',
	'#label' => elgg_echo('elggchat:admin:settings:online_status:inactive'),
	'name' => 'params[onlinestatus_inactive]',
	'value' => $plugin->onlinestatus_inactive,
	'min' => $plugin->onlinestatus_active + 10,
	'max' => 1200,
	'step' => 10,
]);

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('elggchat:admin:settings:enable_sounds'),
	'name' => 'params[enableSounds]',
	'options_values' => [
		'yes' => elgg_echo("option:yes"),
		'no' => elgg_echo("option:no"),
	],
	'value' => $enableSounds,
]);

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('elggchat:admin:settings:enable_flashing'),
	'name' => 'params[enableFlashing]',
	'options_values' => [
		'yes' => elgg_echo("option:yes"),
		'no' => elgg_echo("option:no"),
	],
	'value' => $enableFlashing,
]);

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('elggchat:admin:settings:enable_smilies'),
	'name' => 'params[enableSmilies]',
	'options_values' => [
		'yes' => elgg_echo("option:yes"),
		'no' => elgg_echo("option:no"),
	],
	'value' => $enableSmilies,
]);

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('elggchat:admin:settings:enable_extensions'),
	'#help' => elgg_echo('elggchat:admin:settings:enable_extensions_help'),
	'name' => 'params[enableExtensions]',
	'options_values' => [
		'yes' => elgg_echo("option:yes"),
		'no' => elgg_echo("option:no"),
	],
	'value' => $enableExtensions,
]);
