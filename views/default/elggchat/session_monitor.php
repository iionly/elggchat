<?php
/**
 * ElggChat - Pure Elgg-based chat/IM
 *
 * Builds the ElggChat Toolbar
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

elgg_require_js('elggchat/session');

$basesec = elgg_get_plugin_setting("chatUpdateInterval","elggchat");
if (!$basesec) {
	$basesec = 5;
}
$maxsecs = elgg_get_plugin_setting("maxChatUpdateInterval","elggchat");
if (!$maxsecs) {
	$maxsecs = 30;
}

$sound = elgg_get_plugin_setting("enableSounds","elggchat");
if(empty($sound)) {
	$sound = "no";
}

$flash = elgg_get_plugin_setting("enableFlashing","elggchat");
if (empty($flash)) {
	$flash = "no";
}

$offlineuser = elgg_get_plugin_user_setting("show_offline_user", 0, "elggchat");

echo "<div id='elggchat_toolbar' data-basesec='{$basesec}' data-maxsec='{$maxsecs}' data-sound='{$sound}' data-flash='{$flash}' data-offlineuser='{$offlineuser}'>";
	echo '<div id="elggchat_toolbar_right">';
		echo '<div id="elggchat_sessions"></div>';

		echo '<div id="elggchat_friends">';
			echo '<a href="#"></a>';
			echo '<div id="elggchat_friends_picker"></div>';
		echo '</div>';

		echo '<div id="elggchat_extensions">';
			if(elgg_get_plugin_setting("enableExtensions", "elggchat") == "yes") {
				echo elgg_view("elggchat/extensions");
			}
		echo '</div>';
	echo '</div>';

	echo '<div id="toggle_elggchat_toolbar" class="fa toggle_elggchat_toolbar" title="' . elgg_echo("elggchat:toolbar:minimize") . '"></div>';
echo '</div>';
