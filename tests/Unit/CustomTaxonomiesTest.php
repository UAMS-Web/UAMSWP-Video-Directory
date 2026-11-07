<?php

/**
 * UAMSWP_Video_Directory_Custom_Taxonomies, with WordPress mocked.
 *
 * @see includes/class-custom-taxonomies.php
 */

declare(strict_types=1);

use Brain\Monkey\Actions;
use Brain\Monkey\Functions;

it('registers its taxonomies on the init action', function (): void {
    $taxonomies = new UAMSWP_Video_Directory_Custom_Taxonomies();

    Actions\expectAdded('init')
        ->once()
        ->with([$taxonomies, 'init_taxonomies']);

    $taxonomies->init();
});

it('registers the video categories taxonomy for the video post type', function (): void {
    Functions\expect('register_taxonomy')
        ->once()
        ->with('video_categories', 'video', Mockery::on(
            static fn (array $args): bool => $args['hierarchical'] === true
                && $args['labels']['name'] === 'Video Categories'
        ));

    (new UAMSWP_Video_Directory_Custom_Taxonomies())->init_taxonomies();
});
