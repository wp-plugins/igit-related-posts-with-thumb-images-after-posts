<?php
/*
Plugin Name: IGIT Related Post With Thumb
Version:     4.3
Plugin URI:  http://www.hackingethics.com/blog/wordpress-plugins/igit-related-posts-with-thumb-image-after-posts/
Description: Show related posts with thumb image after Posts. Ajax Base Admin options.Options for dynamic height and width of Thumb.Plugin By <a href="http://www.hackingethics.com"><strong>Hacking Ethics</strong></a>.You can <a href="options-general.php?page=igit-rpwt">Configure...</a> it from <a href="options-general.php?page=igit-rpwt">Here.
Author:      Ankur Gandhi
Author URI:  http://www.hackingethics.com/


License: GNU General Public License (GPL), v3 (or newer)
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Tags:Related posts, related post with images
Copyright (c) 2010 - 2012 Ankur Gandhi. All rights reserved.
 
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/


if (!defined('ABSPATH')) die("Aren't you supposed to come here via WP-Admin?");
if ( ! defined( 'WP_CONTENT_URL' ) )
      define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
      define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
if ( ! defined( 'WP_PLUGIN_URL' ) )
      define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'IGIT_RPWT_CSS_URL' ) )
      define( 'IGIT_RPWT_CSS_URL', WP_CONTENT_URL. '/plugins/igit-rpwt/css' );
require_once(dirname(__FILE__).'/inc/igit_init.php');
require_once(dirname(__FILE__).'/inc/admin_core.php');
require_once(dirname(__FILE__).'/inc/core.php');
if(is_admin())
{
	global $igit_rpwt;
	add_action('init', create_function('', 'wp_enqueue_script("jquery");')); // Make sure jQuery is always loaded
	wp_enqueue_script('jquery-form');   
	wp_enqueue_script('jscolor','/wp-content/plugins/igit-related-posts-with-thumb-images-after-posts/jsscripts/jscolor.js'); 
	wp_enqueue_style('my-style', '/wp-content/plugins/igit-related-posts-with-thumb-images-after-posts/css/igit_style.css');
	add_action('admin_head', 'igit_action_javascript');
	add_action('wp_ajax_igit_save_ajax', 'igit_action_callback');
	add_action('admin_menu', 'igit_plugin_menu'); // for admin menu inside this after clicking on plugin file function will be called.
}
else
{
	$igit_rpwt_lat = get_option('igit_rpwt');
	if($igit_rpwt_lat)
	{
		$igit_rpwt = $igit_rpwt_lat;
	}
	add_action('wp_head', 'igit_add_css_style');
	if($igit_rpwt['auto_show'] == "1")
	{
		add_filter('the_content', 'igit_total_content');
	}
}
?>