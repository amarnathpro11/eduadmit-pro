# EduAdmit Pro - College Admission & Lead Management System

EduAdmit Pro is a modern, comprehensive web application designed to streamline the college admission process, from initial lead capture to final student enrollment. Built with **Laravel 11**, **Bootstrap 5** it provides a seamless experience for both administrators and students.

## 🚀 Key Features

### 🏢 Administrative Powerhouse

- **Lead Lifecycle Management**: Track, assign, and follow up with prospective students through a dynamic lead pipeline.
- **Intelligent Lead Assignment**: Distribute leads across departments and counselors efficiently.
- **Admin Dashboard**: Real-time analytics, stat cards, and trend visualizations for leads, applications, and revenue.
- **Student Verification**: A dedicated module for reviewing and verifying student documents.
- **Audit Logging**: Comprehensive tracking of all administrative actions for security and transparency.
- **Dynamic Reporting**: Generate custom PDF and Excel reports for leads, enrollments, and payments.
- **Academic Management**: Easily manage departments, courses, and fee structures.

### 🎓 Student Experience

- **Self-Service Portal**: A personalized dashboard for students to track their application status.
- **Document Management**: Securely upload and manage required admission documents.
- **Multi-Stage Tracking**: Real-time status updates from "Applied" to "Fee Verification" and "Final Admission."
- **Automated Notifications**: Instant email updates for offer letters and payment confirmations.
- **Digital Receipts**: Downloadable payment receipts and admission confirmations in PDF format.

## 🛠️ Technology Stack

- **Backend**: [Laravel 11](https://laravel.com) (PHP 8.2+)
- **Database**: [MySQL](https://www.mysql.com/)
- **Payments**: [Razorpay Integration](https://razorpay.com/) for secure fee processing.
- **Email**: [Mailtrap](https://mailtrap.io/) for development testing & Email Previewing.
- **Frontend**: [Blade Templates](https://laravel.com/docs/blade), [Bootstrap 5](https://getbootstrap.com) (via CDN).
- **Typography**: [Poppins Font](https://fonts.google.com/specimen/Poppins) & [Inter](https://fonts.google.com/specimen/Inter).
- **Reports**: [DomPDF](https://github.com/barryvdh/laravel-dompdf) for PDF and [Laravel Excel](https://laravel-excel.com) for data exports.
- **Authentication**: Multi-tier role-based access control (RBAC).

## 📦 Installation & Setup

1.  **Clone the Repository**
    ```bash
    git clone https://github.com/amarnathpro11/eduadmit-pro.git
    cd eduadmit-pro
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    ```

3.  **Environment Configuration**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    _Update your `.env` file with your Database, Razorpay, and Mailtrap credentials._

4.  **Database Setup**
    ```bash
    php artisan migrate --seed
    ```

5.  **Run Local Server**
    ```bash
    php artisan serve
    ```
