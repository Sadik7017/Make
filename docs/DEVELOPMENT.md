# Carpe Diem Naruto Development Guide

## Table of Contents
1. [Introduction](#introduction)
2. [System Architecture](#system-architecture)
3. [Module Development](#module-development)
4. [Core Module](#core-module)
5. [Module Lifecycle](#module-lifecycle)
6. [Best Practices](#best-practices)
7. [Testing](#testing)
8. [Security](#security)
9. [Performance](#performance)
10. [Troubleshooting](#troubleshooting)

## Introduction

Carpe Diem Naruto is a modular Laravel application framework that provides a robust foundation for building scalable and maintainable applications. This guide will walk you through the development process, from setting up your environment to deploying your modules.

### Key Features
- Modular architecture with independent module lifecycle
- Built-in marketplace for module distribution
- Automatic module discovery and loading
- Dependency management and resolution
- Comprehensive testing framework
- Security-first approach

## System Architecture

### Overview
The system is built on a modular architecture where each module is a self-contained unit with its own:
- Configuration
- Routes
- Views
- Assets
- Database migrations
- Service providers
- Tests

### Directory Structure
```
project/
├── modules/                    # All modules are stored here
│   ├── Core/                  # Core module (required)
│   │   ├── src/
│   │   │   ├── Config/       # Module configuration
│   │   │   ├── Console/      # Artisan commands
│   │   │   ├── Database/     # Migrations and seeders
│   │   │   ├── Http/         # Controllers and middleware
│   │   │   ├── Models/       # Eloquent models
│   │   │   ├── Providers/    # Service providers
│   │   │   ├── Routes/       # Web and API routes
│   │   │   └── Services/     # Business logic
│   │   ├── resources/
│   │   │   ├── views/        # Blade templates
│   │   │   ├── lang/         # Language files
│   │   │   └── assets/       # Frontend assets
│   │   ├── tests/            # Test files
│   │   └── composer.json     # Module dependencies
│   └── YourModule/           # Your custom module
├── config/                    # Application configuration
├── database/                  # Application migrations
├── resources/                 # Application resources
└── composer.json             # Main application dependencies
```

## Module Development

### Creating a New Module

1. **Generate Module Structure**
```bash
php artisan module:make YourModule
```

This command creates a new module with the following structure:
```
YourModule/
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

2. **Module Configuration**
```php
// config/your-module.php
return [
    'name' => 'Your Module',
    'description' => 'Module description',
    'version' => '1.0.0',
    'enabled' => true,
    
    'settings' => [
        'key' => 'value',
    ],
    
    'dependencies' => [
        'Core' => '^1.0.0',
        'OtherModule' => '^2.0.0'
    ],
    
    'providers' => [
        'Modules\\YourModule\\Providers\\YourModuleServiceProvider'
    ],
    
    'middleware' => [
        'web' => [
            'Modules\\YourModule\\Http\\Middleware\\YourMiddleware'
        ]
    ]
];
```

3. **Service Provider Setup**
```php
namespace Modules\YourModule\Providers;

use Modules\Core\Providers\ModuleServiceProvider;

class YourModuleServiceProvider extends ModuleServiceProvider
{
    protected $moduleName = 'YourModule';
    protected $moduleNameLower = 'your-module';

    public function boot()
    {
        parent::boot();
        
        // Register routes
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/../Routes/api.php');
        
        // Register views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'your-module');
        
        // Register translations
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'your-module');
        
        // Register migrations
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        
        // Register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                YourCommand::class
            ]);
        }
    }

    public function register()
    {
        parent::register();
        
        // Register module services
        $this->app->singleton(YourService::class, function ($app) {
            return new YourService();
        });
    }
}
```

4. **Composer Configuration**
```json
{
    "name": "modules/your-module",
    "description": "Your module description",
    "type": "laravel-module",
    "require": {
        "php": "^8.2",
        "modules/core": "*"
    },
    "autoload": {
        "psr-4": {
            "Modules\\YourModule\\": "src/"
        }
    },
    "extra": {
        "laravel": {
            "providers": [
                "Modules\\YourModule\\Providers\\YourModuleServiceProvider"
            ]
        }
    }
}
```

## Module Lifecycle

### 1. Installation
```bash
# Install module
php artisan module:marketplace install YourModule

# This will:
# - Copy module files to modules directory
# - Register service provider
# - Run migrations
# - Publish assets
# - Update composer autoload
```

### 2. Enabling/Disabling
```bash
# Enable module
php artisan module:enable YourModule

# Disable module
php artisan module:disable YourModule

# Check module state
php artisan module:state YourModule
```

### 3. Updating
```bash
# Update module
php artisan module:marketplace update YourModule

# This will:
# - Check for updates
# - Download new version
# - Run migrations
# - Clear caches
```

### 4. Removal
```bash
# Remove module
php artisan module:marketplace remove YourModule

# This will:
# - Disable module
# - Remove files
# - Clean up database
# - Update autoload
```

## Best Practices

### 1. Module Design

- **Single Responsibility Principle**
  - Each module should have one primary purpose
  - Keep functionality focused and cohesive
  - Avoid module-to-module dependencies when possible

- **Interface Design**
  - Define clear interfaces for module services
  - Use dependency injection
  - Document public APIs
  - Use type hints and return types

### 2. Code Organization

- **Directory Structure**
  - Follow PSR-4 autoloading
  - Organize by feature
  - Keep related files together
  - Use consistent naming conventions

- **Naming Conventions**
  - Use PascalCase for class names
  - Use camelCase for method names
  - Use snake_case for file names
  - Use kebab-case for module names

### 3. Database Design

- **Migrations**
  - Use meaningful table names
  - Include proper indexes
  - Handle foreign keys correctly
  - Use proper column types
  - Add timestamps where appropriate

- **Models**
  - Define relationships clearly
  - Use proper type hints
  - Implement necessary traits
  - Use proper validation rules
  - Document complex queries

### 4. Security

- **Authentication**
  - Use Laravel's auth system
  - Implement proper middleware
  - Handle permissions correctly
  - Use proper encryption
  - Validate all inputs

- **Data Protection**
  - Validate all inputs
  - Sanitize outputs
  - Use proper encryption
  - Implement rate limiting
  - Use proper session handling

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

### 3. Test Commands
```bash
# Run all tests
php artisan test

# Run specific module tests
php artisan test --filter=YourModule

# Run specific test file
php artisan test --filter=YourTest
```

## Performance

### 1. Caching
```php
// Cache expensive operations
$result = Cache::remember('key', 3600, function () {
    return expensiveOperation();
});

// Cache module configuration
$config = Cache::remember('module.config', 3600, function () {
    return ModuleConfig::all();
});
```

### 2. Database Optimization
```php
// Use eager loading
$models = YourModel::with('relation')->get();

// Use proper indexes
// In migration
$table->index('column_name');

// Use chunking for large datasets
YourModel::chunk(100, function ($records) {
    // Process records
});
```

### 3. Asset Management
```php
// Publish assets
php artisan vendor:publish --tag=your-module-assets

// Version assets
mix.version();

// Use proper asset loading
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

## Troubleshooting

### 1. Common Issues

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

3. **Route Issues**
```bash
# Clear route cache
php artisan route:clear

# List all routes
php artisan route:list

# Check route registration
php artisan module:debug YourModule
```

### 2. Debug Commands

```bash
# Module debug
php artisan module:debug YourModule

# Health check
php artisan module:health-check YourModule

# List modules
php artisan module:marketplace list
```

## Support

For development support:
- Create an issue on GitHub
- Contact dev@naruto.com
- Join our developer community

## License

This development guide is part of the Carpe Diem Naruto project and is licensed under the MIT License. 