<?php
/**
 * ElggChat - Pure Elgg-based chat/IM
 *
 * Action to post a system message in a chat session as admin
 *
 * @package elggchat
 * @author iionly (iionly@gmx.de)
 * @copyright iionly 2014
 * @link https://github.com/iionly
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 */

$sessionId = (int) get_input("chatsession");
$session = get_entity($sessionId);

if ($session->getSubtype() == ELGGCHAT_SESSION_SUBTYPE) {
	$admin_message = nl2br(get_input("admin_message"));
	$userId = elgg_get_logged_in_user_guid();

	if (!empty($admin_message)) {
		if ($session->annotate(ELGGCHAT_SYSTEM_MESSAGE, elgg_echo('elggchat:admin_message').$admin_message, ACCESS_LOGGED_IN, $userId)) {
			if ($session->save()) {
				return elgg_ok_response('', elgg_echo("elggchat:post_admin_message_success"), REFERER);
		};
	}
}
return elgg_error_response(elgg_echo("elggchat:post_admin_message_error"), REFERER);
