# Shipment Tracking System

A **Shipment Tracking Web Application** built with **Laravel 12** using **Server-Side Rendering (SSR)**.  
The application allows users to manage shipments, track shipment status, and view shipment history.

---

# Objective

To build a shipment tracking system where users can:

- View a list of shipments
- Search, sort, and paginate shipments
- View shipment details with status timeline
- Add new shipments
- Update shipment status directly from the list

---

# Tech Stack

- PHP 8.2+
- Laravel 12
- MySQL
- Blade Templates (SSR)
- Bootstrap 5
- jQuery DataTables

---

## Installation & Setup

### 1. Clone the repository
```bash
git clone https://github.com/irfan-pathan/shipment-tracking-system.git
cd shipment-tracker
```

### 2. Install dependencies
```bash
composer install
```

### 3. Environment setup
```bash
cp .env.example .env
```

Update database credentials in `.env`.

---

### 4. Run migrations and seeders
```bash
php artisan migrate --seed
```

---

### 5. Start the application
```bash
php artisan serve
```

Open in browser:
```
http://127.0.0.1:8000/shipments
```

---

# Seeder

The application includes a seeder that generates:
- Fake shipment records
- Realistic shipment status timelines

Seeder file:
```
database/seeders/ShipmentSeeder.php
```
---

# Server-Side Rendering (SSR)

This project uses **Laravel Blade templates** to render HTML on the server.  
All pages are fully rendered on the backend and sent to the browser, providing:

- Faster initial page load
- SEO-friendly pages
- Simple MVC architecture
