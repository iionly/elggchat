Elggchat for Elgg 3.0 and newer Elgg 3.X
========================================

Latest Version: 3.0.0  
Released: 2023-06-17  
Contact: iionly@gmx.de  
License: GNU General Public License version 2  
Copyright: (c) iionly (for Elgg 1.8 and newer), ColdTrick IT Solutions  


Description
-----------

This is an updated, bug-fixed and slightly improved version of the Elggchat plugin originally by Coldtrick IT Solutions (https://community.elgg.org/plugins/384910). This version of Elggchat is intended for Elgg 3.X.

The Elggchat plugin provides a chat/instant messaging feature based completely on the Elgg platform. Start chatting from the profile icon of community site member, or by selecting a friend from the friendpicker on the chat toolbar. Sessions will be shown on the chat toolbar.


Features
--------

- Privately chat with other members in the community,
- User option: only your friends, everyone or nobody is able to invite you to chat,
- Special chat toolbar (collapsable),
- Online/offline indication,
- Multiple members / friends in one chatsession,
- Multiple sessions at the same time,
- Smilies,
- Session cleanup by cron,
- Session management from admin backend (listing open chat session, deleting session, posting admin messages to a session).


What "Only my friends can contact me" means within the Elggchat plugin
----------------------------------------------------------------------

By default the friend relationship of Elgg is one-directional, i.e. if you add another member as friend the other members does not make you automatically a friends, too. Now you might not want to chat with everyone who made you a friend without you being able to intervene. For privacy reasons the option "Only my friends can contact me" of the user setting "Allow the following to contact me by chat" means that only these members who you made a friend can contact you. From the other way round you might not be able to invite a member for chatting you made a friends because this member did not make you a friend, too.

To avoid the confusion due to the Elgg default one-directional friending (better called "following") there was the Friend request plugin (https://community.elgg.org/plugins/384965) to make the friending bi-directional if a friend request was accepted (or prevented the one-directional friending if the request was denied). The Friend request plugin was never updated for Elgg 3. On Elgg 3 there was a separate Friends plugin added to Elgg core but only on Elgg 3.2 this plugin got the Friend request plugin option. So, if you are using Elgg 3 I would suggest you upgrade to the latest Elgg 3.3 version to be able to activate the Friend request option of the bundled Friends plugin. 

Using the Friend request option of the bundled Friends plugin will make friending a two-way relationship (a site member can be sure that another member he is a friend with made him a friend, too, and can be invited for chatting). As friending with the Friend request option enabled is by permission only the privacy of the members is considered - if you don't want to be friend with someone simply decline the request and the other member can't start chatting with you.


Server load caused by the Elggchat plugin
-----------------------------------------

The Elggchat plugin can be downloaded for free but offering a chat feature on your site is not for free regarding the server load. The exact load caused by the chatting is difficult to predict as it depends on the number of chat sessions going on in parallel. Still, a few general hints:

- The Elggchat plugin is very likely too much on shared servers. Don't risk getting in trouble with your webhoster. Or in other words: use the Elggchat plugin on shared servers on your own risk!
- The Elggchat plugin most likely suitable for small to medium Elgg community sites only. Depending on your server hardware / hosting plan you might be able to use it also on larger sites with a higher number of concurrent users (i.e. higher number of concurrent chat sessions). I would suggest to monitor the server load closely after installing the Elggchat plugin to make sure that it's not causing too much load. I'm afraid there's not much you can do, if the load is getting too high apart from looking for another solution for offering a chat feature on your site.
- Consider keeping the Elgg core "System Log" plugin deactivated. The chat messages are saved as Elgg annotations each. If you have the System Log plugin enabled, Elgg creates for each annotations log entries in its Elgg log table. The creation of all the log entries for the chat messages can create some additional server load and also result in an increased size of the Elgg log table. On Elgg versions before 3.X there wasn't a separate System Log plugin and to prevent the log entries from getting created I had provided the No Loggin plugin to stop log entries from getting created. On Elgg 3.0 or newer you won't need the No Loggin plugin anymore, if you just keep the System Log plugin disabled. But there won't be any log entries for any other user actions on your site either! So, you have to decide for yourself, if you need the Elgg log capabilities or not.


Notification sound on new messages
----------------------------------

There's the plugin option to play a notification sound on arrival of a new message. The sound will only be played if the chat window is minimized (assuming the chat participant will notice the new message otherwise anyway). But the sound might not be heard for some people even with the chat window minimized. That's likely caused by their browser blocking the autoplay of the notification sound. It might more likely be blocked on browsers used on mobile devices. The site member would have to unblock the autoplay rejection of the browser. These can be allowed per site (well, at least in Firefox...). Anyway, flashing the minimized chat window on arrival of a new message isn't blocked at least...


Installation and configuration
------------------------------

1. If you have a previous version of the plugin installed, start with deaktivating the Elggchat plugin, then remove the elggchat plugin folder from the mod directory completely before installing the new version,
2. Copy the elggchat plugin folder into the mod folder on your server,
3. Enable the plugin in the admin section of your site,
4. Check out the plugin settings and modify the configurations according to your liking.

Additional configuration: for the chat session cleanup to work Elgg's hourly cronjob must be set up on the server.
