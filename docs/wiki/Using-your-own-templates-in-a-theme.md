Written against v1.1.2.

A theme can show videos with its own markup instead of the plugin's. The plugin uses its own template only when the theme has none, so adding the file to the theme is all it takes.

1. **Copy the template** you want to change from the plugin's `templates/` folder into the theme's folder (the child theme's, when there is one):
   - `single-video.php` for a single video;
   - `archive-video.php` for the video archive.
2. **Edit the copy.** Keep the WordPress loop (`while ( have_posts() )`), or the page shows no videos.
3. **Reload a video page.** WordPress now finds the theme's file first, and the plugin leaves it in place.

To go back to the plugin's template, delete the theme's copy.

**Note:** the plugin's copies change with plugin releases, and a theme's copy does not. Compare the two after updating the plugin.

## Reference

- [Templates](Templates.md): how the plugin chooses between its template and the theme's.
- [Post type and taxonomy](Post-type-and-taxonomy.md): the names a template can query (`video`, `video_categories`).
