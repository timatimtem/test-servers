<?php

show_admin_bar(false);



/**
 * Disable the emoji's
 */
function disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
    add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );

/**
 * Filter function used to remove the tinymce emoji plugin.
 *
 * @param array $plugins
 * @return array Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
        return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
        return array();
    }
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param array $urls URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array Difference betwen the two arrays.
 */
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
    if ( 'dns-prefetch' == $relation_type ) {
        /** This filter is documented in wp-includes/formatting.php */
        $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

        $urls = array_diff( $urls, array( $emoji_svg_url ) );
    }

    return $urls;
}

// REMOVE EMOJI ICONS
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');





add_action( 'after_theme_support', 'remove_feed' );

function remove_feed() {
    remove_theme_support( 'automatic-feed-links' );
}

// Use what works best for your website
add_action('init', 'my_head_cleanup');

function my_head_cleanup() {
  // Category Feeds
  remove_action( 'wp_head', 'feed_links_extra', 3 );

  // Post and Comment Feeds
  remove_action( 'wp_head', 'feed_links', 2 );

  // EditURI link
  remove_action( 'wp_head','rsd_link' );

  // Windows Live Writer
  remove_action( 'wp_head','wlwmanifest_link' );

  // index link
  remove_action( 'wp_head','index_rel_link' );

  // previous link
  remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );

  // start link
  remove_action( 'wp_head', 'start_post_rel_link', 10,0 );

  // Links for Adjacent Posts
  remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

  // WP version
   remove_action( 'wp_head', 'wp_generator' );
}



if( ! function_exists( 'fix_no_editor_on_posts_page' ) ) {

    function fix_no_editor_on_posts_page( $post_type, $post ) {
        if( isset( $post ) && $post->ID != get_option('page_for_posts') ) {
            return;
        }

        remove_action( 'edit_form_after_title', '_wp_posts_page_notice' );
        add_post_type_support( 'page', 'editor' );
    }

    add_action( 'add_meta_boxes', 'fix_no_editor_on_posts_page', 0, 2 );

}


//
//// Removes from admin menu
//add_action( 'admin_menu', 'my_remove_admin_menus' );
//function my_remove_admin_menus() {
//    remove_menu_page( 'edit-comments.php' );
//}
//// Removes from post and pages
//add_action('init', 'remove_comment_support', 100);
//
//function remove_comment_support() {
//    remove_post_type_support( 'post', 'comments' );
//    remove_post_type_support( 'page', 'comments' );
//}
//// Removes from admin bar
//function mytheme_admin_bar_render() {
//    global $wp_admin_bar;
//    $wp_admin_bar->remove_menu('comments');
//}
//add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );
//



remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );


function my_deregister_scripts(){
    wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'my_deregister_scripts' );


register_nav_menus(array(
//    'primary' => __('Primary Menu'),
    'top-navigation' => __('Top Navigation'),


    'page-not-found' => __("404 menu")
));

