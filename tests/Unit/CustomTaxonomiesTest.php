<?php

/**
 * UAMSWP_Video_Directory_Custom_Taxonomies, with WordPress mocked.
 *
 * @see includes/class-custom-taxonomies.php
 */

declare(strict_types=1);

use Brain\Monkey\Functions;

use function Brain\Monkey\Actions\expectAdded;

it('registers its taxonomies on the init action', function (): void {
    $taxonomies = new UAMSWP_Video_Directory_Custom_Taxonomies;

    expectAdded('init')
        ->once()
        ->with([$taxonomies, 'init_taxonomies']);

    $taxonomies->init();
});

it('registers the video categories taxonomy for the video post type', function (): void {
    Functions\expect('register_taxonomy')
        ->once()
        ->with('video_categories', 'video', Mockery::on(
            static fn (array $args): bool => $args['hierarchical'] === true
                && is_array($args['labels'])
                && ($args['labels']['name'] ?? null) === 'Video Categories'
        ));

    (new UAMSWP_Video_Directory_Custom_Taxonomies)->init_taxonomies();
});

it('registers the video categories taxonomy with exactly these arguments', function (): void {
    $captured = [];

    Functions\expect('register_taxonomy')
        ->once()
        ->with('video_categories', 'video', Mockery::type('array'))
        ->andReturnUsing(static function (string $name, string $postType, array $args) use (&$captured): void {
            $captured = $args;
        });

    (new UAMSWP_Video_Directory_Custom_Taxonomies)->init_taxonomies();

    expect($captured)->toBe([
        'hierarchical' => true,
        'labels' => [
            'name' => 'Video Categories',
            'singular_name' => 'Video Category',
            'edit_item' => 'Edit Video Category',
            'update_item' => 'Update Video Category',
            'add_new_item' => 'Add New Video Category',
            'menu_name' => 'Video Categories',
        ],
        'public' => true,
        'show_in_rest' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'capabilities' => [
            'assign_terms' => 'edit_posts',
        ],
    ]);
});
