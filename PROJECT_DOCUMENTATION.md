# Aura World E-commerce Platform Documentation

## Project Overview
A comprehensive Laravel 12 e-commerce platform with multi-role management, product catalog, shopping cart, and payment integration.

## Technology Stack
- **Framework**: Laravel 12 (PHP 8.2+)
- **Database**: MySQL
- **Frontend**: Blade Templates + Bootstrap
- **Authentication**: Laravel Auth + Google OAuth  
- **Payment**: VNPay Integration
- **Features**: Soft Deletes, File Upload, Email System

## Core Features

### User Management
- **Admin** (`role_id: 1`): Full system access, product/order management
- **Customer** (`role_id: 2`): Shopping, orders, reviews
- **Shipper** (`role_id: 3`): Delivery management (disabled)

### Product System
- Products with categories, brands, and multiple variants
- Product attributes (color, size, etc.) via variant system
- Image management with featured images
- Stock tracking and auto-deactivation
- Soft delete protection

### Shopping Experience
- Advanced product filtering (category, brand, price, attributes)
- Shopping cart with quantity management
- Coupon system with percentage/fixed discounts
- Secure checkout with COD/VNPay options
- Order tracking and status management

### Admin Dashboard
- Sales analytics and reporting
- Product/category/brand management
- Order processing and fulfillment
- Customer management
- Banner system (carousel + secondary)
- Review moderation

## Database Structure

### Key Models & Relationships
```
User (1:M) → Order (1:M) → OrderDetail (M:1) → Variant (M:1) → Product
Product (M:1) → Category, Brand
Product (1:M) → Review, ProductImage
Variant (M:M) → AttributeValue
User (1:1) → Cart (1:M) → CartItem
```

### Important Tables
- `users`: User accounts with roles and soft deletes
- `products`: Main product catalog
- `variants`: Product variations with price/stock
- `orders`: Customer orders with payment status
- `cart`/`cart_items`: Shopping cart functionality
- `banners`: Homepage banner management
- `coupons`: Discount code system

## Payment Integration (VNPay)

### Features
- Secure payment gateway integration
- Real-time transaction validation
- Automatic stock deduction on successful payment
- Transaction logging and error handling
- Support for multiple currencies (VND)

### Configuration
```env
VNPAY_TMN_CODE=your_terminal_code
VNPAY_HASH_SECRET=your_secret_key
VNPAY_URL=payment_gateway_url
VNPAY_RETURN_URL=your_callback_url
```

## Banner System

### Types
- **Main Banners**: Homepage carousel with multiple rotating banners
- **Secondary Banners**: Bottom section cards (max 2 side-by-side)

### Management
- Upload/manage banner images
- Set display order and status
- Click-through URL support
- Responsive design implementation

## Key Routes

### Authentication
- `/login`, `/register` - User authentication
- `/auths/google` - Google OAuth integration

### Customer Frontend
- `/clients` - Homepage with banners
- `/clients/products` - Product catalog with filtering
- `/clients/carts` - Shopping cart management
- `/clients/orders` - Order history and tracking

### Admin Panel
- `/admin` - Dashboard with analytics
- `/admin/products` - Product management
- `/admin/orders` - Order processing
- `/admin/banners` - Banner management

## Installation & Setup

1. **Environment Setup**
   ```bash
   composer install
   cp .env.example .env
   php artisan key:generate
   ```

2. **Database Setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   php artisan storage:link
   ```

3. **Run Application**
   ```bash
   npm install && npm run dev
   php artisan serve
   ```

## Security Features
- CSRF protection on all forms
- SQL injection prevention via Eloquent
- XSS protection with input validation
- Secure password hashing
- Account activation/deactivation
- Soft deletes for data recovery

## Business Logic

### Order Workflow
1. **Cart Management**: Add/update/remove items
2. **Checkout**: Customer details + payment method selection
3. **Payment**: COD (immediate) or VNPay (redirect)
4. **Fulfillment**: Admin processes and ships orders
5. **Completion**: Customer receives and can review products

### Stock Management
- Real-time stock checking during cart operations
- Automatic stock deduction on successful payment
- Auto-deactivation of out-of-stock products
- Stock restoration on order cancellation

### Coupon System
- Percentage or fixed amount discounts
- Minimum order value requirements
- Usage limits and expiration dates
- Session-based application during checkout

## File Structure
```
app/
├── Http/Controllers/
│   ├── AuthController.php          # Authentication
│   ├── ClientController.php        # Customer frontend
│   ├── ProductController.php       # Product management
│   ├── VNPayController.php         # Payment processing
│   └── Admin/                      # Admin controllers
├── Models/                         # Eloquent models
├── Services/VNPayService.php       # Payment service
└── Mail/                          # Email templates

resources/views/
├── admins/                        # Admin panel templates
├── clients/                       # Customer frontend
└── auth/                          # Authentication forms

database/
├── migrations/                    # Database schema
└── seeders/                       # Test data
```

## Performance Considerations
- Eager loading for relationships to prevent N+1 queries
- Pagination for large data sets
- Image optimization and storage management
- Session-based cart storage for guests
- Database indexing on frequently queried columns

## Development Notes
- Uses soft deletes extensively for data integrity
- Implements repository pattern for complex business logic
- Follows Laravel naming conventions
- Comprehensive input validation
- Error logging and monitoring
- Mobile-responsive design throughout

This documentation provides a comprehensive overview of the Aura World e-commerce platform's architecture, features, and implementation details.
