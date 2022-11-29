<?php
/**
 * Plugin Name:       Block Latest Posts
 * Description:       Display and filter latest posts.
 * Requires at least: 5.7
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Neos Lab
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       latest-posts
 *
 * @package           blocks-course
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/block-editor/tutorials/block-tutorial/writing-your-first-block-type/
 */
add_action( 'init', 'blocks_course_latest_posts_block_init' );

function blocks_course_latest_posts_block_init() {
	register_block_type_from_metadata( 
		__DIR__, 
		['render_callback' => 'blocks_course_render_latest_posts_block'] 
	);
}

function blocks_course_render_latest_posts_block( $attributes ) {

	var_dump( $attributes );
	return 'Dynamic Contend';
}
