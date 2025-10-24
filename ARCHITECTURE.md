# Architecture Documentation

## System Overview

The Franchise Management Platform is built using Laravel 11 and Livewire 3, following a modular, component-based architecture that emphasizes scalability, maintainability, and real-time interactivity.

## Technology Stack

### Backend
- **Framework**: Laravel 11.x
- **Language**: PHP 8.2+
- **ORM**: Eloquent
- **Queue System**: Laravel Queue (Database driver)
- **Cache**: Database/Redis (configurable)
- **Session**: Database

### Frontend
- **UI Framework**: Livewire 3.x
- **CSS Framework**: Tailwind CSS
- **JavaScript**: Alpine.js (via Livewire)
- **Build Tool**: Vite

### Database
- **Primary**: MySQL/PostgreSQL
- **Development**: SQLite (optional)
- **Migrations**: Laravel Migration System

## Architecture Layers

### 1. Presentation Layer (Livewire Components)

```
app/Livewire/
├── Dashboard.php              # Main dashboard
├── FranchiseList.php          # Franchise listing
├── FranchiseForm.php          # Franchise CRUD
├── InventoryList.php          # Inventory management
├── SalesList.php              # Sales tracking
├── VendorList.php             # Vendor management
├── RoyaltyList.php            # Royalty tracking
└── ComplianceList.php         # Compliance monitoring
```

**Responsibilities:**
- User interaction handling
- Real-time UI updates
- Form validation
- Data filtering and pagination

### 2. Business Logic Layer (Models)

```
app/Models/
├── User.php                   # User authentication & authorization
├── Franchise.php              # Franchise management
├── Product.php                # Product catalog
├── Inventory.php              # Stock management
├── Vendor.php                 # Vendor information
├── PurchaseOrder.php          # Purchase orders
├── PurchaseOrderItem.php      # PO line items
├── Sale.php                   # Sales transactions
├── SaleItem.php               # Sales line items
├── Royalty.php                # Royalty calculations
├── ProfitSharing.php          # Profit distribution
├── ComplianceRequirement.php  # Compliance definitions
└── ComplianceRecord.php       # Compliance tracking
```

**Responsibilities:**
- Database interactions
- Business rules enforcement
- Relationships management
- Data validation
- Computed attributes

### 3. API Layer (Controllers)

```
app/Http/Controllers/Api/
├── FranchiseController.php    # Franchise API
└── SalesController.php         # Sales API
```

**Responsibilities:**
- RESTful API endpoints
- Request validation
- Response formatting
- Authentication/Authorization

### 4. Data Layer (Migrations)

```
database/migrations/
├── 0001_01_01_000000_create_users_table.php
├── 0001_01_01_000001_create_cache_table.php
├── 0001_01_01_000002_create_jobs_table.php
├── 2024_01_01_000001_create_franchises_table.php
├── 2024_01_01_000002_create_franchise_users_table.php
├── 2024_01_01_000003_create_products_table.php
├── 2024_01_01_000004_create_inventory_table.php
├── 2024_01_01_000005_create_vendors_table.php
├── 2024_01_01_000006_create_purchase_orders_table.php
├── 2024_01_01_000007_create_sales_table.php
├── 2024_01_01_000008_create_royalties_table.php
└── 2024_01_01_000009_create_compliance_table.php
```

## Database Schema

### Core Entities

#### Users Table
- Manages all system users (Admin, Franchisor, Franchisee)
- Stores authentication credentials
- Tracks user type and status

#### Franchises Table
- Central entity for franchise locations
- Links to franchisor (User)
- Contains location and financial details

#### Products Table
- Product catalog
- Pricing information
- Reorder levels for inventory management

#### Inventory Table
- Franchise-specific stock levels
- Tracks quantity, reserved quantity
- Links products to franchises

#### Sales Table
- Transaction records
- Links to franchise and user
- Stores payment details and status

#### Royalties Table
- Period-based royalty calculations
- Tracks payment status
- Links to franchise

#### Compliance Table
- Requirements and records
- Due date tracking
- Document management

### Relationships

```
User (Franchisor) ──1:N──> Franchise ──1:N──> Sales
                                │
                                ├──1:N──> Inventory ──N:1──> Product
                                │
                                ├──1:N──> PurchaseOrders ──N:1──> Vendor
                                │
                                ├──1:N──> Royalties
                                │
                                ├──1:N──> ProfitSharing
                                │
                                └──1:N──> ComplianceRecords ──N:1──> ComplianceRequirement

Franchise ──N:M──> User (Franchisee) [via franchise_users]
```

## Component Communication

### Livewire Component Lifecycle

1. **Initial Load**
   ```
   Component Mount → Data Fetch → Render View
   ```

2. **User Interaction**
   ```
   User Action → Livewire Event → Server Processing → DOM Update
   ```

3. **Pagination/Filtering**
   ```
   Filter Change → Query Update → Results Refresh → Render
   ```

## Security Architecture

### Authentication
- Laravel's built-in authentication
- Session-based for web
- Sanctum tokens for API

### Authorization
- Role-based access control (RBAC)
- User type field (admin, franchisor, franchisee)
- Component-level permissions

### Data Protection
- Password hashing (bcrypt)
- CSRF protection
- SQL injection prevention (Eloquent)
- XSS protection (Blade escaping)

## Performance Considerations

### Optimization Strategies

1. **Database**
   - Indexed foreign keys
   - Eager loading relationships
   - Query optimization with scopes

2. **Caching**
   - Database caching layer
   - Session caching
   - Configurable cache drivers

3. **Frontend**
   - Livewire lazy loading
   - Pagination for large datasets
   - Debounced search inputs

4. **Assets**
   - Vite for bundling
   - CSS purging (Tailwind)
   - Asset versioning

## Scalability

### Horizontal Scaling
- Stateless application design
- Database session storage
- Queue processing for heavy tasks

### Vertical Scaling
- Optimized queries
- Database indexing
- Cache layers

## Deployment Architecture

### Recommended Setup

```
┌─────────────────┐
│  Load Balancer  │
└────────┬────────┘
         │
    ┌────┴────┐
    │         │
┌───▼───┐ ┌──▼────┐
│ App 1 │ │ App 2 │
└───┬───┘ └──┬────┘
    │        │
    └────┬───┘
         │
    ┌────▼────┐
    │ Database│
    └─────────┘
```

### Environment Separation
- Development
- Staging
- Production

## Monitoring & Logging

### Logging
- Laravel Log system
- Channel-based logging
- Error tracking

### Monitoring
- Application performance
- Database queries
- User activity

## Future Enhancements

### Planned Features
- Real-time notifications (WebSockets)
- Advanced reporting dashboard
- Mobile application
- Multi-language support
- Integration APIs
- AI-powered analytics

### Technical Improvements
- Microservices architecture
- GraphQL API
- Event sourcing
- CQRS pattern
