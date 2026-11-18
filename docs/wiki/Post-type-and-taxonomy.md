Written against v1.1.2.

The plugin registers one post type and one taxonomy on the `init` hook. Neither has a settings screen; everything below is fixed in the code.

## The `video` post type

Registered in `includes/class-custom-post-type-video.php`.

| Argument | Value | Effect |
| --- | --- | --- |
| Labels | Videos, Video | Shown in the admin menu and the editor. |
| `public` | `true` | Videos have front-end pages and appear in search. |
| `show_ui`, `show_in_admin_bar` | `true` | The admin screens and the *New* menu in the toolbar. |
| `show_in_rest` | `true` | The block editor, and the REST route `/wp-json/wp/v2/video`. |
| `menu_icon` | `dashicons-video-alt3` | The admin menu icon. |
| `hierarchical` | `false` | Videos have no parent videos. |
| `has_archive` | `true` | The archive at `/video/`. |
| `taxonomies` | `video_categories` | The taxonomy below. |
| `supports` | title, editor, custom fields | No featured-image panel, excerpt panel or comments. |
| `capability_type`, `map_meta_cap` | `post`, `true` | Anyone who can edit posts can edit videos. |

The single video's address is `/video/<slug>/`.

## The `video_categories` taxonomy

Registered in `includes/class-custom-taxonomies.php`.

| Argument | Value | Effect |
| --- | --- | --- |
| Labels | Video Categories, Video Category | Shown in the admin menu and the editor panel. |
| `hierarchical` | `true` | Categories can have parent categories. |
| `public`, `show_ui` | `true` | Front-end term archives and the admin screens. |
| `show_in_rest` | `true` | The editor panel, and the REST route `/wp-json/wp/v2/video_categories`. |
| `show_admin_column` | `true` | A *Video Categories* column in the videos list. |
| `capabilities` | `assign_terms` maps to `edit_posts` | Anyone who can edit posts can tick categories on a video. |

A term archive's address uses the taxonomy name, for example `/video_categories/<term-slug>/`.

## Activation and deactivation

| Event | What the plugin does |
| --- | --- |
| Activate | Registers the post type and taxonomy, then flushes the rewrite rules, so video addresses resolve at once. |
| Deactivate | Unregisters the taxonomy and the post type, then flushes the rewrite rules. Videos and categories stay in the database and come back on the next activation. |

## Example

A theme or another plugin lists the five newest videos in one category:

```php
$videos = new WP_Query( [
    'post_type'      => 'video',
    'posts_per_page' => 5,
    'tax_query'      => [ [
        'taxonomy' => 'video_categories',
        'field'    => 'slug',
        'terms'    => 'example-category',
    ] ],
] );
```
