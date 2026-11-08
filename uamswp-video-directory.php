<?php

declare(strict_types=1);
/*
Plugin Name: UAMSWP Video Directory
Version: 1.0.0
Requires PHP: 8.2
Description: A plugin that is used to create video post type
Author: uams, toddmckee
Author URI: https://www.uams.edu/
Plugin URI: https://github.com/washingtonstateuniversity/UAMSWP-Video-Directory
Text Domain: uams-video-directory
Domain Path: /languages
*/

// If this file is called directly, abort.
if (! defined('WPINC')) {
    exit;
}

// The core plugin class.
require __DIR__.'/includes/class-uamswp-video-directory.php';
add_action('after_setup_theme', 'UAMSWP_Video_Directory');
/**
 * Start things up.
 */
function UAMSWP_Video_Directory(): UAMSWP_Video_Directory
{
    return UAMSWP_Video_Directory::get_instance();
}
