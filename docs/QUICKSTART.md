# Carpe Diem Naruto Quick Start Guide

## Overview
This guide will help you get started with Carpe Diem Naruto, a modular Laravel application framework. You'll learn how to set up your development environment, create your first module, and understand the basic concepts.

## Table of Contents
1. [Prerequisites](#prerequisites)
2. [Installation](#installation)
3. [Configuration](#configuration)
4. [Your First Module](#your-first-module)
5. [Core Concepts](#core-concepts)
6. [Development Workflow](#development-workflow)
7. [Testing](#testing)
8. [Deployment](#deployment)
9. [Troubleshooting](#troubleshooting)
10. [Next Steps](#next-steps)

## Prerequisites

### System Requirements
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL/PostgreSQL
- Git
- Web Server (Apache/Nginx)
- SSL Certificate (for production)

### PHP Extensions
- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- Tokenizer
- XML
- Redis (optional)
- Memcached (optional)

### Development Tools
- IDE (VS Code, PHPStorm, etc.)
- Git client
- Database management tool
- API testing tool (Postman, Insomnia, etc.)

## Installation

1. **Clone the Repository**
```bash
git clone https://github.com/your-username/carpe-diem-naruto.git
cd carpe-diem-naruto
```

2. **Install Dependencies**
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Build assets
npm run build
```

3. **Environment Setup**
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Generate JWT secret
php artisan jwt:secret
```

4. **Configure Database**
Edit `.env` file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=carpe_diem_naruto
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. **Run Migrations**
```bash
# Run database migrations
php artisan migrate

# Seed the database
php artisan db:seed
```

6. **Configure Web Server**
For Apache, create a virtual host:
```apache
<VirtualHost *:80>
    ServerName your-domain.com
    DocumentRoot /path/to/carpe-diem-naruto/public
    
    <Directory /path/to/carpe-diem-naruto/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

For Nginx:
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/carpe-diem-naruto/public;
    
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## Configuration

### 1. Application Configuration
Edit `config/app.php`:
```php
return [
    'name' => env('APP_NAME', 'Carpe Diem Naruto'),
    'env' => env('APP_ENV', 'production'),
    'debug' => env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
    'timezone' => 'UTC',
    'locale' => 'en',
    'fallback_locale' => 'en',
    'faker_locale' => 'en_US',
    'key' => env('APP_KEY'),
    'cipher' => 'AES-256-CBC',
];
```

### 2. Module Configuration
Edit `config/modules.php`:
```php
return [
    'cache' => [
        'enabled' => true,
        'ttl' => 3600,
    ],
    
    'marketplace' => [
        'local' => [
            'path' => base_path('packages/modules'),
        ],
        'remote' => [
            'url' => env('MARKETPLACE_URL'),
            'token' => env('MARKETPLACE_TOKEN'),
        ],
    ],
];
```

### 3. Database Configuration
Edit `config/database.php`:
```php
return [
    'default' => env('DB_CONNECTION', 'mysql'),
    
    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
    ],
];
```

## Your First Module

### 1. Create a New Module
```bash
php artisan module:make HelloWorld
```

### 2. Module Structure
Your new module will be created at `modules/HelloWorld` with this structure:
```
HelloWorld/
├── src/
│   ├── Config/           # Module configuration
│   │   └── config.php    # Module settings
│   ├── Console/          # Artisan commands
│   ├── Database/         # Migrations and seeders
│   ├── Http/             # Controllers, middleware, requests
│   ├── Models/           # Eloquent models
│   ├── Providers/        # Service providers
│   ├── Routes/           # Web and API routes
│   └── Services/         # Business logic
├── resources/
│   ├── views/            # Blade templates
│   ├── lang/             # Language files
│   └── assets/           # Frontend assets
└── tests/                # Test files
```

### 3. Create a Simple Controller
```php
// src/Http/Controllers/HelloController.php
namespace Modules\HelloWorld\Http\Controllers;

use App\Http\Controllers\Controller;

class HelloController extends Controller
{
    public function index()
    {
        return view('helloworld::welcome');
    }
}
```

### 4. Add a Route
```php
// src/Routes/web.php
Route::get('/hello', 'HelloController@index');
```

### 5. Create a View
```php
// resources/views/welcome.blade.php
<h1>Hello from HelloWorld Module!</h1>
```

### 6. Install and Enable the Module
```bash
# Install module
php artisan module:marketplace install HelloWorld

# Enable module
php artisan module:enable HelloWorld

# Verify installation
php artisan module:state HelloWorld
```

## Core Concepts

### 1. Module Lifecycle
- **Installation**: `php artisan module:marketplace install ModuleName`
- **Enabling**: `php artisan module:enable ModuleName`
- **Disabling**: `php artisan module:disable ModuleName`
- **Removal**: `php artisan module:marketplace remove ModuleName`

### 2. Module State
Check module status:
```bash
php artisan module:state ModuleName
```

### 3. Available Commands
```bash
# List all modules
php artisan module:marketplace list

# Debug module
php artisan module:debug ModuleName

# Check module health
php artisan module:health-check ModuleName
```

## Development Workflow

### 1. Creating Features
1. Create necessary models and migrations
2. Implement business logic in services
3. Create controllers and routes
4. Add views and assets
5. Write tests

### 2. Testing
```bash
# Run module tests
php artisan test --filter=ModuleName

# Run specific test
php artisan test --filter=TestName

# Run with coverage
php artisan test --coverage
```

### 3. Debugging
```bash
# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Regenerate autoload
composer dump-autoload

# Debug module
php artisan module:debug ModuleName
```

## Testing

### 1. Unit Tests
```php
namespace Modules\YourModule\Tests\Unit;

use Tests\TestCase;
use Modules\YourModule\Services\YourService;

class YourServiceTest extends TestCase
{
    public function test_some_functionality()
    {
        $service = new YourService();
        $result = $service->someMethod();
        
        $this->assertTrue($result);
    }
}
```

### 2. Feature Tests
```php
namespace Modules\YourModule\Tests\Feature;

use Tests\TestCase;
use Modules\YourModule\Models\YourModel;

class YourFeatureTest extends TestCase
{
    public function test_can_access_feature()
    {
        $response = $this->get('/your-module/feature');
        
        $response->assertStatus(200);
    }
}
```

### 3. Browser Tests
```php
namespace Modules\YourModule\Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class YourBrowserTest extends DuskTestCase
{
    public function test_can_use_feature()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/your-module/feature')
                   ->assertSee('Feature Title');
        });
    }
}
```

## Deployment

### 1. Production Setup
```bash
# Set environment
cp .env.example .env
php artisan key:generate

# Install dependencies
composer install --no-dev
npm install --production
npm run build

# Run migrations
php artisan migrate --force

# Clear caches
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2. Server Configuration
For Apache:
```apache
<VirtualHost *:80>
    ServerName your-domain.com
    DocumentRoot /path/to/carpe-diem-naruto/public
    
    <Directory /path/to/carpe-diem-naruto/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

For Nginx:
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/carpe-diem-naruto/public;
    
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    location ~ /\.ht {
        deny all;
    }
}
```

### 3. SSL Configuration
```bash
# Install SSL certificate
certbot --apache -d your-domain.com

# Or for Nginx
certbot --nginx -d your-domain.com
```

## Troubleshooting

### Common Issues

1. **Module Not Found**
```bash
# Check module exists
ls modules/YourModule

# Regenerate autoload
composer dump-autoload

# Check module state
php artisan module:state YourModule
```

2. **Installation Failures**
```bash
# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Check PHP version
php -v

# Check Laravel version
php artisan --version
```

3. **View Not Found**
```bash
# Clear view cache
php artisan view:clear

# Check view path
ls modules/YourModule/resources/views

# Verify view registration
php artisan module:debug YourModule
```

## Next Steps

1. Read the [Development Guide](DEVELOPMENT.md) for detailed information
2. Explore the [Core Module Documentation](CORE_MODULE.md)
3. Check out example modules in the `packages/modules` directory
4. Join the developer community for support

## Support

- GitHub Issues: [Create an issue](https://github.com/your-username/carpe-diem-naruto/issues)
- Email: dev@naruto.com
- Community Forum: [Join our forum](https://forum.naruto.com)

## License

This project is licensed under the MIT License - see the LICENSE file for details.