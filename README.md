# EduAdmit Pro - College Admission & Lead Management System

EduAdmit Pro is a modern, comprehensive web application designed to streamline the college admission process, from initial lead capture to final student enrollment. Built with **Laravel 11**, **Bootstrap 5** it provides a seamless experience for both administrators and students.

## 🚀 System Modules

### 👑 Admin Module
- **Central Dashboard**: Real-time analytics, stat cards, and trend visualizations for leads and revenue.
- **Lead Management**: Track, assign, and follow up with prospective students with algorithm-based scoring.
- **Student Verification**: Review and verify student documents (10th/12th marksheets).
- **Manual Merit List**: Generate merit lists per course with manual cutoff control.
- **Academic Management**: Manage departments, courses, and fee structures.

### 📞 Counselor Module
- **Assigned Leads**: View and manage leads assigned to them.
- **Follow-ups**: Schedule and track follow-up communications.
- **Status Tracking**: Update lead status (New, Interested, Converted, Lost).

### 💰 Accountant Module
- **Fee Management**: Track application and admission fees.
- **Billing & Receipts**: Generate and export fee collection reports.
- **Payment Tracking**: Track cash/UPI/bank transactions.

### 🎓 Student Module (Applicant)
- **Online Application**: Fill personal and academic details (10th & 12th %).
- **Self-Service Dashboard**: Track application status in real-time.
- **Document Upload**: Securely upload required documents.
- **Receipt Downloads**: Download fee receipts in PDF format.

### 👪 Parent Module (New!)
- **Parent-Student Mapping**: Securely link parent accounts to students using student password.
- **Academic Monitoring**: View child's grades, attendance, and fee status.

### 📚 LMS Portal (Integration)
- **Performance Records**: View student grades and attendance data from the database.

## ✅ Project Status: Core Modules Implemented

The following modules are now 100% functional and integrated:

| Module | Features Included |
| :--- | :--- |
| **Registration** | Email-based signup, login, and secure session management. |
| **Application** | Personal info, Academic background (marks), and Course preferences. |
| **Admin Central** | Leads pipeline, Lead Assignment, Verification, Merit List (Manual Cutoff), and Final Admission. |
| **System Rules** | Dynamic merit thresholds, admission categories, and seat management. |
| **Finance** | Razorpay test integration for fee collection and automated receipts. |
| **Parent Portal** | Student mapping, attendance, and grade tracking. |
| **LMS View** | Display student performance records from the database. |

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
