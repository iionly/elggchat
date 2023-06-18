<?php

function elggchat_logout_handler($event, $object_type, $object) {

	$access = elgg_set_ignore_access(true);
	$access_status = access_get_show_hidden_status();
	access_show_hidden_entities(true);

	if (!empty($object) && ($object instanceof ElggUser)) {
		$chat_sessions_count = elgg_get_entities_from_relationship([
			'relationship' => ELGGCHAT_MEMBER,
			'relationship_guid' => $object->guid,
			'inverse_relationship' => true,
			'order_by' => "time_created desc",
			'limit' => false,
			'count' => true,
		]);

		if ($chat_sessions_count > 0) {
			$sessions = $object->getEntitiesFromRelationship(['relationship' => ELGGCHAT_MEMBER, 'inverse_relationship' => true]);

			foreach($sessions as $session) {
				remove_entity_relationship($session->guid, ELGGCHAT_MEMBER, $object->guid);

				$session->annotate(ELGGCHAT_SYSTEM_MESSAGE, elgg_echo('elggchat:action:leave', [$object->name]), ACCESS_LOGGED_IN, $object->guid);
				$session->save();

				// Clean up
				if($session->countEntitiesFromRelationship(ELGGCHAT_MEMBER) == 0) {
					// No more members
					$keepsessions = elgg_get_plugin_setting("keepsessions","elggchat");
					if (elgg_get_plugin_setting("keepsessions","elggchat") != "yes") {
						$session->delete();
					}
				} elseif ($session->countAnnotations(ELGGCHAT_MESSAGE) == 0 && !check_entity_relationship($session->guid, ELGGCHAT_MEMBER, $session->owner_guid)) {
					// Owner left without leaving a real message
					$session->delete();
				}
			}
		}
	}

	access_show_hidden_entities($access_status);
	elgg_set_ignore_access($access);

	return true;
}
