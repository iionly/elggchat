<?php

function elggchat_logout_handler(\Elgg\Event $event) {

	$object = $event->getObject();

	elgg_call(ELGG_IGNORE_ACCESS | ELGG_SHOW_DISABLED_ENTITIES, function () use ($object) {
	
		if (!empty($object) && ($object instanceof ElggUser)) {
			$chat_sessions_count = elgg_get_entities([
				'relationship' => ELGGCHAT_MEMBER,
				'relationship_guid' => $object->guid,
				'inverse_relationship' => true,
				'order_by' => [
					new \Elgg\Database\Clauses\OrderByClause("time_created desc"),
				],
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
	});

	return true;
}
