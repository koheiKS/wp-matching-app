=== WP Post Rating ===
Contributors: shoaib88
Tags: post rating, comment rating, comments, rating, postratings, reviews, comment, field, ratings, stars, rating stars, star rating, post, post comment, wordpress comment, vote, votes, comment star field, feedback, rate post, digg, ajax, rich snippets, structured data, microdata, schema markup
Requires at least: 4.5
Tested up to: 5.6
Stable tag: 2.4.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html 
Displays a stars rating system to your posts, custom posts and pages.
== Description ==

WP Post Rating is a simple plugin which allows users to rate your posts, pages. This plugin shows average rating, rated stars with each comment, floating links and also support Google Rich Snippets.

Stars Rating are displayed as:
* Five stars above comment form fields,
* Below the Post title, as an average rating,
* For each comment, voted stars with comment text.
* Rated stars with comment in admin list


<h3>Installation</h3>
1. Upload "wpcr-comment-rating" to the "/wp-content/plugins/" directory.
2. Activate the plugin through the "Plugins" menu in WordPress.
3. Go to setting > Post rating and enable both options. Check post detail page to see it in action.

<h3>Features</h3>
* Multiple rating stars
* Stars color scheme
* Average rating display options
* Enable/disable floating links (post navigation, social share)
* Google rich snippets


== Shortcodes ==

* Average rating shortcode [wppr_avg_rating]
* Average rating shortcode by post id [wppr_avg_rating_post_id id='1'](Change post id 1 with your post id.)

== Screenshots ==

1. Stars with comment form.
2. Visitor/user rated stars.
3. Average rating.
4. General setting.
5. Stars setting.
6. Average rating display setting.
7. Floating links display setting
8. Rating stars with each comment in admin

== Changelog ==

= 2.4 =
* Fixed: PHP warnings and some minor issues
* Upgraded to object-oriented codebase, based on the WordPress Plugin boilerplate
* Add new translation string to language file

= 2.3.1 =
* Fixed: PHP warnings and some minor issues
* Show star rating with each comment in admin

= 2.3 =
* Fixed: PHP warnings
* Fixed: .POT string found issue
* Fixed minor issues

= 2.2.3 =
* Fix: average rating shortcode by post id, include id parameter

= 2.2.2 =
* Included the supported structured data types for rich snippets
* Updated the rich snippets structured data
* Fix: Post content html tags issue

= 2.2.1 =
* Fixed PHP warnings

= 2.2 =
* Fixed/hide stars rating from comment reply form
* Changed avg rating data attribute
* Add setting options to change voted stars position with comment text.

= 2.1.7 =
* Check plugin compatibility with Divi theme and wp latest version
* Change star images
* Display total rated value with each user/visitor comment

= 2.1.6 =
* Check plugin compatibility on wp latest version 

= 2.1.4 =
*Change plugin text domain
*Rename translation files

= 2.1.3 =
* Add .pot file for string translation
* Make text to translatable string

= 2.1.2 =
* Fixed minor issues.

= 2.1.1 =
* Change Google rich snippets structure
* Set average rating layout
* Set setting page layout
* Load bootstrap files only for plugin setting page

= 2.1 =
* Add Google rich snippets
* Add average rating text field in setting page

= 2.0 =
* Add multiple setting options for stars
* Change floating links icons

= 1.3 =
* Add next, previous floating link option
* Add facebook, twitter and google plus sharing links

= 1.2.3 =
* Add average label display options

= 1.2.2 =
* FIXED: Post tags links remove when average rating is shown.

= 1.2.1 =
* Fixed some minor issues and done some code reformatting.

= 1.2 =
* Add rating images option and done some code reformatting.

= 1.1.0 =
* FIXED: PHP file include error.