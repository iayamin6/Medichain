# Source architecture

[Back to Medichain](../README.md)

Medichain follows Laravel's controller, model, and Blade-view conventions. The repository contains source from an application rather than a complete installable Laravel project.

## Request flow

Routes in `routes/web.php` dispatch requests to controllers in `app/Http/Controllers/`. Authentication and role middleware gate parts of the patient, doctor, and administrator workflows. Controllers use Eloquent models and direct SQL/database-facade operations, then return Blade views or JSON responses. Mail classes and templates support notifications.

## Main components

| Location | Responsibility |
| --- | --- |
| `app/Http/Controllers/Auth/` | Registration, login, password, and verification controllers |
| `app/Http/Controllers/Doctor/` | Doctor dashboard, appointments, patient records, and prescriptions |
| `app/Http/Controllers/` | Patient and administrator workflows, consultations, and care-service endpoints |
| `app/Http/Middleware/` | Authentication and role checks |
| `app/Models/` | Included Eloquent models |
| `resources/views/layouts/` | Shared page shell, header, and sidebar |
| `resources/views/doctor/` | Doctor-facing screens |
| `resources/views/vendor/mail/` | Published mail presentation templates |
| `resources/js/`, `resources/sass/` | Frontend source requiring the original build configuration |

Doctor controllers retain their original namespaces. View directories and filenames now match Laravel dot-notation references such as `appointments.index` and `doctor.records.show`. Route declarations and application behavior have not been rewritten as part of this organization.
