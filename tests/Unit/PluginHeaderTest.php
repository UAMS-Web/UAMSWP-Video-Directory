<?php

/**
 * The plugin header, which WordPress reads for the Plugins screen.
 *
 * @see uamswp-video-directory.php
 */

declare(strict_types=1);

/**
 * Reads one field from the header comment of the main plugin file.
 */
function plugin_header_field(string $field): ?string
{
    $file = new SplFileObject(__DIR__.'/../../uamswp-video-directory.php');

    while (! $file->eof()) {
        $line = $file->fgets();

        if (preg_match('/^'.preg_quote($field, '/').':\s*(\S+)/', $line, $matches) === 1) {
            return $matches[1];
        }
    }

    return null;
}

it('links the plugin site to the UAMS-Web repository', function (): void {
    expect(plugin_header_field('Plugin URI'))->toBe('https://github.com/UAMS-Web/UAMSWP-Video-Directory');
});
