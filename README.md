# Franchise Management Platform

A comprehensive, full-featured system built with **Laravel 11** and **Livewire 3** for managing dynamic, real-time franchise operations. This platform enables franchisors and franchisees to efficiently manage all aspects of their franchise network.

## Features

### 🏢 Franchise Management
- **Onboarding System**: Streamlined process for adding new franchises with complete location details
- **Multi-location Support**: Manage unlimited franchise locations from a single dashboard
- **Role-based Access Control**: Separate views and permissions for franchisors, franchisees, and staff
- **Status Tracking**: Monitor franchise status (active, pending, suspended, closed)

### 📦 Inventory Management
- **Real-time Tracking**: Track inventory levels across all franchise locations
- **Low Stock Alerts**: Automatic notifications when products reach reorder levels
- **Product Management**: Centralized product catalog with SKU, pricing, and categories
- **Reserved Quantity**: Track both available and reserved inventory

### 🛒 Supply Chain & Vendor Management
- **Vendor Database**: Comprehensive vendor information and ratings
- **Purchase Orders**: Create and track purchase orders with approval workflows
- **Delivery Tracking**: Monitor expected and actual delivery dates
- **Multi-status Support**: Track orders from pending to received

### 💰 Sales Tracking
- **Real-time Sales Recording**: Capture sales with detailed line items
- **Payment Methods**: Support for cash, card, online, and other payment types
- **Sales Analytics**: Track sales by franchise, date range, and status
- **Discount Management**: Apply discounts at item and sale levels

### 👑 Royalty Automation
- **Automatic Calculation**: Calculate royalties based on franchise sales
- **Flexible Periods**: Support for monthly, quarterly, and custom periods
- **Payment Tracking**: Monitor due dates and payment status
- **Overdue Alerts**: Identify and flag overdue royalty payments

### 💵 Profit Sharing
- **Automated Calculations**: Calculate profit sharing based on revenue and expenses
- **Flexible Percentages**: Configure franchisor and franchisee share percentages
- **Period-based Tracking**: Track profit sharing by custom periods
- **Status Management**: Track from pending to distributed

### ✅ Compliance Tracking
- **Requirement Management**: Define compliance requirements by category
- **Frequency Support**: One-time, monthly, quarterly, and annual requirements
- **Due Date Tracking**: Monitor upcoming and overdue compliance items
- **Document Management**: Attach supporting documents to compliance records
- **Automatic Alerts**: Flag overdue compliance items

### 📊 Dashboards & Reports
- **Franchisor Dashboard**: Overview of all franchises, sales, and compliance
- **Franchisee Dashboard**: Location-specific metrics and performance
- **Real-time Updates**: Livewire-powered dynamic updates without page refreshes
- **Key Metrics**: Sales totals, royalties, compliance status, and more

## Technology Stack

- **Backend**: Laravel 11.x
- **Frontend**: Livewire 3.x, Tailwind CSS
- **Database**: MySQL/PostgreSQL/SQLite (configurable)
- **Testing**: PHPUnit
- **Asset Building**: Vite

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- Database (MySQL, PostgreSQL, or SQLite)

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/md-riaz/Franchise-Management-Platform.git
   cd Franchise-Management-Platform
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   Edit `.env` file and set your database credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=franchise_management
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed database (optional)**
   ```bash
   php artisan db:seed
   ```

8. **Build assets**
   ```bash
   npm run build
   ```

9. **Start the development server**
   ```bash
   php artisan serve
   ```

Visit `http://localhost:8000` in your browser.

## Database Schema

### Core Tables
- **users**: System users (franchisors, franchisees, staff)
- **franchises**: Franchise locations and details
- **franchise_users**: Many-to-many relationship between users and franchises
- **products**: Product catalog
- **inventory**: Franchise-specific inventory levels
- **vendors**: Vendor information
- **purchase_orders**: Purchase order headers
- **purchase_order_items**: Purchase order line items
- **sales**: Sales transaction headers
- **sale_items**: Sales transaction line items
- **royalties**: Royalty calculations and payments
- **profit_sharing**: Profit sharing calculations
- **compliance_requirements**: Compliance requirement definitions
- **compliance_records**: Franchise-specific compliance tracking

## User Roles

### Admin
- Full system access
- Manage all franchises, users, and settings

### Franchisor
- View all franchise data
- Manage vendors and products
- Monitor compliance across all locations
- Track royalties and profit sharing

### Franchisee
- View own franchise data only
- Manage local inventory
- Record sales
- Track compliance requirements
- View royalty obligations

## API Documentation

The platform includes RESTful API endpoints for:
- Franchise management
- Inventory operations
- Sales recording
- Reporting and analytics

API authentication uses Laravel Sanctum.

## Testing

Run the test suite:
```bash
php artisan test
```

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

For support and questions:
- Create an issue on GitHub
- Email: support@example.com

## Roadmap

### Planned Features
- [ ] Mobile app (iOS/Android)
- [ ] Advanced analytics and BI dashboard
- [ ] Automated marketing campaign management
- [ ] Customer relationship management (CRM)
- [ ] Training and certification tracking
- [ ] Multi-language support
- [ ] Integration with accounting software
- [ ] AI-powered inventory forecasting

## Acknowledgments

- Built with [Laravel](https://laravel.com)
- UI powered by [Livewire](https://livewire.laravel.com)
- Styled with [Tailwind CSS](https://tailwindcss.com)
