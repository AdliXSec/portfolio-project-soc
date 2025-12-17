# Portfolio Project SOC

<div align="center">
  <h1>Naufal's Portfolio & Integrated Mini-SIEM</h1>
  <p>
    A personal portfolio website built with Laravel, featuring a custom-built, integrated "Mini-SIEM" system for real-time threat detection, logging, and response.
  </p>
</div>

---

## ✨ About The Project

This project is a personal portfolio website designed not only to showcase projects and skills but also to serve as a practical demonstration of advanced, custom-built security features. It includes a fully integrated **Mini-SIEM** (Security Information and Event Management) system that actively detects, logs, and responds to common web threats in real-time.

The entire system, from content management to security monitoring, is managed through a comprehensive admin panel secured with Two-Factor Authentication (2FA) via email OTP.

## 🚀 Key Features

### Portfolio & Content Management

-   **Dynamic Frontend:** All content on the public-facing pages (Home, About, Projects, etc.) is fully manageable through the admin panel.
-   **Admin Panel:** A complete backend to manage all portfolio content, users, and site settings.
-   **Project & Certificate Showcase:** Sections to display detailed information about personal projects and certifications.

### Mini-SIEM & Security

-   **Two-Factor Authentication (2FA):** Secure admin login using a One-Time Password (OTP) sent to the admin's email.
-   **Real-time Threat Detection:** A custom middleware inspects all incoming requests for malicious patterns (SQL Injection, XSS, LFI, Command Injection).
-   **Security Logging:** All detected threats are logged to the database with detailed information, including IP address, user agent, request URL, and the malicious payload.
-   **Automated IP Blocking:** An observer-based system automatically blocks an attacker's IP address after a configurable number of detected offenses.
-   **Live SOC Dashboard:** A real-time Security Operations Center (SOC) dashboard to monitor site traffic, server resources, HTTP response codes, and security events as they happen.
-   **Firewall & Blocklist Management:** A dedicated page to view and manage all automatically or manually blocked IP addresses.
-   **Themed HTML Email Alerts:** Sends beautifully formatted, "cyber-themed" HTML emails to the admin in real-time when a new threat is detected or an IP is blocked.

## 🛠️ Tech Stack

-   **Backend:** PHP 8.2, Laravel 12
-   **Frontend:** Blade, Tailwind CSS, Vite, Chart.js (for dashboards)
-   **Database:** MySQL
-   **Development Environment:** XAMPP

## ⚙️ Getting Started

To get a local copy up and running, follow these simple steps.

### Prerequisites

-   PHP >= 8.2
-   Composer
-   Node.js & NPM
-   A local web server environment (e.g., XAMPP, Laragon, Valet) with a MySQL database.

### Installation

1. **Clone the repository:**

    ```sh
    git clone https://github.com/AdliXSec/portfolio-project-soc
    cd porto-project-soc
    ```

2. **Install PHP dependencies:**

    ```sh
    composer install
    ```

3. **Install NPM dependencies and build assets:**

    ```sh
    npm install
    npm run build
    ```

4. **Create your environment file:**

    ```sh
    copy .env.example .env
    ```

5. **Generate an application key:**

    ```sh
    php artisan key:generate
    ```

6. **Configure your `.env` file:**
   Update the following variables with your local database and mail server credentials:

    ```dotenv
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password

    MAIL_MAILER=smtp
    MAIL_HOST=your_mail_host
    MAIL_PORT=your_mail_port
    MAIL_USERNAME=your_mail_username
    MAIL_PASSWORD=your_mail_password
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=hello@example.com
    ```

7. **Run database migrations and seeders:**
   This will create all necessary tables and populate the database with initial data, including the admin user.
    ```sh
    php artisan migrate --seed
    ```

## 🏃 Running the Application

1. **Start the local development server:**

    ```sh
    php artisan serve
    ```

2. **Start the queue worker:**
   This is required to process background jobs, such as sending security alert emails. Keep this running in a separate terminal.

    ```sh
    php artisan queue:work
    ```

3. **Access the application:**
    - **Public Site:** [http://127.0.0.1:8000](http://127.0.0.1:8000)
    - **Admin Login:** [http://127.0.0.1:8000/login](http://127.0.0.1:8000/login)
        - **Default Admin Email:** `adliwhtyousee@gmail.com`
        - **Default Admin Password:** `12345678`

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
