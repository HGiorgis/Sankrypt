# 🛡️ Sankrypt API

**Ancient wisdom, modern encryption.**

Sankrypt is a secure, API-driven password and secret management system that merges **African heritage** with **modern cryptographic design**.  
Inspired by the Akan concept of **Sankofa** — *“return and get it”* — Sankrypt learns from the principles of ancient guardianship to protect digital assets today.

---

## 🌍 Overview

Sankrypt provides a **secure, modular API layer** for managing:
- 🔐 Encrypted vaults (passwords, keys, or sensitive data)
- 👤 User authentication and identity
- 🧠 Configurable security and access policies

The system is designed for **frontend clients** or **third-party services** that need a strong cryptographic backend with API-based control.

Built using **Laravel** and **Sanctum**, it follows modern principles of **zero-knowledge design** and **defense-in-depth**.

---

## ⚙️ Features

| Category | Description |
|-----------|-------------|
| **Authentication** | Token-based authentication using Laravel Sanctum |
| **Vault System** | Encrypted, user-scoped storage for sensitive items |
| **Access Logging** | Every action is logged with IP, user agent, and status |
| **User Management** | Secure registration, login, logout, and password rotation |
| **Security Settings** | Configurable user preferences and system hardening |
| **Categorized Vaults** | Organize and retrieve vault items by category |
| **Error-Safe API Design** | Consistent JSON responses and error handling |

---

## 🧩 Tech Stack

- **Framework:** Laravel 10+ (PHP 8.2+)  
- **Auth:** Laravel Sanctum (token-based)  
- **Database:** MySQL / PostgreSQL  
- **Encryption:** Client-side encryption; backend stores only encrypted blobs  
- **Logging:** AccessLog model for all user actions  

---

## 🚀 API Endpoints

### 🔑 Authentication Routes

| Method | Endpoint | Description |
|--------|-----------|-------------|
| `POST` | `/api/register` | Register a new user with email and `auth_key_hash` |
| `POST` | `/api/login` | Log in using email + derived `auth_key_hash` |
| `POST` | `/api/logout` | Revoke the current user’s token |
| `GET` | `/api/user` | Get current authenticated user details |
| `POST` | `/api/auth/change-password` | Change authentication key hash |

---

### 👤 User Routes

| Method | Endpoint | Description |
|--------|-----------|-------------|
| `PUT` | `/api/user/preferences` | Update user preferences (JSON structure) |
| `GET` | `/api/user/security-settings` | Retrieve security settings and login history |

---

### 🏺 Vault Routes

| Method | Endpoint | Description |
|--------|-----------|-------------|
| `GET` | `/api/vault` | List all vault items for current user |
| `POST` | `/api/vault` | Store a new encrypted vault item |
| `GET` | `/api/vault/{id}` | Retrieve specific vault item |
| `PUT` | `/api/vault/{id}` | Update an existing vault item |
| `DELETE` | `/api/vault/{id}` | Delete vault item |
| `GET` | `/api/vault/category/{category}` | Get vault items by category |

---

## 🔐 Security Philosophy

Sankrypt is built on **privacy-first** principles:

- **Zero-Knowledge Backend:**  
  The server never sees or stores plain credentials — only encrypted blobs and salted hashes.

- **Auditable Actions:**  
  Every API interaction creates an `AccessLog` entry, recording:
  - user ID  
  - IP address  
  - user agent  
  - action performed  
  - success or failure  
  - optional details  

- **Cryptographic Integrity:**  
  Each vault item includes a `data_hash` field (128-char) to detect tampering.

---

## 🧠 Data Models

### `User`
| Field | Type | Description |
|-------|------|-------------|
| `email` | string | Unique user email |
| `auth_key_hash` | string(64) | Hash of the derived client-side key |
| `preferences` | JSON | Optional user settings |
| `security_settings` | JSON | Security configuration (2FA, lock, etc.) |
| `password_changed_at` | timestamp | When password last changed |
| `last_login_at` | timestamp | Last login time |

---

### `Vault`
| Field | Type | Description |
|-------|------|-------------|
| `user_id` | foreign key | Owner |
| `category` | string | Logical grouping (e.g., “banking”, “work”) |
| `encrypted_data` | text | Encrypted JSON or blob |
| `encryption_salt` | string | Salt used for encryption |
| `data_hash` | string(128) | Integrity hash |
| `version` | int | Version control for updates |
| `last_accessed_at` | timestamp | Auto-updated on access |

---

### `AccessLog`
| Field | Type | Description |
|-------|------|-------------|
| `user_id` | foreign key | User performing the action |
| `action` | string | Action name (e.g., `vault_store`, `login`) |
| `ip_address` | string | IP of the request |
| `user_agent` | string | Client agent |
| `success` | boolean | Action result |
| `details` | text | Optional context |

---

## 🧭 Example Workflow

1. **User registers** with email + a client-generated `auth_key_hash`.
2. **Frontend stores encryption key locally** (never sent to API).
3. User logs in → receives a **Sanctum API token**.
4. User encrypts data locally → sends encrypted blob to `/api/vault`.
5. Sankrypt stores and indexes the encrypted item.
6. On retrieval, Sankrypt returns the blob → client decrypts locally.
7. All actions are logged in `AccessLog`.

---

## 🧰 Developer Setup

### Prerequisites
- PHP 8.2+
- Composer
- MySQL/PostgreSQL
- Laravel CLI

### Installation

```bash
git clone https://github.com/HGiorgis/Sankrypt.git
cd Sankrypt
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
