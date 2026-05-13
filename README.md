# WasteWiseTn

A modular **Symfony 7.3** web platform for smart waste management, citizen engagement, and valorizer/admin workflows.

## Table of Contents

1. [Overview](#overview)
2. [Core Features](#core-features)
3. [Tech Stack](#tech-stack)
4. [Project Structure](#project-structure)
5. [Prerequisites](#prerequisites)
6. [Configuration](#configuration)
7. [Installation](#installation)
8. [Build and Run](#build-and-run)
9. [Roles and Access Control](#roles-and-access-control)
10. [Troubleshooting](#troubleshooting)
11. [Developers](#developers)

---

## Overview

WasteWiseTn is a PHP 8.2 + Symfony 7.3 web application that supports multiple user roles — **Citizen (Citoyen), Valorizer (Valorisateur), Admin, Organizer, Partner (Partenaire)** — through a role-aware UI. It centralizes waste declaration flows, dashboards, statistics, map-based views, event participation, face login, QR-based validation, 2FA, and AI-powered features.

---

## Core Features

### Authentication & Security
- Email/password login with email verification
- OAuth2 social login: **Google, Facebook, GitHub**
- Face login and face enrollment (via Vision API)
- Two-factor authentication (TOTP — Google Authenticator)
- Password reset flow
- User active/inactive checker

### Citizen Area (`/dashboard/citoyen`)
- Waste declaration and history
- Polluted zone reporting and map view
- Air quality monitoring (OpenAQ API)
- Weather information
- News feed (News API)
- Eco-points tracking
- Calendar of events

### Valorizer Area (`/dashboard/valorisateur`)
- Received waste management
- Valorization workflow
- QR code scanning and validation
- Impact indicators and statistics
- Wallet and Stripe withdrawal
- Appel d'offres (tender calls) and responses

### Admin Area (`/admin`, `/back/dashboard`)
- User management (promote, ban, activate)
- Waste type and declaration management
- Polluted zone management
- Dashboard with advanced monitoring
- Notification system
- Intelligent dashboard with AI insights

### Event Management
- Event creation and management
- Participation tracking
- Partner badges (`BadgePartenaire`)
- Calendar integration

### External Integrations
- **Stripe** — wallet withdrawals
- **Gemini AI** — intelligent dashboard
- **HuggingFace** — AI features
- **OpenAQ** — air quality data
- **News API** — news feed
- **Leaflet Maps** — interactive maps
- **QR Code** (endroid/qr-code) — generation and scanning
- **PDF** (dompdf) — report generation
- **Mailer** (Symfony Mailer + Gmail) — transactional emails

---

## Tech Stack

| Technology | Version / Notes |
|---|---|
| PHP | >= 8.2 |
| Symfony | 7.3.* |
| Doctrine ORM | ^3.6 |
| Database | MySQL / MariaDB |
| Frontend | Twig + Webpack Encore + Stimulus |
| Maps | Symfony UX Leaflet |
| Charts | Symfony UX Chart.js |
| 2FA | scheb/2fa-bundle + Google Authenticator |
| OAuth2 | knpuniversity/oauth2-client-bundle |
| QR Codes | endroid/qr-code-bundle |
| PDF | dompdf/dompdf |
| Payments | Stripe |
| AI | Gemini API, HuggingFace |
| Email | Symfony Mailer (Gmail transport) |
| Testing | PHPUnit 11, PHPStan |

---

## Project Structure

```
PiDev/
├── assets/                  # JS, CSS, Stimulus controllers
├── config/
│   ├── packages/            # Bundle configuration (security, doctrine, mailer…)
│   └── routes/              # Route imports
├── migrations/              # Doctrine database migrations
├── public/                  # Web root (index.php, built assets)
├── src/
│   ├── Command/             # CLI commands (make:admin, promote role…)
│   ├── Controller/          # All HTTP controllers
│   ├── Entity/              # Doctrine entities
│   ├── EventSubscriber/     # Kernel event subscribers
│   ├── Form/                # Symfony form types
│   ├── Repository/          # Doctrine repositories
│   ├── Security/            # Authenticators, 2FA, checkers
│   └── Service/             # Business logic services
├── templates/               # Twig templates
├── tests/                   # PHPUnit tests
├── .env                     # Environment variables (defaults)
├── composer.json
└── package.json
```

---

## Prerequisites

- PHP >= 8.2 (with extensions: `ctype`, `iconv`, `gd`)
- Composer
- Node.js + npm (for frontend assets)
- MySQL / MariaDB
- Symfony CLI (recommended)

---

## Configuration

Copy `.env` and create a local override:

```bash
cp .env .env.local
```

Edit `.env.local` with your values:

```dotenv
# Database
DATABASE_URL="mysql://root:password@127.0.0.1:3306/pidev?serverVersion=10.4.32-MariaDB&charset=utf8mb4"

# Mailer
MAILER_DSN=gmail://USERNAME:PASSWORD@default

# OAuth2
GOOGLE_CLIENT_ID=...
GOOGLE_CLIENT_SECRET=...
FACEBOOK_CLIENT_ID=...
FACEBOOK_CLIENT_SECRET=...
GITHUB_CLIENT_ID=...
GITHUB_CLIENT_SECRET=...

# Stripe
STRIPE_SECRET_KEY=sk_test_...

# External APIs
GEMINI_API_KEY=...
HUGGINGFACE_API_KEY=...
NEWS_API_KEY=...
OPENAQ_API_KEY=...
```

> Never commit `.env.local` or any file containing real secrets.

---

## Installation

```bash
# Install PHP dependencies
composer install

# Install JS dependencies
npm install

# Create the database and run migrations
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

# Build frontend assets
npm run build
```

---

## Build and Run

Using the Symfony CLI (recommended):

```bash
symfony server:start
```

Or with the built-in PHP server:

```bash
php -S localhost:8000 -t public/
```

For development with live asset rebuilding:

```bash
npm run watch
```

Useful console commands:

```bash
# Clear cache
php bin/console cache:clear

# Promote a user to admin
php bin/console app:make-admin <email>

# Promote a user role
php bin/console app:promote-user-role <email> <role>
```

---

## Roles and Access Control

| Role | Access |
|---|---|
| `PUBLIC_ACCESS` | Login, register, password reset, OAuth, face login |
| `ROLE_USER` | Citizen dashboard, profile, event participation, 2FA setup |
| `ROLE_VALORIZER` | Valorizer dashboard, QR scan, wallet, tenders |
| `ROLE_ADMIN` | Admin panel, user management, all declarations, monitoring |

---

## Troubleshooting

### Database connection error
Verify `DATABASE_URL` in `.env.local` and that your MySQL server is running.

### Assets not loading
Run `npm run build` (or `npm run watch` in dev). Make sure `public/build/` is populated.

### Mailer not sending
Check `MAILER_DSN` in `.env.local`. For local development, use [Mailpit](https://github.com/axllent/mailpit) (included in the project) or set `MAILER_DSN=null://null` to disable sending.

### 2FA not working
Ensure `scheb/2fa-bundle` is properly configured in `config/packages/scheb_2fa.yaml` and that the user has a TOTP secret set.

### Cache issues after config changes
```bash
php bin/console cache:clear
```

---

## Developers

Developed by:

- **Eya Ben Hassine**
- **Louay Houimli**
- **Khalil Sammoudy**
- **Islem Hadriche**
- **Mohammed Ghammam**
