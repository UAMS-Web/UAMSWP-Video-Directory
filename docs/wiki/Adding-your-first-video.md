Written against v1.1.2.

At the end of this page the site has one published video with a category, shown on its own page and listed in the video archive.

1. **Activate the plugin** under *Plugins*. A **Videos** item, with a video-camera icon, appears in the admin menu. Activation also flushes the rewrite rules, so video URLs resolve straight away.
2. **Add a category** under *Videos*, *Video Categories*. Categories are hierarchical, like post categories, so one can sit under another.
3. **Add a video** under *Videos*, *Add New*. Give it a title, and put the video in the content: paste a YouTube or Vimeo URL on its own line and the editor embeds it.
4. **Tick the category** in the editor's *Video Categories* panel, then **Publish**.
5. **Open the video.** Its address is the site address followed by `/video/<slug>/`, for example `https://example.org/video/welcome/`. The page shows the title as a heading and the content below it.
6. **Open the archive** at `/video/`, for example `https://example.org/video/`. Each video is listed with its title as a link, an excerpt WordPress takes from the start of its content, and its categories as links to their archives.

**Note:** the templates are written for the `uams-2016` theme. Under another theme they still render, without that theme's header image and breadcrumbs; see [Templates](Templates.md).

## Going further

- [Using your own templates in a theme](Using-your-own-templates-in-a-theme.md)
- [Post type and taxonomy](Post-type-and-taxonomy.md)
- [Troubleshooting](Troubleshooting.md)
