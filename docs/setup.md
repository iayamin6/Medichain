# Setup and known gaps

[Back to Medichain](../README.md)

## What is needed to run the application

The repository does not currently contain enough files to run `composer install` or `php artisan serve`. Restore the original application's supporting files before attempting a full launch:

- `composer.json` and its lockfile to identify the Laravel version and PHP dependencies.
- `artisan`, `bootstrap/`, `config/`, the public entry point, and writable runtime directories.
- Database migrations or a documented schema for the tables referenced by the source.
- Frontend dependency manifests and the original asset-build configuration.
- Referenced public images and videos, including files under `pics/`.
- A sanitized environment example matching the actual database and mail configuration.

No Laravel version or dependency manifest has been guessed during cleanup. Integrate this source into the matching original application, restore dependencies and schema, configure local environment values, then verify routes and compile views before testing workflows.

## Existing source gaps

These issues predate the repository organization:

- `OnlineConsultationController` references `consultations.room`, but that view was not included in the upload.
- Web routes contain repeated emergency and consultation declarations and overlapping route names. Their original order is preserved; reconcile them during a functional repair pass.
- Some route targets and framework classes referenced by the source are absent or require confirmation against the complete application.
- Public asset references cannot resolve from this snapshot alone.

The cleanup does not establish working authentication, database operations, notifications, consultations, or deployment. Runtime and browser checks require the missing project files.

## Checks that can run now

With PHP installed, syntax-check the active PHP source:

```sh
find app routes -type f -name '*.php' -exec php -l {} \;
```

Blade compilation and Laravel route checks require the restored framework. The original draft variants in `archive/variants/` are reference text and should not be added to application autoload paths.
