<?php

/**
 * What the video templates output and call, pinned with WordPress mocked.
 *
 * These tests describe the templates as they behave today, so that a change to
 * how they are analyzed or formatted (Rector, PHPStan, Pint) cannot alter the
 * rendered page unnoticed. Whitespace is collapsed before comparing: a
 * formatter may move it, and none of it is visible in a browser. Everything
 * else (tags, attributes, text, order, and the arguments passed to WordPress)
 * is exact.
 *
 * `uams_content_class()` stays undefined here, as in TemplatesTest, so the
 * fallback markup is what the main div carries.
 *
 * @see templates/archive-video.php
 * @see templates/single-video.php
 */

declare(strict_types=1);

use function Brain\Monkey\Functions\when;

/**
 * Where the mocked WordPress loop stands: -1 before `the_post()` is first called.
 */
final class VideoLoopCursor
{
    public int $index = -1;
}

/**
 * Renders a template through a mocked WordPress loop.
 *
 * @param  list<array{id: int, title: string, link: string, excerpt: string, content: string, terms: list<object>|false}>  $posts
 * @return array{html: string, calls: list<string>}
 */
function render_video_template(string $template, array $posts): array
{
    $calls = [];
    $cursor = new VideoLoopCursor;
    $current = (static fn (): array => $posts[$cursor->index] ?? throw new LogicException('A template read the current post outside the loop.'));

    when('get_header')->alias(static function () use (&$calls): void {
        $calls[] = 'get_header';
    });
    when('get_template_part')->alias(static function (string $slug, ?string $name = null) use (&$calls): void {
        $calls[] = 'get_template_part:'.$slug.($name === null ? '' : ','.$name);
    });
    when('get_sidebar')->alias(static function () use (&$calls): void {
        $calls[] = 'get_sidebar';
    });
    when('get_footer')->alias(static function () use (&$calls): void {
        $calls[] = 'get_footer';
    });
    when('have_posts')->alias(static fn (): bool => $cursor->index + 1 < count($posts));
    when('the_post')->alias(static function () use ($cursor, &$calls): void {
        $cursor->index++;
        $calls[] = 'the_post';
    });
    when('the_permalink')->alias(static function () use ($current): void {
        echo $current()['link'];
    });
    when('the_title_attribute')->alias(static function () use ($current): void {
        echo 'attr:'.$current()['title'];
    });
    when('the_title')->alias(static function () use ($current): void {
        echo $current()['title'];
    });
    when('the_post_thumbnail')->alias(static function (array $size, array $attributes) use (&$calls): void {
        $calls[] = 'the_post_thumbnail:'.json_encode([$size, $attributes]);
        echo '[thumbnail]';
    });
    when('the_excerpt')->alias(static function () use ($current): void {
        echo $current()['excerpt'];
    });
    when('the_content')->alias(static function () use ($current): void {
        echo $current()['content'];
    });
    when('get_the_ID')->alias(static fn (): int => $current()['id']);
    when('get_the_terms')->alias(static function (int $id, string $taxonomy) use ($current, &$calls): array|false {
        $calls[] = 'get_the_terms:'.$id.','.$taxonomy;

        return $current()['terms'];
    });
    when('next_posts_link')->alias(static function (string $label, string $max) use (&$calls): void {
        $calls[] = 'next_posts_link:'.$label.'|'.$max;
        echo '[next]';
    });

    expect(function_exists('uams_content_class'))->toBeFalse();

    ob_start();
    require __DIR__.'/../../templates/'.$template;
    $html = (string) ob_get_clean();

    return [
        'html' => str_replace('> <', '><', trim((string) preg_replace('/\s+/', ' ', $html))),
        'calls' => $calls,
    ];
}

/**
 * @param  list<object>|false  $terms
 * @return array{id: int, title: string, link: string, excerpt: string, content: string, terms: list<object>|false}
 */
function video_post(int $id, string $title, array|false $terms): array
{
    return [
        'id' => $id,
        'title' => $title,
        'link' => 'https://example.test/video/'.strtolower($title).'/',
        'excerpt' => $title.' excerpt',
        'content' => '<p>'.$title.' body</p>',
        'terms' => $terms,
    ];
}

function video_term(string $name): object
{
    return (object) ['name' => $name, 'link' => 'https://example.test/category/'.strtolower($name).'/'];
}

const VIDEO_TEMPLATE_HEAD = '<div class="container uams-body"><div class="row"><div class="uams-content col-md-12" role=\'main\'>'
    .'<div id=\'main_content\' class="uams-body-copy" tabindex="-1">';
const VIDEO_TEMPLATE_TAIL = '<span class="next-page">[next]</span></div></div></div></div>';

it('renders the archive: one block per video, categories linked and comma separated', function (): void {
    $result = render_video_template('archive-video.php', [
        video_post(7, 'Alpha', [video_term('News'), video_term('Health')]),
        video_post(8, 'Beta', [video_term('Care')]),
    ]);

    expect($result['html'])->toBe(
        VIDEO_TEMPLATE_HEAD
        .'<h2><a href="https://example.test/video/alpha/" title="attr:Alpha">Alpha</a></h2>'
        .' [thumbnail]Alpha excerpt'
        .'<p class=\'\'><a href="https://example.test/category/news/">News</a>, <a href="https://example.test/category/health/">Health</a></p>'
        .'<hr>'
        .'<h2><a href="https://example.test/video/beta/" title="attr:Beta">Beta</a></h2>'
        .' [thumbnail]Beta excerpt'
        .'<p class=\'\'><a href="https://example.test/category/care/">Care</a></p>'
        .'<hr>'
        .VIDEO_TEMPLATE_TAIL
    );
});

it('calls WordPress from the archive in this order, with these arguments', function (): void {
    $result = render_video_template('archive-video.php', [
        video_post(7, 'Alpha', [video_term('News')]),
        video_post(8, 'Beta', false),
    ]);

    expect($result['calls'])->toBe([
        'get_header',
        'get_template_part:header,image',
        'get_template_part:breadcrumbs',
        'the_post',
        'the_post_thumbnail:[[130,130],{"class":"attachment-post-thumbnail blogroll-img"}]',
        'get_the_terms:7,video_categories',
        'the_post',
        'the_post_thumbnail:[[130,130],{"class":"attachment-post-thumbnail blogroll-img"}]',
        'get_the_terms:8,video_categories',
        'next_posts_link:Next page|',
        'get_sidebar',
        'get_footer',
    ]);
});

it('omits the category paragraph for an archive video with no categories', function (): void {
    foreach ([false, []] as $terms) {
        $result = render_video_template('archive-video.php', [video_post(7, 'Alpha', $terms)]);

        expect($result['html'])->toContain('[thumbnail]Alpha excerpt<hr>');
        expect($result['html'])->not->toContain('<p class=');
    }
});

it('renders an empty archive: the frame, no video blocks, and the paging link', function (): void {
    $result = render_video_template('archive-video.php', []);

    expect($result['html'])->toBe(VIDEO_TEMPLATE_HEAD.VIDEO_TEMPLATE_TAIL)
        ->and($result['calls'])->toBe([
            'get_header',
            'get_template_part:header,image',
            'get_template_part:breadcrumbs',
            'next_posts_link:Next page|',
            'get_sidebar',
            'get_footer',
        ]);
});

it('renders a single video: the title as an h1, then the content', function (): void {
    $result = render_video_template('single-video.php', [video_post(7, 'Alpha', false)]);

    expect($result['html'])->toBe(
        VIDEO_TEMPLATE_HEAD
        .'<h1>Alpha</h1><p>Alpha body</p>'
        .VIDEO_TEMPLATE_TAIL
    );
});

it('calls WordPress from the single template in this order, with these arguments', function (): void {
    $result = render_video_template('single-video.php', [video_post(7, 'Alpha', false)]);

    expect($result['calls'])->toBe([
        'get_header',
        'get_template_part:header,image',
        'get_template_part:breadcrumbs',
        'the_post',
        'next_posts_link:Next page|',
        'get_sidebar',
        'get_footer',
    ]);
});

it('renders an empty single template: the frame and no heading', function (): void {
    $result = render_video_template('single-video.php', []);

    expect($result['html'])->toBe(VIDEO_TEMPLATE_HEAD.VIDEO_TEMPLATE_TAIL);
});
