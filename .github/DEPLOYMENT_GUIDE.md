# PBZ LMS &mdash; CI/CD Deployment Guide

This repository is configured with automated **GitHub Actions** for **Continuous Integration (CI)** and **Continuous Deployment (CD)**.

---

## 1. Continuous Integration (CI) Pipeline

**File:** `.github/workflows/ci.yml`  
**Triggers:** Pushes and Pull Requests on `main`, `master`, and `develop`.

### What it does:
1. Provisions Ubuntu runner with **PHP 8.3** and all required banking LMS extensions (`mbstring`, `dom`, `pdo_sqlite`, `pdo_mysql`, `gd`, `bcmath`, `curl`, `intl`).
2. Provisions **Node.js 20**.
3. Caches Composer packages and NPM modules to ensure rapid pipeline execution.
4. Runs `composer install` and `npm run build` (Vite asset packaging).
5. Prepares isolated testing environment with dedicated application key.
6. Executes code style checks using **Laravel Pint**.
7. Executes unit and feature tests using **PHPUnit**.

---

## 2. Continuous Deployment (CD) Pipeline

**File:** `.github/workflows/cd.yml`  
**Triggers:** Pushes to `main` branch or manual trigger via **GitHub Actions > Run workflow**.

### Required GitHub Secrets for SSH Deployment:
Navigate to your GitHub repository:  
**Settings > Secrets and variables > Actions > New repository secret**

| Secret Name | Description | Example |
| :--- | :--- | :--- |
| `SSH_HOST` | Production server IP address or domain | `192.168.1.100` or `lms.pbzbank.co.tz` |
| `SSH_USER` | SSH username on deployment server | `deployer` or `ubuntu` |
| `SSH_KEY` | Private SSH Key (RSA or Ed25519) | `-----BEGIN OPENSSH PRIVATE KEY----- ...` |
| `SSH_PORT` | SSH Port (Optional, default: 22) | `22` |
| `DEPLOY_PATH` | Absolute path to the web directory | `/var/www/pbzlms` or `/Applications/MAMP/htdocs/pbzlms` |
| `SSH_PASSPHRASE`| Passphrase if the SSH key is encrypted | *(optional)* |

### Alternative: Webhook Deployment (e.g. Laravel Forge / Coolify / RunCloud):
If you use a deployment webhook URL:
| Secret Name | Description |
| :--- | :--- |
| `DEPLOY_WEBHOOK_URL` | Fast-path deploy trigger URL |

---

## 3. Deployment Steps Executed on Server:
1. `php artisan down` (Activates 503 maintenance mode with retry headers)
2. `git pull origin main` (Fetches latest tested code)
3. `composer install --no-dev --optimize-autoloader`
4. `php artisan migrate --force` (Applies zero-downtime DB migrations)
5. `php artisan optimize:clear && php artisan config:cache && php artisan route:cache && php artisan view:cache`
6. `npm ci && npm run build` (Compiles production Vite assets)
7. `php artisan queue:restart` (Refreshes worker processes)
8. `php artisan up` (Brings platform live)
