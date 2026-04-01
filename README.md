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

- **Online Application Management**: Full form-filling for personal details, academic marks (10th & 12th %) and course selection.
- **Self-Service Portal**: A personalized dashboard for students to track their application status in real-time.
- **Document Management**: Securely upload and manage required admission documents (10th Marksheet, 12th Certificate, etc.).
- **Multi-Stage Tracking**: Visual journey tracker from "Registration" to "Verified" and "Final Admission."
- **Transactional Emails**: Password resets and offer notifications integrated via Mailtrap.
- **Digital Receipts**: Downloadable payment receipts and application summaries in PDF format.

## ✅ Project Status: Core Modules Implemented

The following modules are now 100% functional and integrated:

| Module | Features Included |
| :--- | :--- |
| **Registration** | Email-based signup, login, and secure session management. |
| **Application** | Personal info, Academic background (marks), and Course preferences. |
| **Admin Central** | Leads pipeline, Lead Assignment, Verification, Merit List, and Final Admission. |
| **System Rules** | Dynamic merit thresholds, admission categories, and seat management. |
| **Finance** | Razorpay test integration for fee collection and automated receipts. |

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
