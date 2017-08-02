<?php
/**
 * Plugin Name: Mastodon Share Button
 * Description: A share button for users/visitors of your blog/website.
 * Version: 0.1
 * Author: Hellexis
 * Author URI: https://github.com/kernox
 * Text Domain: mastodon-share-button
 * Domain Path: /languages
 */

add_action( 'init', 'mastodon_share_button_init' );
add_filter( 'the_content', 'mastodon_share_button_add_icon' );
add_filter('template_include', 'mastodon_share_button_feed_page_include');


function mastodon_share_button_feed_page_include($template) {
	global $wp;
	
	if ( 'mastodon-share-feed' == $wp->request ) {
		load_template( plugin_dir_path(__FILE__) . '/feed.php' );
	} else {
		load_template($template);
	}
}

/**
 * Mastodon_share_button_init
 *
 * @return void
 */
function mastodon_share_button_init() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'mastodonjs', plugin_dir_url( __FILE__ ) . 'js/mastodon.js' );
	wp_enqueue_script( 'corejs', plugin_dir_url( __FILE__ ) . 'js/core.js' );

	wp_enqueue_style( 'mastoshare_button', plugin_dir_url( __FILE__ ) . 'css/style.css' );

  	add_rewrite_rule(
    	'mastodon-share-feed/?$',
		'index.php',
		'top'
  	);

	flush_rewrite_rules( true );
}

/**
 * Mastodon_share_button_add_icon
 *
 * @param string $content The current content.
 * @return string
 */
function mastodon_share_button_add_icon( $content ) {

	$post = get_post();

	$plugin_url = urlencode( plugin_dir_url( __FILE__ ) );
	$message = urlencode( $post->post_title . ' ' . get_permalink( $post->ID ) );
	$href = "javascript:msb_action('".get_site_url()."', '$message')";

	return '<a title="' . esc_attr__( 'Share on Mastodon', 'mastodon-share-button' ) . '" class="msb_icon" href="' . $href . '"></a>' .
	$content;
}