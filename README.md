# Courier Management API

[![Laravel Version](https://img.shields.io/badge/laravel->=11.x-red.svg)](https://laravel.com)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

A robust, lightweight, and high-performance RESTful API service built with Laravel to manage courier/driver logistics master data. This micro-module provides advanced sorting, partial multi-word keyword search matching, structural multi-level capability filtering, and enterprise-grade data validation.

Designed specifically as a headless backend module (No UI/HTML overhead), it utilizes SQLite for ultra-fast operation and effortless zero-configuration deployments.

---

## 🛠️ Key Architectural Features

- **Decoupled Backend Architecture**: Clean API Resource representation, completely independent of any Frontend library.
- **Advanced Query Filtering Engine**:
  - **Dynamic Multi-Word Search**: Intelligently breaks down query fragments (e.g., ?search=budi+agung) to evaluate and match comprehensive text variations (e.g., Budiono Hadi Agung).
  - **Categorical Array Filters**: Allows composite state or level evaluations (e.g., ?level=2,3).
  - **Fluid Override Ordering**: Seamlessly switches between alpha-sorting (name) and chronological audit tracks (created_at).
- **Complete Feature Test Coverage**: Full suite of programmatic assertions evaluating positive execution pipelines, edge cases, and request bounds validation.

---

## 🏗️ Technical Blueprint & Schema

The data layer models a typical logistical courier node mapped with the following core constraints:

| Column | Data Type | Attributes / Constraints | Description |
| :--- | :--- | :--- | :--- |
| id | BigInteger | Primary Key, Auto-Increment | Unique identifier. |
| name | String | Required, Max: 255 | Legal name of the carrier. |
| phone_number | String | Required, Unique, Max: 20 | Unique contact index. |
| vehicle_type | String | Required, Max: 50 | Category representation (e.g., Motorcycle, Van). |
| level | TinyInteger | Required, Default: 1, Range: 1-5 | Functional tier classification. |
| is_active | Boolean | Default: true | Soft operational availability state flag. |
| timestamps | Datetime | Nullable | Tracks system entry (created_at, updated_at). |

---

## 🚀 Getting Started (Local Development)

### Prerequisites
Ensure your server environment matches the following standard setup requirements:
- PHP >= 8.2 (with JSON, SQLite, and PDO extensions enabled)
- Composer Package Manager

### 1. Installation & Environment Configuration
Clone the official repository branch directly from GitHub:
git clone https://github.com/machrusali/courier-api.git
cd courier-api

Instantiate environmental configurations:
cp .env.example .env

Ensure that your .env contains the required flat-file driver specification:
DB_CONNECTION=sqlite

### 2. Dependency Resolution & Database Provisioning
Install production and development vendors, build the local target database storage file, and process migration schemas:
composer install
touch database/database.sqlite
php artisan migrate

### 3. Execution
Fire up the built-in HTTP server gateway:
php artisan serve

The endpoint collection will now actively listen to ingress networking data at http://127.0.0.1:8000/api.

---

## 📌 API Reference Manual

Every request must include the header Accept: application/json.

### 🔹 1. Fetch Collection
- HTTP Method: GET
- URI Path: /api/couriers
- Supported Query Modifiers:
  - sort: Defines sequence strategy (name [Default] or created_at).
  - search: Full text string parsing. Splits terms dynamically (e.g., ?search=budi+agung).
  - level: Discrete numerical constraint arrays separated by commas (e.g., ?level=2,3).

### 🔹 2. Create Instance
- HTTP Method: POST
- URI Path: /api/couriers
- Payload Schema JSON:
{
    "name": "Budiono Hadi Agung",
    "phone_number": "081234567890",
    "vehicle_type": "Motorcycle",
    "level": 3
}

### 🔹 3. Retrieve Resource Instance
- HTTP Method: GET
- URI Path: /api/couriers/{id}

### 🔹 4. Update Resource State
- HTTP Method: PUT / PATCH
- URI Path: /api/couriers/{id}

### 🔹 5. Terminate Instance
- HTTP Method: DELETE
- URI Path: /api/couriers/{id}

---

## 🧪 Automated Testing Suite

The codebase enforces testing guidelines via continuous isolation patterns. To run the automated feature suites across the controllers and filters, execute:

php artisan test