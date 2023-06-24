<?php
/**
 * ElggChat - Pure Elgg-based chat/IM
 *
 * Action to leave the specified session, and remove it from the system if no more members
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

$sessionId = (int) get_input("chatsession");
$userId = elgg_get_logged_in_user_guid();
$session = get_entity($sessionId);

$response = false;
if ($session && $session->hasRelationship($userId, ELGGCHAT_MEMBER)) {
	$session = get_entity($sessionId);
	$user = get_user($userId);

	$session->removeRelationship($userId, ELGGCHAT_MEMBER);

	$session->annotate(ELGGCHAT_SYSTEM_MESSAGE, elgg_echo('elggchat:action:leave', [$user->name]), ACCESS_LOGGED_IN, $userId);
	if ($session->save()) {
		$response = true;
	}

	// Clean up
	if ($session->countEntitiesFromRelationship(ELGGCHAT_MEMBER) == 0) {
		// No more members
		$keepsessions = elgg_get_plugin_setting("keepsessions","elggchat");
		if (elgg_get_plugin_setting("keepsessions","elggchat") != "yes") {
			if ($session->delete()) {
				$response = true;
			}
		}
	} elseif ($session->countAnnotations(ELGGCHAT_MESSAGE) == 0 && !$session->hasRelationship($session->owner_guid, ELGGCHAT_MEMBER)) {
		// Owner left without leaving a real message
		if ($session->delete()) {
			$response = true;
		}
	}
}

$output = json_encode([
	'success' => $response,
]);

return elgg_ok_response($output, '', REFERER);
