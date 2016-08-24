Elggchat for Elgg 2.X
=====================

Latest Version: 2.0.2  
Released: 2016-08-24  
Contact: iionly@gmx.de  
License: GNU General Public License version 2  
Copyright: (c) iionly (for Elgg 1.8 and newer), ColdTrick IT Solutions  


Description
-----------

This is an updated, bug-fixed and slightly improved version of the Elggchat plugin originally by Coldtrick IT Solutions (https://community.elgg.org/plugins/384910). This version of Elggchat is intended for Elgg 2.X.

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

To avoid the confusion due to the Elgg default one-directional friending (better called "following") I would suggest using the Friend request plugin (https://community.elgg.org/plugins/384965). Using the Friend request plugin will make friending a two-way relationship (a site member can be sure that another member he is a friend with made him a friend, too, and can be invited for chatting). As friending with the Friend request plugin is by permission only the privacy of the members is considered - if you don't want to be friend with someone simply decline the request and the other member.


Server load caused by the Elggchat plugin
-----------------------------------------

The Elggchat plugin can be downloaded for free but offering a chat feature on your site is not for free regarding the server load. The exact load caused by the chatting is difficult to predict as it depends on the number of chat sessions going on in parallel. Still, a few general hints:

- The Elggchat plugin is very likely too much on shared servers. Don't risk getting in trouble with your webhoster. Or in other words: use the Elggchat plugin on shared servers on your own risk!
- The Elggchat plugin most likely suitable for small to medium Elgg community sites only. Depending on your server hardware / hosting plan you might be able to use it also on larger sites with a higher number of concurrent users (i.e. higher number of concurrent chat sessions). I would suggest to monitor the server load closely after installing the Elggchat plugin to make sure that it's not causing too much load. I'm afraid there's not much you can do, if the load is getting too high apart from looking for another solution for offering a chat feature on your site.
- Consider using the No logging plugin (https://community.elgg.org/plugins/1441338). The chat messages are saved as Elgg annotations each. By default Elgg creates for each annotations log entries in its Elgg log. The creation of all the log entries for the chat messages can create some additional server load and also result in an increased size of the Elgg log table. When using the No logging plugin there won't be any log entries created anymore for the Elgg chats. But there won't be any log entries for any other user actions on your site either! So, you have to decide for yourself, if you need the Elgg log capabilities or not.


Installation and configuration
------------------------------

1. If you have a previous version of the plugin installed, start with deaktivating the Elggchat plugin, then remove the elggchat plugin folder from the mod directory completely before installing the new version,
2. Copy the elggchat plugin folder into the mod folder on your server,
3. Enable the plugin in the admin section of your site,
4. Check out the plugin settings and modify the configurations according to your liking.

Additional configuration: for the chat session cleanup to work Elgg's hourly cronjob must be set up on the server.
