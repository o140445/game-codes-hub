# GameCodesHub

A modern gaming website built with Laravel and Filament, providing game codes, guides, reviews, and gaming content. Features a responsive design with a black-gray and gold color scheme.

## 🎮 Features

### Frontend
- **Responsive Design**: Modern, mobile-friendly interface
- **Game Codes**: Display and copy redeem codes for various games
- **Game Listings**: Browse games with search and filtering
- **Articles**: Gaming guides, reviews, and news
- **Contact Form**: User feedback and support system
- **SEO Optimized**: Meta tags, structured data, and canonical URLs

### Backend (Filament Admin Panel)
- **Game Management**: CRUD operations for games with image uploads
- **Code Management**: Manage game codes with validation status
- **Article Management**: Create and edit gaming content
- **Contact Management**: Handle user submissions
- **User Management**: Admin user system
- **Dashboard**: Analytics and overview

### Technical Features
- **Automatic Slug Generation**: SEO-friendly URLs
- **Image Upload**: File storage with validation
- **Soft Deletes**: Data recovery capability
- **Code Status Tracking**: Valid/invalid code management
- **Latest Code Flags**: Highlight new codes
- **Copy-to-Clipboard**: One-click code copying
- **Pagination**: Efficient data loading
- **Search Functionality**: Find games and content quickly

## 🛠️ Technology Stack

- **Backend**: Laravel 10.x
- **Admin Panel**: Filament 3.x
- **Frontend**: Blade Templates, Tailwind CSS, Alpine.js
- **Database**: MySQL/PostgreSQL
- **File Storage**: Laravel Storage
- **Build Tool**: Vite
- **Package Manager**: Composer, NPM

## 📋 Requirements

- PHP 8.1 or higher
- Composer
- Node.js & NPM
- MySQL 5.7+ or PostgreSQL 10+
- Web server (Apache/Nginx)

## 🚀 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/GameCodesHub.git
   cd GameCodesHub
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   Edit `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=gamecodeshub
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run migrations and seeders**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

7. **Create storage link**
   ```bash
   php artisan storage:link
   ```

8. **Build frontend assets**
   ```bash
   npm run build
   ```

9. **Set up admin user**
   ```bash
   php artisan make:filament-user
   ```

## 🎨 Customization

### Color Scheme
The website uses a black-gray and gold color scheme. You can customize colors in:
- `resources/css/app.css` - Main styles
- `resources/views/layouts/app.blade.php` - Layout template
- Tailwind configuration

### Content Management
- **Games**: Manage through Filament admin panel
- **Codes**: Add/edit codes with validation status
- **Articles**: Create gaming content and guides
- **Pages**: About, Contact, Privacy, Terms pages

## 📁 Project Structure

```
GameCodesHub/
├── app/
│   ├── Filament/           # Admin panel resources
│   ├── Http/Controllers/   # Web controllers
│   └── Models/            # Eloquent models
├── database/
│   ├── migrations/        # Database migrations
│   └── seeders/          # Data seeders
├── resources/
│   ├── css/              # Stylesheets
│   ├── js/               # JavaScript files
│   └── views/            # Blade templates
├── routes/               # Route definitions
└── public/              # Public assets
```

## 🔧 Configuration

### File Uploads
Configure file storage in `config/filesystems.php`:
```php
'disks' => [
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
    ],
],
```

### SEO Settings
Update SEO meta tags in individual Blade views:
- Page titles
- Meta descriptions
- Keywords
- Canonical URLs
- Structured data (JSON-LD)

## 🚀 Deployment

1. **Production environment setup**
   ```bash
   composer install --optimize-autoloader --no-dev
   npm run build
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

2. **Set proper permissions**
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```

3. **Configure web server**
   - Point document root to `public/` directory
   - Enable URL rewriting for Laravel

## 📊 Database Schema

### Games Table
- `id`, `name`, `slug`, `description`, `content`
- `image`, `category`, `platform`, `author`
- `summary`, `how_to_redeem`, `faq`
- `special_recommend`, `created_at`, `updated_at`

### Codes Table
- `id`, `game_id`, `code`, `name`, `is_latest`
- `created_at`, `updated_at`

### Articles Table
- `id`, `title`, `slug`, `description`, `content`
- `image`, `author`, `created_at`, `updated_at`

### Contacts Table
- `id`, `name`, `email`, `subject`, `message`
- `status`, `created_at`, `updated_at`

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 Support

For support and questions:
- **Email**: contact@gamecodeshub.com
- **Website**: https://gamecodeshub.com
- **Issues**: GitHub Issues page

## 🙏 Acknowledgments

- [Laravel](https://laravel.com/) - The PHP framework
- [Filament](https://filamentphp.com/) - Admin panel
- [Tailwind CSS](https://tailwindcss.com/) - CSS framework
- [Alpine.js](https://alpinejs.dev/) - JavaScript framework

---

**GameCodesHub** - Your ultimate destination for gaming content and redeem codes! 🎮
