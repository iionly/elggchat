<?php

define("ELGGCHAT_MEMBER", "elggchat_member");
define("ELGGCHAT_SESSION_SUBTYPE", "elggchat_session");
define("ELGGCHAT_SYSTEM_MESSAGE", "elggchat_system_message");
define("ELGGCHAT_MESSAGE", "elggchat_message");

return [
	'actions' => [
		'elggchat/create' => [
			'access' => 'logged_in',
		],
		'elggchat/post_message' => [
			'access' => 'logged_in',
		],
		'elggchat/poll' => [
			'access' => 'logged_in',
		],
		'elggchat/invite' => [
			'access' => 'logged_in',
		],
		'elggchat/leave' => [
			'access' => 'logged_in',
		],
		'elggchat/get_smiley' => [
			'access' => 'logged_in',
		],
		'elggchat/usersettings_save' => [
			'access' => 'logged_in',
		],
		'elggchat/admin_message' => [
			'access' => 'admin',
		],
		'elggchat/delete_session' => [
			'access' => 'admin',
		],
	],
	'settings' => [
		'chatUpdateInterval' => 5,
		'maxChatUpdateInterval' => 30,
		'maxSessionAge' => 21600,
		'keepsessions' => 'yes',
		'enableSounds' => 'yes',
		'enableFlashing' => 'yes',
		'enableSmilies' => 'yes',
		'enableExtensions' => 'yes',
		'onlinestatus_active' => 60,
		'onlinestatus_inactive' => 600,
	],
	'user_settings' => [
		'enableChat' => 'yes',
		'allow_contact_from' => 'friends',
		'show_offline_user' => 'no',
	],
	'routes' => [
		'elggchat:usersettings' => [
			'path' => '/elggchat/usersettings/{username?}',
			'resource' => 'elggchat/usersettings',
		],
	],
	'hooks' => [
		'register' => [
			'menu:page' => [
				"\ElggchatHooks::elggchat_administer_utilities_page" => [],
				"\ElggchatHooks::elggchat_usersettings_page" => [],
			],
			'menu:user_hover' => [
				"\ElggchatHooks::elggchat_user_hover_menu" => [],
			],
		],
		'cron' => [
			'hourly' => [
				"\ElggchatHooks::elggchat_session_cleanup" => [],
			],
		],
	],
	'events' => [
		'logout:before' => [
			'user' => [
				"\ElggchatEvents::elggchat_logout_handler" => [],
			],
		],
	],
	'views' => [
		'default' => [
			'elggchat/' => __DIR__ . '/graphics',
		],
	],
	'view_extensions' => [
		'css/elgg' => [
			'elggchat/css' => [],
		],
		'css/admin' => [
			'elggchat/admin_css' => [],
		],
		'page/elements/footer' => [
			'elggchat/session_monitor' => [],
		],
	],
];
