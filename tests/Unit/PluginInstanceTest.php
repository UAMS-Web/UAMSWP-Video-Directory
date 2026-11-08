<?php

/**
 * UAMSWP_Video_Directory::get_instance() and the hooks it sets up, with WordPress mocked.
 *
 * Each test starts with the private static instance cleared, so the first call
 * to `get_instance()` is the one that wires the hooks, as it is on a real request.
 *
 * @see includes/class-uamswp-video-directory.php
 */

declare(strict_types=1);

use function Brain\Monkey\Functions\when;

beforeEach(function (): void {
    (new ReflectionProperty(UAMSWP_Video_Directory::class, 'instance'))->setValue(null, null);
});

it('wires the post type, taxonomy and template hooks on the first call, in that order', function (): void {
    $registered = [];

    foreach (['add_action' => 'action', 'add_filter' => 'filter'] as $function => $kind) {
        when($function)->alias(
            static function (string $hook, array $callback) use (&$registered, $kind): bool {
                [$object, $method] = $callback;
                assert(is_object($object) && is_string($method));
                $registered[] = $kind.':'.$hook.':'.$object::class.'::'.$method;

                return true;
            }
        );
    }

    $instance = UAMSWP_Video_Directory::get_instance();

    expect($instance)->toBeInstanceOf(UAMSWP_Video_Directory::class)
        ->and($registered)->toBe([
            'action:init:UAMSWP_Video_Directory_Post_Type_Video::custom_post_types',
            'action:init:UAMSWP_Video_Directory_Custom_Taxonomies::init_taxonomies',
            'filter:single_template:UAMSWP_Video_Directory_Custom_Templates::video_single',
            'filter:template_include:UAMSWP_Video_Directory_Custom_Templates::video_archive',
        ]);
});

it('returns the same instance on every call and wires the hooks only once', function (): void {
    $registrations = 0;

    foreach (['add_action', 'add_filter'] as $function) {
        when($function)->alias(static function () use (&$registrations): bool {
            $registrations++;

            return true;
        });
    }

    $first = UAMSWP_Video_Directory::get_instance();
    $afterFirst = $registrations;
    $second = UAMSWP_Video_Directory::get_instance();

    expect($second)->toBe($first)
        ->and($afterFirst)->toBe(4)
        ->and($registrations)->toBe(4);
});
