# Medichain

A Laravel healthcare portal prototype connecting patient appointments, medical records, doctor workflows, and care-related services.

## Project overview

The source includes patient, doctor, and administrator interfaces built with PHP, Laravel controllers and models, and Blade templates. It covers appointment scheduling, record sharing, consultation workflows, health monitoring, ambulance booking, and medical-travel pages.

| Area | Included source |
| --- | --- |
| Patient portal | Appointment booking, medical records, profile management, and record-sharing links |
| Doctor portal | Dashboard, appointments, patients, medical records, prescriptions, and settings |
| Consultations | Online consultation and telemedicine controllers and views |
| Care services | Hospital availability, ambulance booking, health monitoring, and medical travel |
| Administration | Dashboard and management route declarations |
| Notifications | Appointment confirmation and record-sharing email templates |

**Repository status:** this is a partial Laravel source snapshot. The original upload does not include the application bootstrap, dependency manifests, database migrations, or public assets needed to run it independently. Included features describe the available code, not verified end-to-end functionality. See [setup and known gaps](docs/setup.md).

## Repository structure

```text
Medichain/
├── app/
│   ├── Http/Controllers/   # Patient, doctor, administrator, and auth controllers
│   ├── Http/Middleware/    # Authentication and role middleware
│   ├── Models/             # Users, appointments, records, hospitals, and slots
│   ├── Mail/               # Appointment email class
│   ├── Observers/          # Appointment observer
│   └── Providers/          # Application service provider
├── resources/
│   ├── views/              # Blade screens, shared layouts, and mail templates
│   ├── js/                 # Frontend JavaScript source
│   └── sass/               # Sass source
├── routes/                 # Web, API, and console routes
├── docs/                   # Architecture, setup limitations, and cleanup notes
└── archive/variants/       # Distinct original drafts kept outside active source
```

## Explore the code

- [Web routes](routes/web.php) connect the main workflows.
- [Controllers](app/Http/Controllers) contain request handling and database operations.
- [Models](app/Models) define the included data models.
- [Blade views](resources/views) are grouped by feature and role.
- [Architecture](docs/architecture.md) explains the source layout.
- [Setup and known gaps](docs/setup.md) identifies the missing runtime pieces.
- [Organization notes](docs/organization.md) records what was moved and verified.

## Verification

All 43 active application and route PHP files pass `php -l` with PHP 8.4.6. This is a syntax check only; it does not confirm Laravel-version compatibility, compile Blade templates, or verify database and browser workflows. The original source contents were preserved during organization.
