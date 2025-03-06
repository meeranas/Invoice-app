# My Invoice App

This is a Laravel 11 application using the TALL (Tailwind, Alpine.js, Laravel, Livewire) stack for managing invoices with features like filtering, CRUD operations, and PDF generation.

## 🚀 Installation Guide

### Prerequisites
Make sure you have the following installed:
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL
- Laravel Installer (optional)

### 📥 Clone the Repository
```sh
git clone [URL] 
cd invoice-app
```

### 📦 Install Dependencies
```sh
composer install
npm install && npm run build
```

### 🔧 Set Up Environment
```sh
cp .env.example .env
php artisan key:generate
```

### 🛠 Configure Database
Update your `.env` file with your database credentials:
```env
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```
Then run migrations:
```sh
php artisan migrate --seed
```

### ⚡️ Run the Application
```sh
php artisan serve
```
Now, visit `http://127.0.0.1:8000` in your browser.

---

## 🛠 Livewire & Alpine.js Setup

Livewire is already installed via Composer, but if you need to re-install:
```sh
composer require livewire/livewire
```
Ensure Alpine.js is included in `resources/js/app.js`:
```js
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();
```
Then, recompile assets:
```sh
npm run build
```

---

## 📜 Features
- 📝 CRUD operations for invoices
- 🎨 TailwindCSS styling
- 📑 Invoice status filtering
- 📄 Generate PDF invoices
- 🔄 Livewire-powered UI interactions