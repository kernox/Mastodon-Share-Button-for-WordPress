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

add_action('init', 'mastodon_share_button_init');

add_filter( 'the_content', 'mastodon_share_button_add_icon' );


function mastodon_share_button_init() {
	wp_enqueue_script( 'jquery');
	wp_enqueue_script('mastodonjs', plugin_dir_url( __FILE__ ).'mastodon.js');
	wp_enqueue_script('corejs', plugin_dir_url( __FILE__ ).'core.js');

	wp_enqueue_style('mastoshare_button', plugin_dir_url( __FILE__ ).'style.css');
}

function mastodon_share_button_add_icon($content) {

	$post = get_post();

	$plugin_url = urlencode(plugin_dir_url(__FILE__));
	$message = urlencode($post->post_title . ' ' .get_permalink($post->ID));
	$href = "javascript:msb_action('$plugin_url', '$message')";

	return '<a title="Share on Mastodon" class="msb_icon" href="'.$href.'"></a>'.
	$content;
}