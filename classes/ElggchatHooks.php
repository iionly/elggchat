<?php
/**
 * Hooks for Elggchat
 */

class ElggchatHooks {

	// Session cleanup by cron
	public static function elggchat_session_cleanup(\Elgg\Hook $hook) {
		$returnvalue = $hook->getValue();
		
		$keepsessions = elgg_get_plugin_setting("keepsessions", "elggchat");
		if (elgg_get_plugin_setting("keepsessions", "elggchat") == "yes") {
			return $returnvalue;
		}

		elgg_call(ELGG_IGNORE_ACCESS | ELGG_SHOW_DISABLED_ENTITIES, function () use ($returnvalue) {

			$session_count = elgg_get_entities(['type' => "object", 'subtype' => ELGGCHAT_SESSION_SUBTYPE, 'count' => true]);

			if ($session_count < 1) {
				// no sessions to clean up
				return $returnvalue . elgg_echo("elggchat:crondone");
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
		});

		return $returnvalue . elgg_echo("elggchat:crondone");
	}

	// Add to the user hover menu
	public static function elggchat_user_hover_menu(\Elgg\Hook $hook) {
		$menu = $hook->getValue();
		$user = $hook->getParam('entity');

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
			} else if ($user->isFriendsWith(elgg_get_logged_in_user_guid())) {
				// default: only friends allowed to invite to chat
				$allowed = true;
			} else if (elgg_is_admin_logged_in()) {
				// admins can always invite everyone for chatting
				$allowed = true;
			}
			if ($allowed) {
				$menu[] = ElggMenuItem::factory([
					'name' => 'elggchat-hover',
					'href' => '#',
					'text' => elgg_echo('elggchat:chat:profile:invite'),
					'icon' => 'comments-o',
					'section' => 'action',
					'data-userguid' => "{$user->guid}",
				]);
			}
		}
		return $menu;
	}

	// Usersettings
	public static function elggchat_administer_utilities_page(\Elgg\Hook $hook) {
		$menu = $hook->getValue();
		
		if (!elgg_in_context('admin')) {
			return;
		}

		// Add admin menu item
		$menu[] = ElggMenuItem::factory([
			'name' => 'administer_utilities:elggchat',
			'href' => 'admin/administer_utilities/elggchat',
			'text' => elgg_echo('admin:administer_utilities:elggchat'),
			'context' => 'admin',
			'parent_name' => 'administer_utilities',
			'section' => 'administer'
		]);

		return $menu;
	}

	// Usersettings
	public static function elggchat_usersettings_page(\Elgg\Hook $hook) {
		$menu = $hook->getValue();

		if (!elgg_in_context('settings')) {
			return;
		}

		$user = elgg_get_page_owner_entity();
		if (!$user || !$user->canEdit()) {
			return;
		}

		$menu[] = ElggMenuItem::factory([
			'name' => 'elggchat_usersettings',
			'text' => elgg_echo('elggchat:usersettings'),
			'href' => "elggchat/usersettings/{$user->username}",
		]);

		return $menu;
	}
}
