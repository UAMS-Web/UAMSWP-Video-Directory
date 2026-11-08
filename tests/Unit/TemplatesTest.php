<?php

/**
 * The video templates, rendered with WordPress mocked and no theme loaded.
 *
 * Neither the Unit bootstrap nor any test defines `uams_content_class()`, the
 * function the `uams-2016` theme provides, so these run the fallback branch.
 *
 * @see templates/archive-video.php
 * @see templates/single-video.php
 */

declare(strict_types=1);

use Brain\Monkey\Functions;

dataset('video templates', [
    'archive' => ['archive-video.php'],
    'single' => ['single-video.php'],
]);

it('renders without the uams-2016 theme function', function (string $template): void {
    expect(function_exists('uams_content_class'))->toBeFalse();

    foreach (['get_header', 'get_template_part', 'get_sidebar', 'get_footer', 'next_posts_link'] as $function) {
        Functions\when($function)->justReturn(null);
    }
    Functions\when('have_posts')->justReturn(false);

    ob_start();
    require __DIR__.'/../../templates/'.$template;
    $html = (string) ob_get_clean();

    expect($html)->toContain("<div class=\"uams-content col-md-12\" role='main'>");
})->with('video templates');
