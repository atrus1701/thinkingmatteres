<?php
/*
Plugin Name: Thinking Matters
Plugin URI: 
Description: 
Version: 1.1.0
Author: Crystal Barton
Author URI: https://www.linkedin.com/in/crystalbarton
Network: False
*/


if( !defined('THINKINGMATTERS') ):

/**
 * The full title of the Thinking Matters plugin.
 * @var  string
 */
define( 'THINKINGMATTERS', 'Thinking Matters' );


/**
 * True if debug is active, otherwise False.
 * @var  bool
 */
define( 'THINKINGMATTERS_DEBUG', false );


/**
 * The path to the plugin.
 * @var  string
 */
define( 'THINKINGMATTERS_PATH', __DIR__ );


/**
 * The url to the plugin.
 * @var  string
 */
define( 'THINKINGMATTERS_URL', plugins_url('', __FILE__) );

endif;


add_filter( 'show_admin_bar', '__return_true' );

// Setup plugin in VTT.
add_action( 'vtt-search-folders', 'thinkingmatters_add_variations_folder' );
		
add_filter( 'nhs-featured-story', 'thinkingmatters_get_featured_story', 99, 2 );
add_filter( 'nhs-listing-story', 'thinkingmatters_get_listing_story', 99, 2 );
add_filter( 'nhs-single-story', 'thinkingmatters_get_single_story', 99, 2 );



/**
 * Add the plugin folder the list of folders used by VTT to determine available variations.
 */
if( !function_exists('thinkingmatters_add_variations_folder') ):
function thinkingmatters_add_variations_folder()
{
	global $vtt_config;
	$vtt_config->add_search_folder( THINKINGMATTERS_PATH, 11 );
}
endif;


/**
 * 
 */
if( !function_exists('thinkingmatters_get_featured_story') ):
function thinkingmatters_get_featured_story( $story, $post )
{
	thinkingmatters_get_story_data( $story, $post );
	return $story;
}
endif;


/**
 * 
 */
if( !function_exists('thinkingmatters_get_listing_story') ):
function thinkingmatters_get_listing_story( $story, $post )
{
	thinkingmatters_get_story_data( $story, $post );
	return $story;
}
endif;


/**
 * 
 */
if( !function_exists('thinkingmatters_get_single_story') ):
function thinkingmatters_get_single_story( $story, $post )
{
	thinkingmatters_get_story_data( $story, $post );
	return $story;
}
endif;


/**
 * 
 */
if( !function_exists('thinkingmatters_get_image') ):
function thinkingmatters_get_image( $post_id )
{
	$thumbnail = get_post_meta( $post_id, 'thumbnail', true );
	if( $thumbnail ) return $thumbnail;
	
	return null;
}
endif;


/**
 * 
 */
if( !function_exists('thinkingmatters_sort_description') ):
function thinkingmatters_sort_description( $a, $b )
{
	$array = array( $a => -1, $b => 1 );
	if( array_key_exists('by_line', $array) ) return $array['by_line'];
	return 0;
}
endif;


/**
 * 
 */
if( !function_exists('thinkingmatters_get_story_data') ):
function thinkingmatters_get_story_data( &$story, $post )
{
	$story['image'] = thinkingmatters_get_image( $post->ID );
	uksort( $story['description'], 'thinkingmatters_sort_description' );
}
endif;

