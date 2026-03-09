# AI Recruitment SaaS with RAG-Based Resume Evaluation

A modern **SaaS Job Board platform** built with Laravel that connects job seekers with companies through an intelligent recruitment workflow.
The system features **AI-powered resume evaluation**, **role-based access control (RBAC)**, and a **dual-application architecture** for scalability and separation of concerns.

---

## 🚀 Overview

This platform enables:

* Job seekers to browse jobs and submit applications
* Company owners to manage vacancies and review candidates
* Admins to oversee the entire ecosystem
* AI to evaluate resume compatibility and provide improvement feedback
* Cloud storage to securely store uploaded resumes

The system is designed as a **multi-role SaaS recruitment solution** with intelligent matching capabilities.

---

## 🏗️ Architecture

The platform is divided into two main applications:

### 1️⃣ Job App (MVC – Laravel)

Used by **Job Seekers**

**Responsibilities**

* Job browsing with pagination
* Search and filtering
* Job applications
* Application tracking
* AI resume evaluation

---

### 2️⃣ Job Backoffice (MVC – Laravel)

Used by **Admin & Company Owner**

**Responsibilities**

* Companies management
* Job categories management
* Job vacancies management
* Applications review workflow
* User management
* Platform analytics

---

## 🧠 AI & RAG Evaluation Flow

The system performs intelligent resume analysis:

1. Job seeker uploads or selects a resume
2. Resume stored in cloud storage
3. System retrieves job description
4. Resume + job context sent to OpenAI
5. AI returns:

   * Compatibility score (0–100%)
   * Improvement feedback
6. Results stored and displayed to user

---

## 🔐 Role-Based Access Control (RBAC)

| Role          | Permissions                            |
| ------------- | -------------------------------------- |
| Job Seeker    | Browse jobs, apply, track applications |
| Company Owner | Manage own jobs & applications         |
| Admin         | Full platform control                  |

The system ensures strict authorization so users only access permitted resources.

---

## ✨ Core Features

### 👨‍💼 Job App

#### Job Dashboard

* Paginated job listings (10 per page)
* Search by job title or company name
* Filter by employment type:

  * Full-time
  * Remote
  * Contract
  * Hybrid

#### My Applications

* Status tracking (Pending, Approved, Rejected)
* Application timeline with comments
* Application history

#### Job Application

* Apply using existing resume
* Upload new resume
* AI compatibility score
* AI improvement feedback
* Submission confirmation

---

### 🛠️ Admin Dashboard

#### Companies Management

* CRUD companies
* Assign company owner
* Soft delete (archive)

#### Job Categories

* CRUD categories
* Unique name validation
* Soft delete

#### Job Vacancies

* Full CRUD
* Employment type support
* Company ownership enforcement (OBAC)
* Soft delete

#### Applications Workflow

* Approve / Reject
* Request info
* Archive applications
* Owner-scoped access

#### Users Management

* View job seekers & owners
* Archive users
* Prevent archived login

#### Platform Analytics

* Active users (last 30 days)
* Active job postings
* Total applications
* Most applied jobs
* Top converting vacancies

---

## 🧩 Tech Stack

**Backend**

* Laravel (MVC)
* PHP
* MySQL / MariaDB

**AI**

* OpenAI API (ChatGPT)
* RAG-style contextual evaluation

**Storage**

* Cloud Storage (resume PDFs)

**DevOps**

* Docker & Docker Compose

---

## 📂 Project Structure

```
job-board/
├── job-app/           # Job seeker application
├── backoffice/        # Admin & company owner panel
├── docker/            # Docker configuration
├── database/
│   ├── migrations
│   └── seeders
└── README.md
```

---

## ⚙️ Environment Variables

Create a `.env` file and configure:

```env
APP_NAME=AI-Recruitment-SaaS
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=mysql-server
DB_PORT=3306
DB_DATABASE=shaghal_db
DB_USERNAME=root
DB_PASSWORD=secret

OPENAI_API_KEY=your_openai_key_here

FILESYSTEM_DISK=cloud
```

---

## 🐳 Docker Setup

### 1️⃣ Start containers

```bash
docker compose up -d
```

### 2️⃣ Run migrations

```bash
php artisan migrate
```

### 3️⃣ Seed database (optional)

```bash
php artisan db:seed
```

---

## 🔄 Application Workflow

### Job Seeker Flow

1. Register / Login
2. Browse jobs
3. View job details
4. Upload/select resume
5. AI evaluates application
6. Submit application
7. Track status

---

### Company Owner Flow

1. Login to backoffice
2. Create job vacancy
3. Review applications
4. Approve / Reject

---

### Admin Flow

1. Manage companies
2. Manage categories
3. Manage users
4. Monitor analytics

---

## 🧪 Acceptance Criteria Coverage

✅ Pagination (10 per page)
✅ Search within 2 seconds
✅ Filter without full refresh
✅ AI compatibility score
✅ Detailed feedback
✅ RBAC enforcement
✅ OBAC for company owners
✅ Soft delete across entities
✅ Analytics dashboard

---

## 🔒 Security Considerations

* RBAC middleware enforcement
* Owner-scoped queries (OBAC)
* File validation for resumes
* API key protection
* Soft delete for data integrity

---

## 🚀 Future Enhancements

* Vector database for full RAG pipeline
* Real-time notifications
* Advanced AI matching
* Multi-tenant SaaS isolation
* Redis caching
* Queue workers for AI processing

---

## 👨‍💻 Author

**Mohammad Bashar Khalaf**