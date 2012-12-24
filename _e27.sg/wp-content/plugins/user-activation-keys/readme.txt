=== User Activation Keys ===
Contributors: dsader
Donate link: http://dsader.snowotherway.org
Tags: signup, username, activation, network, network user activation, activation keys, multisite, network, users
Requires at least: 3.2.1
Tested up to: 3.2.1
Stable tag: Trunk

WP Network Multisite "mu=plugin" for user activation key removal or approval. 

== Description ==

Ever signup a user account, delete it, and try to signup up the same username again? 

Ever try to support a new user who created a username, but entered the wrong email address and so can't activate, and can't signup with the same username?

Ever wanted to signup a bunch of users with phony emails so users without email could start blogging right away?

I have, so I made a plugin to help me.

WP Network Multisite "mu=plugin" for user activation key removal or approval. See Network Admin-->"User Activation Keys" to delete activation keys - to allow immediate (re)signup of users who otherwise get the "try again in two days" message. Also, users waiting to be activated (or can't because the email with the generated activation link is "gone") can be approved manually.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload `ds_wp3_user_activation_keys.php` to the `/wp-content/mu-plugins/` directory
2. Delete or approve keys at Network Admin->"User Activation Keys" page

== Frequently Asked Questions ==

* I deleted an activation key, but I still can't signup with that username? Delete the user from SuperAdmin->Users and delete the activation key.
* Why are there buttons to mass delete keys over 30 days old? I needed the buttons when upgrading an ancient WPMU install several years ago. I left them in the plugin even though my sites/networks can no longer reproduce the accumulation of keys that makes them useful.
* Is it safe to delete keys from otherwise active users? Yes, as far as I know. I don't know why the activation key for activated users remains behind. But they appear to delete autoomagicaly after "a couple of days" anyway.
* Some users have an activation key in $wpdb->users? That is normal. This plugin doesn't touch those keys, only the ones in $wpdb->signup.

== Screenshots ==

1. Network Admin->"User Activation Keys" page

== Changelog ==
= 3.0.4 = 
* Tested up to: WP 3.2.1

= 3.0.3 = 
* site_url/admin_url typo fix

= 3.0.2 = 
* update roles/caps

= 3.0.1 = 
* initial release

== Upgrade Notice ==
= 3.0.2 = 
* update roles/caps

= 3.0.1 =
* initial release