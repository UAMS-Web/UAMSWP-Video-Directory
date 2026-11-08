<?php

/**
 * UAMSWP_Video_Directory_Custom_Taxonomies, with WordPress mocked.
 *
 * @see includes/class-custom-taxonomies.php
 */

declare(strict_types=1);

use function Brain\Monkey\Actions\expectAdded;
use function Brain\Monkey\Functions\expect;

it('registers its taxonomies on the init action', function (): void {
    $taxonomies = new UAMSWP_Video_Directory_Custom_Taxonomies;

    expectAdded('init')
        ->once()
        ->with([$taxonomies, 'init_taxonomies']);

    $taxonomies->init();
});

it('registers the video categories taxonomy for the video post type', function (): void {
    expect('register_taxonomy')
        ->once()
        ->with('video_categories', 'video', Mockery::on(
            static fn (array $args): bool => $args['hierarchical'] === true
                && $args['labels']['name'] === 'Video Categories'
        ));

    (new UAMSWP_Video_Directory_Custom_Taxonomies)->init_taxonomies();
});
