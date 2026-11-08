# UAMSWP Video Directory

A WordPress plugin that adds a video post type and its taxonomy.

## Running the tests

The unit suite runs on Pest 5 with Brain Monkey, so it needs no WordPress install and no database. It runs on PHP 8.4.

```sh
composer install
composer test
```

`composer.json` holds development dependencies only, so nothing from it belongs on a server. The suite also runs in GitHub Actions on every pull request.

## Code quality

Three tools run on every pull request: Pint (formatting, the `laravel` preset), Rector (the gating profile) and PHPStan (with the WordPress extension and stubs).

```sh
composer test:pint
composer test:refactor
composer stan
```

`composer pint` and `composer refactor` apply what the first two report. PHPStan runs at the level set in `phpstan.neon.dist` and rises one level per change. Once per clone, tell `git blame` to skip the Pint reformat commit:

```sh
git config blame.ignoreRevsFile .git-blame-ignore-revs
```
