# Book Management System

A comprehensive CRUD (Create, Read, Update, Delete) application built with Laravel for managing books, book categories, and tracking book borrowings/returns with automatic stock management.

## 📋 Table of Contents

- [Features](#features)
- [Technology Stack](#technology-stack)
- [Requirements](#requirements)
- [Installation](#installation)
- [Database Schema](#database-schema)
- [Project Structure](#project-structure)
- [Routes](#routes)
- [Key Features](#key-features)
- [Usage Guide](#usage-guide)
- [Screenshots](#screenshots)

## ✨ Features

### Part 01: Book Management
- ✅ **Database Tables:**
  - `books` table with fields: id, title, author, price, stock, book_category_id, created_at, updated_at
  - `book_cate` table with fields: id, name, created_at, updated_at
- ✅ **Book Categories:** 5 pre-seeded categories (Fiction, Non-Fiction, Science, History, Technology)
- ✅ **Book Listing:** Display all books with details (title, author, price, stock, category)
- ✅ **Category Filtering:** Filter books by category on the homepage
- ✅ **Add Books:** Form to add new books with category selection
- ✅ **Edit Books:** Update book details including stock
- ✅ **Delete Books:** Remove books from the system
- ✅ **View Book Details:** Display individual book with borrowing history

### Part 02: Borrowing System
- ✅ **Users Table:** Complete user management system with name, email, phone, and address
- ✅ **Borrowing Tracking:** Mapping table (`book_borrowings`) to track book issuance and returns
- ✅ **Automatic Stock Management:**
  - Stock automatically decreases when a book is issued
  - Stock automatically increases when a book is returned
  - Out of stock message displayed when stock reaches zero
  - Books with zero stock cannot be borrowed
- ✅ **Form Validation:** 
  - Title and author fields are required
  - Price and stock must be valid numbers
  - All validations implemented with proper error messages
- ✅ **Safety Features:**
  - Prevents double-borrowing (same user cannot borrow same book twice if not returned)
  - Prevents deleting categories that have books assigned
  - Stock restoration when borrowing records are deleted

## 🛠 Technology Stack

- **Framework:** Laravel 12.0
- **PHP Version:** 8.2+
- **Database:** MySQL/MariaDB
- **Frontend:** Blade Templates with Bootstrap
- **ORM:** Eloquent
- **Package Manager:** Composer

## 📦 Requirements

- PHP >= 8.2
- Composer
- MySQL/MariaDB (or any supported database)
- Git
- Web Server (Apache/Nginx) or PHP Built-in Server

## 🚀 Installation

### Step 1: Clone the Repository

```bash
git clone https://github.com/YOUR_USERNAME/book-management.git
cd book-management
```

### Step 2: Install Dependencies

```bash
composer install
```

### Step 3: Environment Setup

Copy the `.env.example` file to `.env`:

**Windows:**
```bash
copy .env.example .env
```

**Linux/Mac:**
```bash
cp .env.example .env
```

Generate application key:
```bash
php artisan key:generate
```

### Step 4: Database Configuration

1. Create a database in MySQL:
```sql
CREATE DATABASE book_management;
```

2. Edit the `.env` file and configure your database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=book_management
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Step 5: Run Migrations and Seeders

```bash
php artisan migrate
php artisan db:seed
```

This will:
- Create all necessary tables (users, book_cate, books, book_borrowings)
- Seed 5 book categories (Fiction, Non-Fiction, Science, History, Technology)
- Create 3 sample users (Kasun Silva, Malshi Perera, Savindu fernando)

### Step 6: Start the Development Server

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser. The application will redirect to `/books`.

## 📊 Database Schema

### users
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key, auto-increment |
| name | string | User's full name |
| email | string | Unique email address |
| phone | string (nullable) | Phone number |
| address | string (nullable) | Physical address |
| created_at | timestamp | Record creation time |
| updated_at | timestamp | Record last update time |

### book_cate
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key, auto-increment |
| name | string | Category name (unique) |
| created_at | timestamp | Record creation time |
| updated_at | timestamp | Record last update time |

### books
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key, auto-increment |
| title | string | Book title |
| author | string | Book author |
| price | decimal(8,2) | Book price |
| stock | integer | Available stock count |
| book_category_id | bigint | Foreign key → book_cate.id |
| created_at | timestamp | Record creation time |
| updated_at | timestamp | Record last update time |

**Foreign Key:** `book_category_id` references `book_cate(id)` with cascade delete

### book_borrowings
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key, auto-increment |
| user_id | bigint | Foreign key → users.id |
| book_id | bigint | Foreign key → books.id |
| issued_at | datetime (nullable) | When book was issued |
| returned_at | datetime (nullable) | When book was returned (null = not returned) |
| created_at | timestamp | Record creation time |
| updated_at | timestamp | Record last update time |

**Foreign Keys:**
- `user_id` references `users(id)` with cascade delete
- `book_id` references `books(id)` with cascade delete

## 📁 Project Structure

```
app/
├── Http/
│   └── Controllers/
│       ├── BookController.php              # Book CRUD operations
│       ├── BookBorrowingController.php     # Borrowing/Return operations
│       └── BookCategoryController.php      # Category management
├── Models/
│   ├── Book.php                            # Book model with relationships
│   ├── BookBorrowing.php                   # Borrowing model with helper methods
│   ├── BookCategory.php                    # Category model
│   └── User.php                            # User model with relationships

database/
├── migrations/
│   ├── 0001_01_01_000000_create_users_table.php
│   ├── 2025_12_03_130202_create_book_categories_table.php
│   ├── 2025_12_03_130203_create_books_table.php
│   └── 2025_12_03_131523_create_book_borrowings_table.php
└── seeders/
    ├── BookCategorySeeder.php              # Seeds 5 categories
    ├── UserSeeder.php                      # Seeds 3 sample users
    └── DatabaseSeeder.php                  # Main seeder

resources/
└── views/
    ├── books/                              # Book management views
    │   ├── index.blade.php                 # List all books with filter
    │   ├── create.blade.php                # Add new book form
    │   ├── edit.blade.php                  # Edit book form
    │   └── show.blade.php                  # Book details view
    ├── borrowings/                         # Borrowing management views
    │   ├── index.blade.php                # List all borrowings
    │   ├── create.blade.php               # Issue book form
    │   ├── edit.blade.php                 # Edit borrowing form
    │   └── show.blade.php                 # Borrowing details view
    ├── categories/                         # Category management views
    │   ├── index.blade.php                # List all categories
    │   ├── create.blade.php               # Add category form
    │   ├── edit.blade.php                 # Edit category form
    │   └── show.blade.php                 # Category details view
    └── layouts/
        └── app.blade.php                   # Main layout template

routes/
└── web.php                                 # All application routes
```

## 🛣 Routes

### Book Routes (Resource)
- `GET /books` - List all books (with category filter)
- `GET /books/create` - Show create book form
- `POST /books` - Store new book
- `GET /books/{id}` - Show book details
- `GET /books/{id}/edit` - Show edit book form
- `PUT/PATCH /books/{id}` - Update book
- `DELETE /books/{id}` - Delete book

### Borrowing Routes (Resource)
- `GET /borrowings` - List all borrowings
- `GET /borrowings/create` - Show issue book form
- `POST /borrowings` - Issue a book (reduces stock)
- `GET /borrowings/{id}` - Show borrowing details
- `GET /borrowings/{id}/edit` - Show edit borrowing form
- `PUT/PATCH /borrowings/{id}` - Update borrowing record
- `DELETE /borrowings/{id}` - Delete borrowing record (restores stock if not returned)
- `POST /borrowings/{id}/return` - Return a book (increases stock)

### Category Routes (Resource)
- `GET /categories` - List all categories with book counts
- `GET /categories/create` - Show create category form
- `POST /categories` - Store new category
- `GET /categories/{id}` - Show category with all books
- `GET /categories/{id}/edit` - Show edit category form
- `PUT/PATCH /categories/{id}` - Update category
- `DELETE /categories/{id}` - Delete category (only if no books assigned)

### Home Route
- `GET /` - Redirects to `/books`

## 🔑 Key Features Implementation

### Automatic Stock Management
- **On Issue:** When a book is issued via `POST /borrowings`, the stock count automatically decreases using `$book->decrement('stock')`
- **On Return:** When a book is returned via `POST /borrowings/{id}/return`, the stock count automatically increases using `$book->increment('stock')`
- **Out of Stock Protection:** 
  - Books with `stock <= 0` are filtered out in the issue form
  - System displays "Out of Stock" message when stock reaches zero
  - Prevents issuing books with zero stock

### Validation Rules

**Book Creation/Update:**
```php
'title' => 'required|string'
'author' => 'required|string'
'price' => 'required|numeric'
'stock' => 'required|integer'
'book_category_id' => 'required|exists:book_cate,id'
```

**Borrowing:**
```php
'user_id' => 'required|exists:users,id'
'book_id' => 'required|exists:books,id'
```

**Category:**
```php
'name' => 'required|string|max:255|unique:book_cate,name'
```

### Safety Features
- **Double-Borrowing Prevention:** Checks if user already has the same book borrowed (not returned) before allowing new issue
- **Category Deletion Protection:** Prevents deleting categories that have books assigned
- **Stock Restoration:** When a borrowing record is deleted, stock is restored if the book was not yet returned
- **Book Change Handling:** When updating a borrowing record, stock is properly adjusted for both old and new books

### Model Relationships

**Book Model:**
- `belongsTo(BookCategory)` - Each book belongs to a category
- `hasMany(BookBorrowing)` - Each book can have multiple borrowing records

**BookCategory Model:**
- `hasMany(Book)` - Each category can have multiple books

**BookBorrowing Model:**
- `belongsTo(User)` - Each borrowing belongs to a user
- `belongsTo(Book)` - Each borrowing belongs to a book
- Helper methods: `isActive()`, `getDaysHeld()`

**User Model:**
- `hasMany(BookBorrowing)` - Each user can have multiple borrowing records

## 📖 Usage Guide

### Adding a Book
1. Navigate to `/books` or click "Add New Book"
2. Fill in the form:
   - Title (required)
   - Author (required)
   - Price (required, numeric)
   - Stock (required, integer)
   - Category (required, select from dropdown)
3. Click "Submit" or "Save"
4. Book is added and stock is set

### Issuing a Book
1. Navigate to `/borrowings` or click "Issue Book"
2. Select a user from the dropdown
3. Select a book (only books with stock > 0 are shown)
4. Click "Issue"
5. Stock automatically decreases by 1
6. Borrowing record is created with `issued_at` timestamp

### Returning a Book
1. Navigate to `/borrowings`
2. Find the borrowing record (look for records with "Active" status)
3. Click "Return" button
4. Book is marked as returned (`returned_at` is set)
5. Stock automatically increases by 1

### Filtering Books by Category
1. Navigate to `/books`
2. Use the category dropdown filter at the top
3. Select a category to filter books
4. Select "All Categories" to show all books

### Managing Categories
1. Navigate to `/categories`
2. View all categories with book counts
3. Add new categories (name must be unique)
4. Edit existing categories
5. Delete categories (only if no books are assigned)

## 📸 Sample Data

After running `php artisan db:seed`, you'll have:

**5 Categories:**
- Fiction
- Non-Fiction
- Science
- History
- Technology

**3 Users:**
- Kasun Silva (kasun5@gmail.com, 0765221472, 123 Main St)
- Malshi Perera (pereramal@gmail.com, 0777521488, No.456 Kochchikade, Negombo)
- Savindu fernando (savi18fdo@gmail.com, 0716353417, 233/B, Colombo 2)

