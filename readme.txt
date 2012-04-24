=== Basic CMIS for Wordpress ===
Contributors: ansonhoyt
Tags: comments, spam
Requires at least: 3.3.1
Tested up to: 3.3.1

Wordpress Plugin for basic CMIS integration. Does nothing yet, but will read from Alfresco Enterprise's CMIS interface and render a list of documents.

Plugin URI: https://github.com/ansonhoyt/Basic-CMIS
Version: 0.0.1 (pre-alpha)
Author: Anson Hoyt
Author URI: https://github.com/ansonhoyt

== Description ==

=== Installation ===
1. Pull down the code from Github.
1. Create a 'basic-cmis' folder under your Wordpress plugins folder.
1. Upload the code to the new folder.
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Configure the plugin via the Admin panel. You must provide a CMIS url, username and password. This is used sitewide.
1. Use the `cmis` shortcode in your content.

=== Usage ===
Shortcode:
`[cmis folder="my particular/folder name/" keywords="coffee tea"]`

== License ==
License: A "Slug" license name e.g. GPL2
