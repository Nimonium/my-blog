# NovaBlog - Laravel 11 Blog Management System

NovaBlog is a modern, fully functional, and responsive Blog Management System built with Laravel. It features a secure admin panel, rich text editing, dynamic AJAX-based filtering, and a sleek, user-friendly frontend design.

## Features
- **Admin Dashboard**: Secure backend for managing blogs, categories, tags, headlines, and help videos.
- **Rich Text Editor**: Integrated WYSIWYG editor for composing visually appealing blog posts.
- **Dynamic Frontend**: Real-time category and search filtering using jQuery/AJAX without page reloads.
- **Responsive Design**: Professional-grade responsiveness across mobile, tablet, and desktop devices.
- **Media Management**: Support for uploading and serving images with proper storage symlinking.
- **Scheduled Publishing**: Ability to schedule posts to automatically publish at a future date and time.
- **Containerized Deployment**: Includes a Dockerfile tailored for seamless deployment to Render with automated database migrations.

## Tech Used
- **Backend Framework**: Laravel 11, PHP 8.4
- **Database**: MySQL (Aiven Cloud in production)
- **Frontend**: HTML5, CSS3, JavaScript, jQuery, Tailwind CSS (via Vite)
- **Deployment & Hosting**: Render (Docker Container Web Service)
- **Version Control**: Git & GitHub

## Setup Steps

### 1. Clone the Repository
```bash
git clone https://github.com/Nimonium/my-blog.git
cd my-blog
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install Node Dependencies & Build Assets
```bash
npm install
npm run build
```

### 4. Environment Configuration
Copy the example environment file and configure your database settings:
```bash
cp .env.example .env
```
Generate your application key:
```bash
php artisan key:generate
```
Update your `.env` file with your local MySQL database credentials.

### 5. Run Database Migrations
Create the necessary database tables:
```bash
php artisan migrate
```

### 6. Link Storage Directory
Create a symbolic link to allow public access to uploaded images:
```bash
php artisan storage:link
```

### 7. Start the Development Server
```bash
php artisan serve
```
Your application will be available at `http://localhost:8000`.

---
*Note: For production deployment on Render, the included `Dockerfile` automatically handles `storage:link` and database migrations upon container startup.*
