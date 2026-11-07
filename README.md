# UAMSWP Video Directory

A WordPress plugin that adds a video post type and its taxonomy.

## Running the tests

The unit suite runs on Pest 5 with Brain Monkey, so it needs no WordPress install and no database. It runs on PHP 8.4.

```sh
composer install
composer test
```

`composer.json` holds development dependencies only, so nothing from it belongs on a server. The suite also runs in GitHub Actions on every pull request.
