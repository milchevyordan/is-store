# 🛍️ IS Store

## About The Project

**Is Store** is a Laravel + Vue.js web application representing a fully functional online shop. The application allows users to browse all products or products organized by categories, add items to a cart, and complete orders. Admins can manage products, categories and orders via CRUD operations.

This project was built to fulfill the task requirements for developing an e-commerce system.

### Features

- Product and Category (CRUD)
- View all products or view by category
- Individual product details page
- Product pagination / Infinite scroll
- Add and remove products from the cart / Change quantity
- Complete orders with customer information
- Manage Orders

### Built With

- [Laravel](https://laravel.com) – v12.x
- [Vue.js](https://vuejs.org) – v3
- [Inertia.js](https://inertiajs.com) – v2
- MySQL

---

## Getting Started

These instructions will help you set up the project on your local development environment.

### Prerequisites

- PHP >= 8.2
- Composer
- Node.js & npm
- MySQL / MariaDB

### Installation

1. **Clone the repository**

   ```bash
   git clone https://github.com/milchevyordan/is-store.git
   cd is-store
   ```

2. **Install dependencies**

   ```bash
   composer install
   npm install && npm run build
   ```

3. **Create environment file**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure your ****\`\`**** file** with DB credentials:

   ```env
   DB_DATABASE=is-store
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Set up the database** — choose one of the two options below:

   **Option 1: Import the SQL dump**

   ```sql
   -- in phpMyAdmin or MySQL CLI
   source is-store/is-store.sql;
   ```

   **Option 2: Run migrations and seeders**

   ````bash
   php artisan migrate --seed
   ````

6. **Serve the application**

   ```bash
   php artisan serve
   ```

## Admin Credentials

Use the following credentials to log in as an admin:

- **Email:** test@example.com
- **Password:** 123456789
---

## Usage

1. Browse products by category
2. View product details
3. Add products to cart
4. Complete order by filling in name, address, phone, and email
5. (If admin) Manage products, categories, and view orders

---

## Admin Features

- Product and category CRUD
- View and manage orders

---

## Contact

Developed by **Yordan Milchev**  
GitHub: [@milchevyordan](https://github.com/milchevyordan)  
Email: milchevyordan2@gmail.com

---

## Acknowledgments

- [Laravel Documentation](https://laravel.com/docs)
- [Vue.js Documentation](https://vuejs.org/guide/)
- [Inertia.js Documentation](https://inertiajs.com)
- [phpMyAdmin](https://www.phpmyadmin.net/)
