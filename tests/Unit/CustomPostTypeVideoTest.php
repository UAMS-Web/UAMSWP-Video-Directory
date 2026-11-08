<?php

/**
 * UAMSWP_Video_Directory_Post_Type_Video, with WordPress mocked.
 *
 * The post type arguments are pinned whole. Each key changes how the video
 * post type behaves in WordPress (who can see it, what the editor offers, where
 * it appears), so a dropped or flipped entry is a behavior change, not noise.
 *
 * @see includes/class-custom-post-type-video.php
 */

declare(strict_types=1);

use Brain\Monkey\Functions;

use function Brain\Monkey\Actions\expectAdded;

it('registers the video post type on the init action', function (): void {
    $postType = new UAMSWP_Video_Directory_Post_Type_Video;

    expectAdded('init')
        ->once()
        ->with([$postType, 'custom_post_types']);

    $postType->init();
});

it('registers the video post type with exactly these arguments', function (): void {
    $captured = [];

    Functions\expect('register_post_type')
        ->once()
        ->with('video', Mockery::type('array'))
        ->andReturnUsing(static function (string $name, array $args) use (&$captured): void {
            $captured = $args;
        });

    (new UAMSWP_Video_Directory_Post_Type_Video)->custom_post_types();

    expect($captured)->toBe([
        'labels' => [
            'name' => 'Videos',
            'singular_name' => 'Video',
            'menu_name' => 'Videos',
        ],
        'public' => true,
        'show_ui' => true,
        'show_in_admin_bar' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-video-alt3',
        'hierarchical' => false,
        'has_archive' => true,
        'taxonomies' => ['video_categories'],
        'supports' => ['title', 'editor', 'custom-fields'],
        'capability_type' => 'post',
        'map_meta_cap' => true,
    ]);
});
