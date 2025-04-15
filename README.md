# PHP Developer Test Assignment

This repository contains the solution for the PHP Developer Test Assignment provided by [abz.agency](http://www.abz.agency). It demonstrates a RESTful API using Laravel, including image handling, data seeding, and frontend integration.

## 🔗 Live Demo

[View Deployed Project](https://test-assignment-main-4oqw5j.laravel.cloud)

## 📂 Project Structure

- 4 GET requests and 1 POST for API Server
- Form to create a record and section to list records
- In order to make POST reequest you need to first get a one-time use token

## 📌 Features

### ✅ REST API

- Built using Laravel 12
- Follows the provided [OpenAPI Specification](https://openapi_apidocs.abz.dev/frontend-test-assignment-v1)

### ✅ Image Handling

- Center-cropped image to 70x70 JPG
- Optimized via [TinyPNG](https://tinypng.com/)
- When truncating the DB you can run a command to clear storage from all images since they are unused:
    ```bash
    php artisan app:clear-storage
    ```

### ✅ Authentication

- Basic token-based authentication implemented

### ✅ Seeder & Data Generation

- 45 fake users generated using Laravel Seeder and Faker
- Realistic user-like data

### ✅ Frontend (Minimal UI)

- Display paginated list of users (6 per page)
- "Show more" button
- Add new user form (no frontend validation)

## ⚙️ Technologies Used

- PHP 8
- Laravel 12
- MySQL
- [TinyPNG API](https://tinypng.com/)
- Laravel Faker
- [ThisPersonDoesNotExist](https://thispersondoesnotexist.com/) for fake images
- HTML & Tailwind & JavaScript for frontend

## 🛠 Setup & Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/denysbelskiy/test_assignment
   cd test_assignment
   composer install
   ```
2. Then create .env file:
    ```bash
    cp .env.example .env
    ```
    then set up prefered database add `TINIFY_API_KEY` and set `SESSION_DRIVER` to `file`
3. Run migrations and seeder:
    ```bash
    php artisan migrate
    php artisan db:seed
    ```
4. Run the code localy:
    ```bash
    php artisan serve
    ```