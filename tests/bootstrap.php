<?php

/**
 * Unit bootstrap.
 *
 * The Unit suite runs with no WordPress: WordPress functions are mocked per
 * test with Brain Monkey.
 */

declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';

/*
 * Patchwork first: it can only redefine functions declared in files loaded
 * after it.
 */
require_once __DIR__.'/../vendor/antecedent/patchwork/Patchwork.php';

if (! defined('ABSPATH')) {
    define('ABSPATH', sys_get_temp_dir().'/uamswp-video-directory-tests-no-wordpress/');
}

/*
 * Load the files that define classes, never the main plugin file: it registers
 * hooks at file scope.
 */
require_once __DIR__.'/../includes/class-custom-taxonomies.php';

// cspell:ignore ABSPATH
