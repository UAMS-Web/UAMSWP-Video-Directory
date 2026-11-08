<?php

/**
 * UAMSWP_Video_Directory activation and deactivation, with WordPress mocked.
 *
 * @see includes/class-uamswp-video-directory.php
 */

declare(strict_types=1);

use Brain\Monkey\Functions;

it('registers the post type and taxonomy before flushing on activation', function (): void {
    $order = [];

    Functions\expect('register_post_type')
        ->once()
        ->with('video', Mockery::type('array'))
        ->andReturnUsing(static function () use (&$order): void {
            $order[] = 'post_type';
        });
    Functions\expect('register_taxonomy')
        ->once()
        ->with('video_categories', 'video', Mockery::type('array'))
        ->andReturnUsing(static function () use (&$order): void {
            $order[] = 'taxonomy';
        });
    Functions\expect('flush_rewrite_rules')
        ->once()
        ->andReturnUsing(static function () use (&$order): void {
            $order[] = 'flush';
        });

    UAMSWP_Video_Directory::activate();

    expect($order)->toBe(['post_type', 'taxonomy', 'flush']);
});

it('unregisters the post type and taxonomy before flushing on deactivation', function (): void {
    $order = [];

    Functions\expect('unregister_taxonomy')
        ->once()
        ->with('video_categories')
        ->andReturnUsing(static function () use (&$order): void {
            $order[] = 'taxonomy';
        });
    Functions\expect('unregister_post_type')
        ->once()
        ->with('video')
        ->andReturnUsing(static function () use (&$order): void {
            $order[] = 'post_type';
        });
    Functions\expect('flush_rewrite_rules')
        ->once()
        ->andReturnUsing(static function () use (&$order): void {
            $order[] = 'flush';
        });

    UAMSWP_Video_Directory::deactivate();

    expect($order)->toBe(['taxonomy', 'post_type', 'flush']);
});
