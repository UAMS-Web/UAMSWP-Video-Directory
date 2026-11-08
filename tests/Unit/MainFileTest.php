<?php

/**
 * The main plugin file, loaded with WordPress mocked.
 *
 * The file declares the `UAMSWP_Video_Directory()` function, so it can be
 * loaded once per process: everything about it is asserted in one test.
 * Loading it with `WPINC` defined is the path WordPress takes; with `WPINC`
 * undefined the file calls `exit`, which no test can survive in-process.
 *
 * @see uamswp-video-directory.php
 */

declare(strict_types=1);

use Brain\Monkey\Functions;

use function Brain\Monkey\Actions\expectAdded;
use function Brain\Monkey\Functions\when;

it('registers the plugin start-up, activation and deactivation hooks when WordPress loads it', function (): void {
    $file = (string) realpath(__DIR__.'/../../uamswp-video-directory.php');

    defined('WPINC') || define('WPINC', 'wp-includes');

    expectAdded('after_setup_theme')->once()->with('UAMSWP_Video_Directory');
    Functions\expect('register_activation_hook')->once()->with($file, ['UAMSWP_Video_Directory', 'activate']);
    Functions\expect('register_deactivation_hook')->once()->with($file, ['UAMSWP_Video_Directory', 'deactivate']);

    expect(function_exists('UAMSWP_Video_Directory'))->toBeFalse();

    require $file;

    expect(function_exists('UAMSWP_Video_Directory'))->toBeTrue();

    (new ReflectionProperty(UAMSWP_Video_Directory::class, 'instance'))->setValue(null, null);
    when('add_action')->justReturn(true);
    when('add_filter')->justReturn(true);

    expect(UAMSWP_Video_Directory())->toBe(UAMSWP_Video_Directory::get_instance());
});
