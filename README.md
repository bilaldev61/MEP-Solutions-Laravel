# BR MEP Solutions

**Website & Workforce Management System**

`Laravel` `PHP` `SQLite` `TailwindCSS`

A fully functional technical services company website with a complete admin dashboard and workforce management system, built with Laravel 11.

Covers both the public-facing marketing website and an internal admin system for managing leads, employees, attendance, and payments — all amounts in USD.

## 🌐 Website Features

- Modern, clean, responsive UI built with Tailwind CSS
- Home page with hero section, services, and CTA
- Services page dynamically loaded from the database
- About Us page
- Contact page with lead capture form
- ✉️ Instant automated acknowledgement email on every enquiry (Gmail SMTP)
- ☎️ Click-to-Call button on every page
- 💬 WhatsApp floating button on every page
- BR monogram branding and favicon across all pages
- Fully mobile responsive

## 🔐 Admin Panel Features

- Secure login system with **role-based access**
  - **Admin** — full access to everything
  - **Manager** — day-to-day operations: leads (no delete), attendance, read-only employees & payments; no Services, Users or Site Settings
- **Users** — admins create admin/manager logins (name, email, password, role) and can revoke or delete accounts (self-demotion and last-admin deletion are blocked)
- **Site Settings** — edit all website content without touching code (admin only)
- **Customer Leads** — view and manage contact form submissions
- **Services** — add, edit, delete services shown on the website
- **Employees** — full CRUD for employee records (USD salaries)
- **Attendance** — mark daily attendance per employee
- **Payments** — record salary, bonus, and advance payments (USD)
- Responsive layout with an off-canvas sticky sidebar and mobile card views for wide tables
- ⚠️ Seeders create demo logins — admin `test@example.com / password`, manager `manager@example.com / password`. Change both before deploying

## ⚙️ Tech Stack

| Technology | Version |
|---|---|
| PHP | 8.5+ |
| Laravel | 11 |
| Database | SQLite (default) — MySQL compatible |
| Tailwind CSS | 3 |
| Alpine.js | 3 |
| Node.js | 20+ |

## 🚀 Installation

```bash
# Clone the repository
git clone <your-repository-url>

# Install PHP dependencies
composer install

# Install and build frontend assets
npm install
npm run build

# Copy environment file
cp .env.example .env

# Generate app key
php artisan key:generate

# Run migrations and seed all demo data
# (site settings, services, 10 employees, attendance, payments)
php artisan migrate --seed

# Optional: configure SMTP in .env for lead acknowledgement emails
# (Gmail: MAIL_MAILER=smtp, MAIL_HOST=smtp.gmail.com, MAIL_PORT=587,
#  MAIL_USERNAME, MAIL_PASSWORD = app password, MAIL_FROM_ADDRESS)

# Start the server (Windows dev router keeps static assets working)
php -S 127.0.0.1:8000 -t public server.php
```

## 📸 Pages

| Page | Description |
|---|---|
| `/` | Home page |
| `/services` | All services |
| `/about` | About us |
| `/contact` | Contact form |
| `/login` | Admin login |
| `/admin` | Admin dashboard |

## 📁 Project Structure

```
mep-solutions/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── WebsiteController.php    # Public website pages
│   │       └── Admin/                   # All admin controllers
│   └── Mail/                            # Lead acknowledgement email
├── resources/
│   └── views/
│       ├── layouts/                     # Shared layouts (website/admin/guest)
│       ├── website/                     # Public pages
│       ├── admin/                       # Admin pages
│       └── emails/                      # Email templates
├── database/
│   ├── migrations/                      # All database tables
│   └── seeders/                         # Site settings, services, employees, attendance, payments
└── routes/
    └── web.php                          # All routes
```
