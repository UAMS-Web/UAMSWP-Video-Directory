Written against v1.1.2.

The plugin ships two templates in `templates/`, and uses each one only when the active theme has no template of its own for that page.

## Which template loads

| Page | The plugin's template is used when | Hook |
| --- | --- | --- |
| A single video | the post is a `video` and the theme has no `single-video.php` | `single_template` |
| The video archive (`/video/`) | the request is the `video` post type archive and the theme has no `archive-video.php` | `template_include` |

In every other case the template WordPress chose is left alone. A **Video Categories** term archive is not handled by the plugin: it uses the theme's `taxonomy-video_categories.php`, `taxonomy.php` or `archive.php`, by the usual WordPress template hierarchy.

## What each template outputs

- **`single-video.php`:** the title as an `h1`, then the content.
- **`archive-video.php`:** for each video, the title as an `h2` link, the featured image at 130 by 130 pixels when the video has one, the excerpt, and its categories as a comma-separated list of links. A category with no archive to link to is shown as its name alone. After each video, a horizontal rule. Below the list, a *Next page* link when there are more videos.

Both wrap their content in `container uams-body`, `row` and `uams-body-copy` elements, and call `get_header()`, `get_sidebar()` and `get_footer()`.

## The theme they expect

The templates are written for the [`uams-2016`](https://github.com/UAMS-Web/uams-2016/) theme and use three things from it:

| From the theme | Used for | Under another theme |
| --- | --- | --- |
| The `header-image` template part | the banner above the content | outputs nothing |
| The `breadcrumbs` template part | the trail above the content | outputs nothing |
| `uams_content_class()` | the content column's classes | the column gets `uams-content col-md-12` |

So under any other theme the templates still render, without the banner and the breadcrumbs.

## Stylesheet

The plugin carries `css/video-directory.css`, but no code in v1.1.2 loads it: the pages are styled by the theme alone.
