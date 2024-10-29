=== Assign Related Posts ===
Contributors: arshdeveloper
Tags: assign related posts, auto search related posts
Requires at least: 3.5.0
Tested up to: 4.9.2
Stable tag: 4.9.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Assigns related posts to specific post.

== Description ==
This plugin helps to assign related posts to specific post. It supports auto search to assign related posts to specific post in admin.

**Shortcode** 
`[assign-related-posts]`

**Title**
`[assign-related-posts title="My Related Posts"]`

**Image Size**
`[assign-related-posts size="full"]`

Available Sizes: thumbnail, medium, large, full

<strong>Features</strong>

* Backend settings to select post types.
* Auto search functionality to assign posts. 
* Easy shortcode with optional attributes.
* Easy to customize

== Screenshots ==

1. screenshot-1.png
2. screenshot-2.png

== Frequently Asked Questions ==
= What is the shortcode? =
[assign-related-posts]

= How to put my own title of related posts in frontend? =
You can use extra attribute in shortcode eg: [assign-related-posts title="My Related Posts"]

= Will it work for custom post type? =
Yes, It will work for custom post type. You will have to select the post type for which you want to assign the related posts. You can do it by going through WP-Admin -> Settings -> Assign Related Post

== Changelog ==

= 1.0.1 =

* Update stylesheet.

== Upgrade Notice == 

* Update stylesheet.

== Installation ==
1. Upload the folder **"assign-related-posts"** to **"wp-content/plugins"**.

2. Activate the plugin through the **"Plugins"** menu in WordPress back end.

3. Go to **"Settings -> Assign Related Post"** to choose post type for which you want to assign the related posts.

4. Now, set your related posts while creating post in post screen.

5. Use shortcode.

Put below shortcode in your post editor or widget:
`
[assign-related-posts] 
`
You can also call shortcode in php template file as follow:
`
<?php echo do_shortcode('[assign-related-posts] '); ?>
`
