<?php

/**
 * @link              http://scottwyden.com
 * @since             1.0.0
 * @package           Super_Simple_Changes
 *
 * @wordpress-plugin
 * Plugin Name:       Super Simple Changes
 * Plugin URI:        http://scottwyden.com/
 * Description:       Implement some common simple modifications to your WordPress photo website.
 * Version:           1.0.5
 * Author:            Scott Wyden Kivowitz
 * Author URI:        http://scottwyden.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       super-simple-changes
 */


// Add Image Sizes including full width with crop and without
// Credit: http://wpshout.com/adding-using-custom-image-sizes-wordpress-guide-best-thing-ever/
add_image_size( 'full-width-ratio-large', 800, 9999 );
add_image_size( 'full-width-crop-large', 800, 500, true );
function custom_in_post_images( $args )
{ $custom_images = array('full-width-ratio' => 'Full Width Ratio', 'full-width-crop' => 'Full Width Crop','full-width-ratio-large' => 'Full Width Ratio Large', 'full-width-crop-large' => 'Full Width Crop Large'); return array_merge( $args, $custom_images ); }
add_filter( 'image_size_names_choose', 'custom_in_post_images' );

// Prevent JPG Compression
add_filter( 'jpeg_quality', 'ssc_return_value' );
function ssc_return_value() {
    return 100;
}

//No Self Pings
// Credit: http://wp-snippets.com/disable-self-trackbacks
function disable_self_ping( &$links ) {
    foreach ( $links as $l => $link )
        if ( 0 === strpos( $link, get_option( 'home' ) ) )
            unset($links[$l]);
}
add_action( 'pre_ping', 'disable_self_ping' );

// EXIF Columns in Media Library Table View
// Credit: http://wp-snippets.com/disable-self-trackbacks & https://wordpress.org/plugins/exif-columns/ &
/*add_filter('manage_media_columns', 'posts_columns_attachment_exif', 1);
add_action('manage_media_custom_column', 'posts_custom_columns_attachment_exif', 1, 2);

function posts_columns_attachment_exif($defaults){
    $defaults['wps_post_attachments_exif'] = __('EXIF');
    return $defaults;
}
function posts_custom_columns_attachment_exif($column_name, $id){
    if($column_name === 'wps_post_attachments_exif'){
        $meta = wp_get_attachment_metadata($id);

        if($meta[image_meta][camera] != ''){
            echo "CR:  ".$meta[image_meta][credit]."<hr />";
            echo "CAM:  ".$meta[image_meta][camera]."<hr />";
            echo "FL:  ".$meta[image_meta][focal_length]."<hr />";
            echo "AP:  ".$meta[image_meta][aperture]."<hr />";
            echo "ISO:  ".$meta[image_meta][iso]."<hr />";
            if (($meta[image_meta][shutter_speed] >= 1) || ($meta[image_meta][shutter_speed] == 0)) {
                echo "SS:  ".$meta[image_meta][shutter_speed]." sec" . "<hr />";
            }
            elseif ($meta[image_meta][shutter_speed] > 0) {
                echo "SS:  1/".(1 / $meta[image_meta][shutter_speed])." sec" . "<hr />";
            }

            echo "DATE:  ".date('Y/m/d H:i:s', $meta[image_meta][created_timestamp])."<hr />";
            echo "C:  ".$meta[image_meta][copyright];
        }
    }
}
*/

// Add Featured Image Column to Posts Table
// Credit: http://wpsnipp.com/index.php/functions-php/updated-add-featured-thumbnail-to-admin-post-page-columns/
if (function_exists( 'add_theme_support' )){
    add_filter('manage_posts_columns', 'posts_columns', 5);
    add_action('manage_posts_custom_column', 'posts_custom_columns', 5, 2);
    add_filter('manage_pages_columns', 'posts_columns', 5);
    add_action('manage_pages_custom_column', 'posts_custom_columns', 5, 2);
}
function posts_columns($defaults){
    $defaults['wps_post_thumbs'] = __('Featured Image');
    return $defaults;
}
function posts_custom_columns($column_name, $id){
    if($column_name === 'wps_post_thumbs'){
        echo the_post_thumbnail( array(125,80) );
    }
}

// Create Featured Image Automatically if None is Set
// Credit: http://www.paulund.co.uk/automatically-set-post-featured-image
if ( function_exists( 'add_theme_support' ) ) {

    add_theme_support( 'post-thumbnails' );

    function auto_feature_img($post) {

        $already_has_thumb = has_post_thumbnail();

        if (!$already_has_thumb)  {

            $attached_image = get_children( "order=ASC&post_parent=$post->ID&post_type=attachment&post_mime_type=image&numberposts=1" );

            if ($attached_image) {

                $attachment_values = array_values($attached_image);
                $first_child_image = $attachment_values[0];

                add_post_meta($post->ID, '_thumbnail_id', $first_child_image->ID, true);

            }


        }
    }

    add_action('the_post', 'auto_feature_img');

    // hooks added to set the thumbnail when publishing too
    add_action('new_to_publish', 'auto_feature_img');
    add_action('draft_to_publish', 'auto_feature_img');
    add_action('pending_to_publish', 'auto_feature_img');
    add_action('future_to_publish', 'auto_feature_img');

}

// Add nofollow to comment reply links
// Credit: http://www.paulund.co.uk/add-relnofollow-to-wordpress-comment-reply-links
function add_nofollow_to_reply_link( $link ) {
    return str_replace( '")\'>', '")\' rel=\'nofollow\'>', $link );
}

add_filter( 'comment_reply_link', 'add_nofollow_to_reply_link' );

// Smart Excerpts to remove shortcodes
// Credit: https://gist.github.com/mathetos/30d539fda8a195a90087
$yoastdesc = get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true);
$excerptlength = get_theme_mod('excerpt_length', 25);
$excerpt = get_the_excerpt();
$content = get_the_content();
$screenreader = '<a href="' . get_permalink() . '"><span class="screen-reader-text">' . get_the_title( ) . '</span>Read More &hellip;</a>';

if(!empty($yoastdesc)) {
    $trimyoast = wp_trim_words($yoastdesc, $excerptlength, $screenreader);
    echo $trimyoast;
} elseif(has_excerpt() == true) {
    $trimexcerpt = wp_trim_words( $excerpt , $excerptlength, $screenreader  );
    echo strip_shortcodes($trimexcerpt);
} else {
    $trimmed_content = wp_trim_words( $content, $excerptlength, $screenreader );
    echo strip_shortcodes($trimmed_content);
}

?>