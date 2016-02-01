<?php
/**
 * ElggChat - Pure Elgg-based chat/IM
 *
 * Action to get Google Talk based smileys
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

$smiley = get_input("smiley");

if ($smiley) {

	$contents = elgg_view("elggchat/$smiley");

	if ($contents) {
		header("Cache-Control: no-cache, no-store, must-revalidate");
		header("Content-Type: image/gif");
		header("Content-Length: " . strlen($contents));
		echo $contents;
	}
}
exit();
?>