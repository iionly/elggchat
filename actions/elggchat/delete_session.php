<?php
/**
 * ElggChat - Pure Elgg-based chat/IM
 *
 * Action to close the specified session immediately at the instigation of an admin
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
	if($session->delete()) {
		return elgg_ok_response('', elgg_echo("elggchat:session_delete_success"), '/admin/administer_utilities/elggchat');
	} else {
		register_error(elgg_echo("elggchat:session_delete_error"));
	}
}
return elgg_error_response(elgg_echo("elggchat:session_delete_error"), '/admin/administer_utilities/elggchat');
