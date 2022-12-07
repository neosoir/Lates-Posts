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

	$args = [
		'posts_per_page' 	=> 	$attributes['numberOfPosts'],
		'post_status'		=>	'publish',
		'order'				=>	$attributes['order'],
		'orderby'			=>	$attributes['orderBy']
	];
	
	if ( isset($attributes['categories']) ) 
		$args['category__in'] = array_column($attributes['categories'], 'id');

	$recient_posts = get_posts($args);

	$posts = '<ul ' . get_block_wrapper_attributes() . '>';

	foreach ($recient_posts as $key => $post) {

		$title 		= get_the_title($post);
		$title 		= $title ? $title : __('(No title)', 'latest-posts');
		$permalink 	= get_the_permalink($post);
		$excerpt 	= get_the_excerpt($post);
		
		$posts .= '<li>';

			if ( ( $attributes['displayFeaturedImage'] ) && ( has_post_thumbnail( $post ) ) )
				$posts .= get_the_post_thumbnail( $post, 'large' );

			$posts .= '<h5><a href="' . esc_url( $permalink ) . '">' . $title . '</a></h5>';
			$posts .= '<time datetime="' . esc_attr( get_the_date('c', $post) ) .  '" >' . esc_html( get_the_date('', $post) ) . '</time>';

			if ( ! empty( $excerpt ) )
				$posts .= '<p>' . $excerpt . '</p>';


		$posts .= '</li>';
	}

	$posts .= '</ul>';

	return $posts;

	/* echo "<pre>";
	var_dump( $recient_posts );
	echo "</pre>"; */

}
