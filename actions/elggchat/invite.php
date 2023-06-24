<?php
/**
 * ElggChat - Pure Elgg-based chat/IM
 *
 * Action to invite the specified user to an existing session
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

$inviteId = (int) get_input("friend");
$sessionId = (int) get_input("chatsession");
$userId =  elgg_get_logged_in_user_guid();

$response = false;
if (($invite_user = get_user($inviteId)) && ($session = get_entity($sessionId)) && $inviteId != $userId) {
	if ($session->getSubtype() == ELGGCHAT_SESSION_SUBTYPE && !$session->hasRelationship($inviteId, ELGGCHAT_MEMBER) && $session->hasRelationship($userId, ELGGCHAT_MEMBER)) {
		$session->addRelationship($inviteId, ELGGCHAT_MEMBER);
		$user = get_user($userId);

		$session->annotate(ELGGCHAT_SYSTEM_MESSAGE, elgg_echo('elggchat:action:invite', [$user->name, $invite_user->name]), ACCESS_LOGGED_IN, $userId);
		$session->save();

		$response = true;
	}
}

$output = json_encode([
	'success' => $response,
]);

return elgg_ok_response($output, '', REFERER);
