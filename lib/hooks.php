<?php

// Session cleanup by cron
function elggchat_session_cleanup($hook, $entity_type, $returnvalue, $params) {
	
	$keepsessions = elgg_get_plugin_setting("keepsessions", "elggchat");
	if (elgg_get_plugin_setting("keepsessions", "elggchat") == "yes") {
		return $returnvalue;
	}

	$resulttext = elgg_echo("elggchat:crondone");

	$access = elgg_set_ignore_access(true);
	$access_status = access_get_show_hidden_status();
	access_show_hidden_entities(true);

	$session_count = elgg_get_entities(['type' => "object", 'subtype' => ELGGCHAT_SESSION_SUBTYPE, 'count' => true]);

	if ($session_count < 1) {
		// no sessions to clean up
		access_show_hidden_entities($access_status);
		elgg_set_ignore_access($access);
		return $returnvalue . $resulttext;
	}

	$sessions = elgg_get_entities(['type' => "object", 'subtype' => ELGGCHAT_SESSION_SUBTYPE, 'limit' => $session_count]);

	foreach ($sessions as $session) {
		$member_count = $session->countEntitiesFromRelationship(ELGGCHAT_MEMBER);

		if($member_count > 0) {
			$max_age = (int) elgg_get_plugin_setting("maxSessionAge", "elggchat");
			$age = time() - $session->time_updated;

			if($age > $max_age) {
				$session->delete();
			}
		} else {
			$session->delete();
		}
	}

	access_show_hidden_entities($access_status);
	elgg_set_ignore_access($access);

	return $returnvalue . $resulttext;
}

// Add to the user hover menu
function elggchat_user_hover_menu($hook, $type, $return, $params) {
	$user = $params['entity'];

	if (elgg_is_logged_in() && elgg_get_logged_in_user_guid() != $user->guid) {

		$allowed = false;
		$allow_contact_from = elgg_get_plugin_user_setting("allow_contact_from",  $user->guid, "elggchat");
		if (!empty($allow_contact_from)) {
			if($allow_contact_from == "all") {
				$allowed = true;
			} elseif ($allow_contact_from == "friends") {
				if($user->isFriendsWith(elgg_get_logged_in_user_guid())) {
					$allowed = true;
				}
			}
		} else if($user->isFriendsWith(elgg_get_logged_in_user_guid())) {
			// default: only friends allowed to invite to chat
			$allowed = true;
		} else if(elgg_is_admin_logged_in()) {
			// admins can always invite everyone for chatting
			$allowed = true;
		}
		if($allowed) {
			$item = new ElggMenuItem('elggchat-hover', elgg_echo("elggchat:chat:profile:invite"), '#');
			$item->setSection('action');
			$item->{"data-userguid"} = "{$user->guid}";
			$return[] = $item;
		}
	}
	return $return;
}

// Usersettings
function elggchat_usersettings_page($hook, $type, $return, $params) {
	if (!elgg_in_context('settings')) {
		return;
	}

	$user = elgg_get_page_owner_entity();
	if (!$user || !$user->canEdit()) {
		return;
	}

	$return[] = ElggMenuItem::factory([
		'name' => 'elggchat_usersettings',
		'text' => elgg_echo('elggchat:usersettings'),
		'href' => "elggchat/usersettings/{$user->username}",
	]);

	return $return;
}
