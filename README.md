# Car Rental System

A complete **Car Rental System** built with **Laravel** that enables users to browse vehicles, make reservations with availability validation, calculate rental costs, and allows administrators to manage bookings, vehicles, and rental statuses efficiently.

---

## Features

### Authentication

-   User registration
-   User login & logout
-   Secure authentication

### Vehicle Showcase

-   Browse available rental cars
-   View vehicle details
-   Check vehicle availability

### Booking System

-   Reserve vehicles online
-   Automatic availability validation
-   Prevent double bookings for the same vehicle and rental period

### Rental Cost Calculation

-   Daily rental pricing
-   Optional driver fee
-   Optional fuel (BBM) fee
-   Automatic total price calculation based on rental duration

### Vehicle Status Tracking

Vehicles can have different statuses, including:

-   Ready
-   Rented
-   Pending
-   Cancelled

### Admin Dashboard

-   Manage vehicles
-   Manage bookings
-   Manage users
-   Monitor vehicle availability
-   Update rental statuses
-   View reservation history

---

## Built With

-   Laravel
-   Blade
-   MySQL
-   Bootstrap
-   JavaScript

---

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/your-username/car-rental-system.git
cd car-rental-system
```

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Copy environment file

```bash
cp .env.example .env
```

### 4. Generate application key

```bash
php artisan key:generate
```

### 5. Configure your database

Edit the `.env` file.

```env
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 6. Run migrations

```bash
php artisan migrate
```

### 7. (Optional) Seed the database

```bash
php artisan db:seed
```

### 8. Build frontend assets

```bash
npm run dev
```

### 9. Start the development server

```bash
php artisan serve
```

Open:

```
http://127.0.0.1:8000
```

---

## Project Structure

```
app/
database/
public/
resources/
routes/
storage/
```

---
