<?php

/**
 * UAMSWP_Video_Directory_Custom_Templates, with WordPress mocked.
 *
 * The plugin serves its own template only when the active theme has none, so
 * every path through the two routing methods is pinned: a theme template wins,
 * a template for any other post type or archive is left alone, and the plugin's
 * file is returned only for a video with no theme template.
 *
 * @see includes/class-custom-templates.php
 */

declare(strict_types=1);

use Brain\Monkey\Functions;

use function Brain\Monkey\Actions\expectAdded;
use function Brain\Monkey\Filters\expectAdded as expectFilterAdded;
use function Brain\Monkey\Functions\when;

require_once __DIR__.'/../../includes/class-custom-templates.php';

function plugin_template(string $file): string
{
    return dirname(__DIR__, 2).'/templates/'.$file;
}

beforeEach(function (): void {
    when('plugin_dir_path')->alias(
        static fn (string $file): string => rtrim(dirname($file), '/'.chr(92)).'/'
    );
});

afterEach(function (): void {
    unset($GLOBALS['post']);
});

it('registers its two template routes', function (): void {
    $templates = new UAMSWP_Video_Directory_Custom_Templates;

    expectFilterAdded('single_template')
        ->once()
        ->with([$templates, 'video_single']);
    expectAdded('template_include')
        ->once()
        ->with([$templates, 'video_archive']);

    $templates->init();
});

it('serves the plugin single template for a video the theme has no template for', function (): void {
    $GLOBALS['post'] = (object) ['post_type' => 'video'];
    Functions\expect('locate_template')->once()->with('single-video.php')->andReturn('');

    expect((new UAMSWP_Video_Directory_Custom_Templates)->video_single('/theme/single.php'))
        ->toBe(plugin_template('single-video.php'));
});

it('keeps the given single template when the theme has its own video template', function (): void {
    $GLOBALS['post'] = (object) ['post_type' => 'video'];
    Functions\expect('locate_template')->once()->with('single-video.php')->andReturn('/theme/single-video.php');

    expect((new UAMSWP_Video_Directory_Custom_Templates)->video_single('/theme/single.php'))
        ->toBe('/theme/single.php');
});

it('keeps the given single template for any other post type', function (string $found): void {
    $GLOBALS['post'] = (object) ['post_type' => 'page'];
    Functions\expect('locate_template')->once()->with('single-video.php')->andReturn($found);

    expect((new UAMSWP_Video_Directory_Custom_Templates)->video_single('/theme/single.php'))
        ->toBe('/theme/single.php');
})->with(['no theme template' => [''], 'a theme template' => ['/theme/single-video.php']]);

it('serves the plugin archive template for the video archive the theme has no template for', function (): void {
    Functions\expect('is_post_type_archive')->once()->with('video')->andReturn(true);
    Functions\expect('locate_template')->once()->with(['archive-video.php'], false)->andReturn('');

    expect((new UAMSWP_Video_Directory_Custom_Templates)->video_archive('/theme/archive.php'))
        ->toBe(plugin_template('archive-video.php'));
});

it('keeps the given template when the theme has its own video archive template', function (): void {
    Functions\expect('is_post_type_archive')->once()->with('video')->andReturn(true);
    Functions\expect('locate_template')->once()->with(['archive-video.php'], false)->andReturn('/theme/archive-video.php');

    expect((new UAMSWP_Video_Directory_Custom_Templates)->video_archive('/theme/archive.php'))
        ->toBe('/theme/archive.php');
});

it('keeps the given template outside the video archive without asking the theme', function (): void {
    Functions\expect('is_post_type_archive')->once()->with('video')->andReturn(false);
    Functions\expect('locate_template')->never();

    expect((new UAMSWP_Video_Directory_Custom_Templates)->video_archive('/theme/archive.php'))
        ->toBe('/theme/archive.php');
});
