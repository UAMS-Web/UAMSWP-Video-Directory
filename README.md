# UAMSWP Video Directory

A WordPress plugin that adds a video post type and its taxonomy.

## Theme

The video templates in `templates/` are written for the [`uams-2016`](https://github.com/UAMS-Web/uams-2016/) theme. They use its `header-image` and `breadcrumbs` template parts and its `uams_content_class()` function. Under any other theme the templates still render: a missing `uams_content_class()` falls back to the classes `uams-content col-md-12`, and a missing template part outputs nothing.

## Running the tests

The unit suite runs on Pest 5 with Brain Monkey, so it needs no WordPress install and no database. It runs on PHP 8.4.

```sh
composer install
composer test
```

`composer.json` holds development dependencies only, so nothing from it belongs on a server. The suite also runs in GitHub Actions on every pull request.
