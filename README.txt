=== Super Simple Changes ===
Contributors: scottwyden
Donate link: http://scottwyden.com
Tags: comments,images,compression,pings,featured image,image,photo
Requires at least: 4.0
Tested up to: 5.0
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Implement some common simple modifications to your WordPress photo website.

== Description ==

This plugin has no options for a very good reason.  It's designed to do some very simple tasks, that many photographers have asked me about.  So I put them together in a "super simple plugin" called Super Simple Changes.

This plugin will:

- Add image sizes for full width at a ratio and also cropped.
- Set JPG compression to 100% so WordPress doesn't compress already compressed uploads.
- Stop self pings when a new blog post is published linking internally to another post.
- Automatically add a Featured Image to a post if none is already set when hitting Save Draft or Public.
- Add a Featured Image column to the Posts Table
- Added rel="nofollow" to any links in a comment (SEO abuse prevention)

Learn more about me on my <a href="https://scottwyden.com/" target="_blank"> photo website</a>.

== Installation ==

Simply install and sit back.  No configuration required.

1. Upload `super-simple-changes.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Did you code this yourself? =

Yes and no.  I used a plugin boilerplate generator to create the core files.  I then used snippets of functions sources from public blogs, each of which are credited within the plugin's code.  So I didn't write the code itself, but I did assemble it in one "super simple plugin".

= Will you be adding more to the plugin? =

Over time yes.  I will only add frequent requests to this.

= I'm not entirely sure why you need the full size image options either? Is this so you can set large size for sidebars and then still have full size for pages without sidebars? How does the plugin know what width is required for "full" size? And why do you need the cropped / uncropped options? =

It determines the full size based on the content area your theme provides. So instead of picking only small, media, large or full size, you can have it automatically scale it to the size that fits your content area. From what I understand the function only works if you offer cropped and uncropped are both there.

= What determines which image will be set as the Featured Image? =

The first image inserted into the post should become the Featured Image.  However, we suggest only using the automated as a safeguard if you forget to manually create one.  The image also must be "attached" to the post.  It will not automatically set featured images when included images are unattached, or attached to another post.  This will also not use external images.

= How can I make sure it finds an image? =

Upload and add the image to the post from within the post itself.  Do not upload from the Media Library tab.

= What determines how the Featured Image is used? =

Your theme does.  Please contact your theme developer with any questions on its Featured Image usage.

== Screenshots ==

1. Insert a photo to fit the content area using the photo's original aspect ratio with or without cropping.

2. Your Posts table will now show a Featured Image column

== Changelog ==

= 1.0.5 - 02.08.2015 =
- Removed: EXIF in Media Library due to random error (will potentially add back later)

= 1.0.4 - 01.02.2015 =
- Added: automatically create Featured Image for a post
- Added: Display Featured Image in Post table
- Added: nofollow for comment reply links
- Added: Smart excerpts removing shortcodes

= 1.0.3 - 12.18.2014 =
- Fixed: accidental removal of no self pings

= 1.0.2 - 12.18.2014 =
- Added: screenshot and credits
- Added: EXIF to Media Library Table

= 1.0.1 - 12.18.2014 =
- Fixed: Minor change to readme and plugin files

= 1.0 - 12.18.2014 =
- First Release