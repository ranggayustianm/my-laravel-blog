# Laravel Blog Application

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Features

- Post management (create, edit, view, list)
- Comment system
- User authentication (login, registration)
- Rich text editing with TinyMCE (pre-configured)
- Responsive design with Tailwind CSS

## Requirements

- PHP 8.1+
- Composer 2.2+
- Node.js 16+
- PostgreSQL 12+
- NPM 8+

## Installation

1. Clone the repository:
   ```bash
   git clone [repository-url]
   cd my-laravel-blog
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install JavaScript dependencies:
   ```bash
   npm install
   ```

4. Create and configure the environment file:
   ```bash
   cp .env.example .env
   ```
   Edit `.env` to set your database connection (PostgreSQL) and other settings.

5. Generate application key:
   ```bash
   php artisan key:generate
   ```

6. Run database migrations:
   ```bash
   php artisan migrate
   ```

7. Build frontend assets:
   ```bash
   npm run build
   ```

## Running the Application

Start the development server:
```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## Configuration

- **TinyMCE**: Already configured and ready to use in post editing
- **Database**: Configure PostgreSQL connection in `.env`
- **Environment**: No mail configuration required

## Testing

Run Pest tests:
```bash
php artisan test
```

## Demonstration
[Click here](https://youtu.be/nTYAhdIZafw)

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
