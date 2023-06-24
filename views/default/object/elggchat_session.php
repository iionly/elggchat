<?php
/**
 * View for elggchat_session objects
 *
 * @package elggchat
 * @author iionly (iionly@gmx.de)
 * @copyright iionly 2014
 * @link https://github.com/iionly
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 */

elgg_admin_gatekeeper();

$full = elgg_extract('full_view', $vars, false);
$session = elgg_extract('entity', $vars, false);

if (!$session) {
	return true;
}

if ($full) {

	$info = "<table>";
	$info .= "<tr><td class='elggchat-chatsession-text'><label>" . elgg_echo('elggchat:session_details:guid', [$session->getGUID()]) . "</label></td></tr>";

	$delete_session = elgg_view("output/url", [
		'href' => elgg_get_site_url() . "action/elggchat/delete_session?chatsession=" . $session->getGUID(),
		'text' => elgg_echo('elggchat:chatsession_delete'),
		'confirm' => elgg_echo('elggchat:chatsession_deleteconfirm'),
		'class' => 'elgg-button elgg-button-cancel',
	]);
	$info .= "<tr><td class='elggchat-chatsession-text'>" . $delete_session . "</td></tr>";

	$info .= "<tr><td class='elggchat-chatsession-text'><label>" . elgg_echo('elggchat:post_admin_message') . "</label>";
	$form_body = elgg_view('input/text', ['name' => 'admin_message']);
	$form_body .= elgg_view('input/submit', ['value' => elgg_echo('submit')]);
	$action_url = elgg_get_site_url() . "action/elggchat/admin_message?chatsession=".$session->getGUID();
	$info .= elgg_view('input/form', ['body' => $form_body, 'action' => $action_url]);
	$info .= "<td><tr>";

	$info .= "<tr><td class='elggchat-chatsession-text'><label>" . elgg_echo('elggchat:session:last_updated') . "</label>" . elgg_get_friendly_time($session->time_updated) . "</td></tr>";

	$info .= "<tr><td class='elggchat-chatsession-text'><label>" . elgg_echo('elggchat:session:chat_participants') . "</label>" . "<br>";
	$members = elgg_get_entities(['relationship' => ELGGCHAT_MEMBER, 'relationship_guid' => $session->getGUID()]);
	if ($members) {
		$info .= "<table>";
		foreach($members as $member) {
			$result = "";
			$result .= "<tr class='chatmember'>";
			$result .= "<td>".elgg_view('output/img', ['src' => $user->getIconURL('tiny'), 'alt' => $user->name, 'class' => 'messageIcon'])."</td>";
			$result .= "<td class='chatmemberinfo'>"."<a href='" . $member->getUrl() . "'>" . $member->name . "</a></td>";
			$result .= "</tr>";
			$info .= $result;
		}
		$info .= "</table></td></tr>";
	} else {
		$info .= "<p>".elgg_echo('elggchat:session:no_participants')."</p></td></tr>";
	}

	$info .= "<tr><td class='elggchat-chatsession-text'><label>" . elgg_echo('elggchat:session:session_messages') . "</label>" . "<br>";
	$messages = elgg_get_annotations([
		'annotation_names' => [ELGGCHAT_MESSAGE, ELGGCHAT_SYSTEM_MESSAGE],
		'guid' => $session->guid,
		'limit' => false,
		'order' => 'desc',
	]);
	if ($messages) {
		foreach($messages as $message) {
			$member = get_entity($message->owner_guid);
			$result = "";
			if ($message->name == ELGGCHAT_MESSAGE) {
				$result .= "<div name='message' id='" .  $offset . "' class='messageWrapper'>";

				$result .= "<table><tr><td rowspan='2'>";
				$result .= elgg_view('output/img', ['src' => $user->getIconURL('tiny'), 'alt' => $user->name, 'class' => 'messageIcon']);
				$result .= "</td><td class='messageName'>" . $member->name . ", " . elgg_get_friendly_time($message->time_created) . "</td></tr>";

				$result .= "<tr><td>";

				$result .= nl2br($message->value);
				$result .= "</td></tr></table>";
				$result .= "</div>";
			} elseif ($message->name == ELGGCHAT_SYSTEM_MESSAGE) {
				$result .= "<div name='message' id='" .  $offset . "' class='systemMessageWrapper'>";
				$result .= $message->value;
				$result .= "</div>";
			}
			$info .=  $result;
		}
		$info .= "</td></tr>";
	} else {
		$info .= "<p>".elgg_echo('elggchat:session:no_messages')."</p></td></tr>";
	}

	$info .= "</table>";

	echo "<div class='elggchat-chatsessions'>";
	echo $info;
	echo "</div>";

} else {
	$session_details =  elgg_view("output/url", [
		'href' => elgg_get_site_url() . "admin/administer_utilities/elggchat?session_guid=" . $session->getGUID(),
		'text' => elgg_echo('elggchat:chatsession_details'),
		'is_trusted' => true,
		'class' => 'elgg-button elgg-button-action',
	]) . "<br><br>";
	$delete_session = elgg_view("output/url", [
		'href' => elgg_get_site_url() . "action/elggchat/delete_session?chatsession=" . $session->getGUID(),
		'text' => elgg_echo('elggchat:chatsession_delete'),
		'confirm' => elgg_echo('elggchat:chatsession_deleteconfirm'),
		'class' => 'elgg-button elgg-button-cancel',
	]);

	$info = "<table>";
	$info .= "<tr><td class='elggchat-chatsession-text'><label>" . elgg_echo('elggchat:session:guid', [$session->getGUID()]) . "</label><td><tr>";
	$info .= "<tr>";
	$info .= "<td class='elggchat-chatsession-text'>" . $session_details . $delete_session . "</td>";
	$info .= "<td class='elggchat-chatsession-text'>";
	$info .= "<label>" . elgg_echo('elggchat:session:last_updated') . "</label>" . elgg_get_friendly_time($session->time_updated) . "<br>";
	$members_count = elgg_get_entities(['relationship' => ELGGCHAT_MEMBER, 'relationship_guid' => $session->getGUID(), 'count' => true]);
	$info .= "<label>" . elgg_echo('elggchat:session:number_chat_participants') . "</label>" . $members_count . "<br>";
	$messages_count = elgg_get_annotations([
		'annotation_names' => array(ELGGCHAT_MESSAGE, ELGGCHAT_SYSTEM_MESSAGE),
		'guid' => $session->guid,
		'count' => true,
	]);
	$info .= "<label>" . elgg_echo('elggchat:session:number_session_messages') . "</label>" . $messages_count;
	$info .= "</td></tr></table>";

	echo "<div class='elggchat-chatsessions'>";
	echo $info;
	echo "</div>";
}
