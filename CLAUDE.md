# CLAUDE.md

## Project Overview

Dies Natalis FKG UGM ke-78 — an event management web application for the Faculty of Dentistry, Universitas Gadjah Mada's 78th anniversary. Features event registration with online payment (Xendit), ticket generation with barcodes/QR codes, a pitch competition submission system, and a Filament-based admin panel.

## Tech Stack

- **Framework**: Laravel 11 (PHP ^8.2)
- **Admin Panel**: Filament v3.3
- **Payment Gateway**: Xendit (xendit-php v7)
- **Database**: SQLite (default), MySQL supported
- **Frontend**: Blade templates, Vite, Tailwind CSS
- **Queue**: Database driver
- **Session/Cache**: Database driver
- **Testing**: PHPUnit

## Project Structure

```
app/
├── Enums/              # EventType, OrderStatus, ParticipantCategory
├── Filament/           # Admin panel resources, pages, widgets
│   ├── Pages/          # ManageSettings
│   ├── Resources/      # Article, Document, EventPrice, Order, PitchSubmission, Slider, Ticket
│   └── Widgets/        # RegistrationStatsOverview
├── Http/Controllers/   # Home, Article, Registration, Payment, Ticket, PitchSubmission, Webhook
├── Jobs/               # SendTicketEmail (queued, 3 retries)
├── Mail/               # TicketConfirmation mailable
├── Models/             # Article, Document, EventPrice, Order, OrderItem, PitchSubmission, Setting, Slider, Ticket, User
├── Providers/          # AppServiceProvider, Filament/AdminPanelProvider
└── Services/           # PricingService, TicketService, XenditService

database/
├── migrations/         # 13 migration files
└── seeders/            # DatabaseSeeder, SettingsSeeder, EventPriceSeeder

resources/views/
├── components/         # Blade components (hero, navbar, footer, event-cards, etc.)
├── emails/             # ticket-confirmation
├── filament/           # manage-settings
├── layouts/            # app.blade.php
└── pages/              # home, registrasi, pembayaran, tiket, article, 3mpc pages

routes/
├── web.php             # All public routes
└── console.php         # Artisan commands

tests/
├── Feature/            # Feature tests
└── Unit/               # Unit tests
```

## Key Commands

```bash
# Install dependencies
composer install
npm install

# Run development server
php artisan serve

# Build frontend assets
npm run dev          # Development with HMR
npm run build        # Production build

# Database
php artisan migrate
php artisan db:seed                    # Seeds admin user, settings, event prices
php artisan migrate:fresh --seed       # Reset and reseed

# Tests
php artisan test                       # Run all tests
./vendor/bin/phpunit                   # Alternative
php artisan test --filter=FeatureName  # Run specific test

# Code formatting
./vendor/bin/pint                      # Laravel Pint (PSR-12 style)

# Queue
php artisan queue:work                 # Process queued jobs (email sending)

# Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Domain Concepts

### Events
Four event types defined in `EventType` enum: Simposium (SIM), Hands-on Workshop (HOS), Fun Run 5K (FNR), Pengabdian Masyarakat (PGM).

### Participant Categories
Three categories in `ParticipantCategory` enum: Alumni (A), Civitas (C), Umum (U). Each has different pricing.

### Registration Flow
1. User selects events (individual or bundle) on `/registrasi` or `/registrasi/bundling`
2. `RegistrationController@store` validates input, checks for duplicate pending orders (5-min window), calculates pricing with 10% fee
3. Order created with items → Xendit invoice generated (24-hour expiry) → user redirected to payment URL
4. Xendit sends webhook to `/webhook/xendit` → order status updated
5. On successful payment: tickets generated via `TicketService`, confirmation email queued via `SendTicketEmail`

### Order Numbers
Format: `DN78-YYYYMMDD-XXXX` (auto-generated, sequential per day)

### Ticket Codes
Format: `DN78-{EVENT_SHORT_CODE}-{CATEGORY_SHORT_CODE}-{SEQUENTIAL_NUMBER}` (e.g., DN78-SIM-U-00001)

### Pricing
- Base prices stored in `event_prices` table
- Display price = base_price × 1.10 (10% fee via `PricingService`)
- Bundles have their own pricing with `bundle_events` JSON field

### Order Statuses
Pending → Paid/Expired/Failed/Refunded (defined in `OrderStatus` enum with Indonesian labels)

## Key Conventions

### Code Style
- **PSR-12** via Laravel Pint (`./vendor/bin/pint`)
- **4-space indentation**, LF line endings, UTF-8 (see `.editorconfig`)
- YAML files use 2-space indentation

### Laravel Patterns
- **Enums** with backed string values and helper methods (label, shortCode, color)
- **UUID routing** on Order and PitchSubmission models (route key = uuid)
- **Slug routing** on Article model (route key = slug)
- **Service classes** for business logic (XenditService, TicketService, PricingService)
- **Scopes** for common queries (e.g., `active()`, `published()`, `forCategory()`)
- **Settings** stored as key-value pairs in `settings` table with caching (`Setting::get()`, `Setting::set()`)

### Filament Admin
- Panel path: `/admin`
- Color: Amber
- Admin user: `admin@diesfkgugm.id` (seeded)
- Resources auto-discovered from `app/Filament/Resources`
- Order and Ticket resources are view-only; Article, EventPrice, Document, Slider have full CRUD

### Naming Conventions
- **Routes**: Indonesian naming (registrasi, pembayaran, tiket, artikel)
- **Views**: kebab-case in `resources/views/pages/` and `resources/views/components/`
- **Models**: English, singular PascalCase
- **Database tables**: English, plural snake_case
- **Enums**: PascalCase cases with lowercase string backing values

### Webhooks
- CSRF excluded for `/webhook/*` routes (configured in `bootstrap/app.php`)
- Xendit callback validated via `X-CALLBACK-TOKEN` header

## Environment Variables

Key variables (see `.env.example`):
- `XENDIT_SECRET_KEY` — Xendit API secret key (required for payments)
- `XENDIT_CALLBACK_TOKEN` — Webhook validation token (required for webhooks)
- `DB_CONNECTION` — `sqlite` (default) or `mysql`
- `QUEUE_CONNECTION` — `database` (required for email sending)
- `MAIL_MAILER` — Configure for production email delivery

## Testing

- PHPUnit with Feature and Unit test suites
- Mail uses `array` driver in tests
- Queue uses `sync` driver in tests
- Session uses `array` driver in tests
- Only basic example tests exist currently; new tests should follow Laravel testing conventions

## Important Notes

- The application uses Indonesian language for user-facing content (routes, labels, email subjects)
- Payment webhooks must be idempotent — `WebhookController` handles duplicate callbacks gracefully
- Ticket generation only happens once per order (checked via existing ticket count)
- The `SendTicketEmail` job has 3 retry attempts with 60-second backoff
- Bundle events are stored as JSON arrays in the `bundle_events` column of `event_prices`
- Dynamic form validation in `RegistrationController@store` varies by event type (funrun needs jersey size, satusehat needs healthcare fields)
