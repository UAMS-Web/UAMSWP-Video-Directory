Written against v1.1.2.

- [A video page answers 404](#a-video-page-answers-404)
- [The video page has no banner or breadcrumbs](#the-video-page-has-no-banner-or-breadcrumbs)
- [A change to the plugin's template does not show](#a-change-to-the-plugins-template-does-not-show)
- [There is no featured image panel in the video editor](#there-is-no-featured-image-panel-in-the-video-editor)

## A video page answers 404

**Cause:** the site's rewrite rules do not include the `video` addresses. The plugin flushes them when it is activated, so this happens when the plugin's files were put in place without an activation, for example by a deploy that replaced the folder while the plugin stayed active.

**Fix:** go to *Settings*, *Permalinks* and select **Save Changes** without changing anything. That flushes the rules. Deactivating and activating the plugin does the same.

## The video page has no banner or breadcrumbs

**Cause:** the active theme is not `uams-2016`, so it has no `header-image` or `breadcrumbs` template part, and the plugin's templates output nothing in their place.

**Fix:** use the `uams-2016` theme, or give the theme its own `single-video.php` and `archive-video.php`; see [Using your own templates in a theme](Using-your-own-templates-in-a-theme.md).

## A change to the plugin's template does not show

**Cause:** the theme has its own `single-video.php` or `archive-video.php`, and the plugin uses its template only when the theme has none.

**Fix:** edit the theme's copy, or delete it to go back to the plugin's. See [Templates](Templates.md#which-template-loads).

## There is no featured image panel in the video editor

**Cause:** the `video` post type supports a title, the content and custom fields only, so the editor shows no featured image panel. The archive template shows a featured image only for a video that already has one.

**Fix:** none in v1.1.2. Put a thumbnail in the content instead, or [ask for the feature](https://github.com/UAMS-Web/UAMSWP-Video-Directory/issues).
