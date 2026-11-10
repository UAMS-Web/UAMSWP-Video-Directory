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

## Continuous integration

`.github/workflows/ci.yml` calls the shared chain in `UAMS-Web/uams-ci-workflows`, so this plugin runs the same checks as the other UAMS-Web repositories instead of a copy of them. The call runs on Linux only, leaves mutation testing off, runs the unit suite as `composer test:unit`, and switches on the two jobs only a plugin runs: the PHP 8.2 floor lint and the download archive check. The job named `CI` reports the result of the whole call, and is the one check a ruleset requires from this workflow.

The floor lint parses every shipped PHP file with the supported floor. To run it locally under another PHP:

```sh
LINT_PHP=/path/to/php8.2 composer lint:floor
```

## Credits

Developed and maintained by UAMS Web Services.

Developers:

- Josh Daugherty
- Todd McKee
