# Repository organization — 2026-09-30

[Back to Medichain](../README.md)

## Changes

- Restored standard root folders: `app/`, `resources/`, and `routes/`.
- Removed trailing spaces from folder names and download suffixes such as ` (1)` from directories and Blade filenames.
- Extracted the existing routes from the dated export folder into `routes/`.
- Removed the duplicate application tree after comparing its files byte-for-byte with the primary tree.
- Removed the ZIP only after confirming all 42 archived files exactly matched retained source files.
- Removed `.DS_Store` files and added ignore rules for local configuration, dependencies, runtime data, and generated output.
- Preserved three differing drafts under `archive/variants/` as reference text, outside PHP autoload and Blade view locations.

## Preserved variants

| Original location | Retained reference |
| --- | --- |
| `app /Http/Controllers/Doctor/new.php` | `archive/variants/AppointmentController.php.txt` |
| `app /Http/Controllers/EmergencyConroller.php` | `archive/variants/EmergencyController.php.txt` |
| `resources /views /emails /appointment-confirmation.blade` | `archive/variants/appointment-confirmation.blade.txt` |

The two controller drafts declare classes also present in the active source. Keeping them outside `app/` avoids duplicate class declarations while preserving their contents for comparison. The alternate email draft differs from the retained `.blade.php` template.

## Validation

- 109 unique source files retained with their original bytes.
- All 43 active PHP application/route files passed syntax validation with PHP 8.4.6.
- Literal view/include/layout references were checked against the normalized paths. The pre-existing missing `consultations.room` view is documented in the setup guide.
- Repository name, URL, and prior Git history remain unchanged.

No dependency installation, Laravel boot, database test, Blade compilation, or browser walkthrough was possible from this incomplete snapshot. These results cover organization and PHP syntax only.
