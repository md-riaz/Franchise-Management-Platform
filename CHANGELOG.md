# Changelog

All notable changes to the Franchise Management Platform will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project uses date-based releases (`YYYY-MM-DD`) as the version identifier.

## [2026-03-26]

### Added
- Docker deployment support with PHP-FPM, Nginx, and MySQL orchestration
- Team guidance in `AGENT.md` requiring dated changelog entries for every change
- Revamped UI/UX with SheafUI components and Tailwind CSS 4 across all views (login, dashboard, franchises, inventory, sales, vendors, compliance, royalties, welcome)
- New screenshots capturing the updated UI (1440 × 757 px, all nine screens) in `public/screenshots/`
- Added `blade-ui-kit/blade-heroicons` dependency to support Heroicon Blade components used throughout the new UI
- Added missing base `Controller` class for API controllers
- Completed SheafUI migration by replacing native HTML elements (input, button, label, checkbox) in login page with SheafUI components

### Changed
- Adopted date-based versioning and updated release documentation
- Updated `README.md` Screenshot Tour section: added welcome screenshot, switched list to a table, and added a description of the SheafUI revamp
- Migrated login form to use SheafUI components (x-ui.input, x-ui.button, x-ui.label, x-ui.checkbox) for consistent UI/UX

## [2026-03-27]

### Added
- Implemented monthly royalty calculation in `RoyaltyList` using completed sales totals per active franchise, with idempotent upserts by period and an authorization guard.

### Changed
- Replaced inventory's boolean low-stock checkbox with a stock-level select filter supporting `low_stock` and `in_stock`.
- Replaced compliance's boolean overdue checkbox with a focus select filter supporting `overdue`, `due_soon`, and `non_compliant`.
- Updated documentation to reflect the current stack (`Laravel 13.x` and `Livewire 4.x`) across README and architecture docs.
- Removed placeholder support email from README and linked support requests to the GitHub issues tracker.
- Added a missing `x-layouts.app` Blade component alias so existing layout-component usage resolves correctly.
- Restored `config/view.php` with compiled view path configuration to support artisan optimize/view cache workflows.

## [2025-10-24]

### Added

#### Core Features
- Complete franchise management system with Laravel 11 and Livewire 3
- Role-based access control (Admin, Franchisor, Franchisee)
- Multi-tenant support with franchise-specific data isolation

#### Franchise Management
- Franchise onboarding workflow
- Franchise location management
- Status tracking (active, pending, suspended, closed)
- Opening date and investment tracking
- Configurable royalty percentages

#### Inventory Management
- Real-time inventory tracking across all locations
- Product catalog with SKU management
- Low stock alerts and reorder levels
- Reserved quantity tracking
- Available quantity calculations

#### Supply Chain & Vendors
- Vendor database with ratings
- Vendor contact management
- Purchase order system
- Order status tracking (pending, approved, ordered, received, cancelled)
- Delivery date tracking

#### Sales Tracking
- Sales transaction recording
- Multiple payment methods support
- Sales analytics and reporting
- Date range filtering
- Status management (completed, pending, cancelled, refunded)

#### Royalty Automation
- Automatic royalty calculation based on sales
- Period-based tracking (monthly, quarterly, annual)
- Payment status monitoring
- Due date tracking
- Overdue alerts

#### Profit Sharing
- Revenue and expense tracking
- Automated profit calculations
- Configurable share percentages
- Period-based distribution tracking

#### Compliance Tracking
- Compliance requirement definitions
- Category-based organization (legal, operational, safety, quality)
- Frequency management (once, monthly, quarterly, annually)
- Due date monitoring
- Overdue alerts
- Document attachment support

#### User Interface
- Responsive Tailwind CSS design
- Dynamic dashboard for different user roles
- Real-time updates via Livewire
- Search and filter functionality
- Pagination for large datasets
- Status badges and visual indicators

#### API
- RESTful API endpoints for franchises
- Sales statistics API
- Sanctum authentication support
- JSON response formatting

#### Developer Experience
- Comprehensive database migrations
- Eloquent models with relationships
- Database seeders with sample data
- PHPUnit test infrastructure
- Vite for asset building
- Code documentation

### Technical Specifications
- Laravel 11.x framework
- Livewire 3.x for reactive components
- PHP 8.2+ compatibility
- MySQL/PostgreSQL/SQLite support
- Tailwind CSS for styling
- Alpine.js for JavaScript interactions

### Documentation
- Comprehensive README with installation guide
- Architecture documentation
- Contributing guidelines
- Code of conduct
- API documentation
- Database schema diagrams

### Default Credentials (Development)
- Admin: admin@franchise.com / password
- Franchisor: franchisor@franchise.com / password
- Franchisee: franchisee@franchise.com / password

## [Unreleased]

### Planned
- Mobile application (iOS/Android)
- Advanced analytics dashboard
- Real-time notifications via WebSockets
- Multi-language support
- CRM integration
- Training module
- Marketing campaign management
- AI-powered inventory forecasting
- Integration with accounting software
- Custom report builder

---

## Release Notes

### 2026-03-26 Release

- Added Docker deployment support (PHP-FPM, Nginx, MySQL)
- Standardized on date-based release identifiers with mandatory dated changelog entries

### 2025-10-24 Initial Release

This is the first production-ready release of the Franchise Management Platform. It includes all core features necessary for managing a multi-location franchise network, including:

- Complete franchise lifecycle management
- Real-time inventory tracking
- Automated royalty calculations
- Comprehensive compliance monitoring
- Sales analytics and reporting
- Supply chain management
- Vendor coordination

The platform is built with scalability in mind and can support franchise networks of any size.

### Breaking Changes
- None (initial release)

### Migration Guide
- None (initial release)

### Known Issues
- None reported

### Security
- All security best practices implemented
- Password hashing with bcrypt
- CSRF protection enabled
- SQL injection prevention via Eloquent
- XSS protection via Blade templating

### Performance
- Optimized database queries with eager loading
- Indexed foreign keys for fast lookups
- Pagination for large datasets
- Livewire component optimization

For more information, see the [README](README.md) and [ARCHITECTURE](ARCHITECTURE.md) documentation.
