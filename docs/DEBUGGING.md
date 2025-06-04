# Debugging Guide

## Table of Contents
1. [Introduction](#introduction)
2. [Module State Management](#module-state-management)
3. [Common Issues](#common-issues)
4. [Debugging Commands](#debugging-commands)
5. [Troubleshooting Steps](#troubleshooting-steps)
6. [Advanced Debugging](#advanced-debugging)
7. [Performance Debugging](#performance-debugging)
8. [Security Debugging](#security-debugging)
9. [Database Debugging](#database-debugging)
10. [Cache Debugging](#cache-debugging)

## Introduction

This debugging guide provides comprehensive information for troubleshooting and debugging issues in the Carpe Diem Naruto modular system. It covers various aspects of debugging, from basic module state management to advanced performance optimization.

### Key Areas Covered
- Module state and health monitoring
- Common issues and their solutions
- Debugging commands and tools
- Advanced debugging techniques
- Performance optimization
- Security auditing
- Database troubleshooting
- Cache management

## Module State Management

### Checking Module State
```bash
# Check current state of a module
php artisan module:state ModuleName

# Expected output:
Module: ModuleName
Status: enabled/disabled
Version: x.y.z
Dependencies: [list of dependencies]
Last Enabled: YYYY-MM-DD HH:MM:SS
Last Disabled: YYYY-MM-DD HH:MM:SS
Applied Migrations: [list of migrations]
Failed Migrations: [list of failed migrations]
```

### Module Health Check
```bash
# Run health check on a module
php artisan module:health-check ModuleName

# This will check:
# - Service provider registration
# - Route registration
# - Migration status
# - Dependency status
# - Cache status
# - Asset status
# - Configuration status
# - Event registration
# - Command registration
```

### Module Debug Information
```bash
# Get detailed module information
php artisan module:debug ModuleName

# Output includes:
# - Module status
# - Service providers
# - Routes
# - Dependencies
# - Configuration
# - Events
# - Commands
# - Assets
# - Cache keys
# - Database tables
```

## Common Issues

### 1. Module Not Found
**Symptoms:**
- Module not listed in marketplace
- Module commands fail with "Module not found" error
- Module routes not accessible
- Module views not found

**Solutions:**
1. Verify module directory exists:
```bash
ls modules/ModuleName
```

2. Check composer.json:
```bash
cat modules/ModuleName/composer.json
```

3. Regenerate autoload:
```bash
composer dump-autoload
```

4. Check module registration:
```bash
php artisan module:debug ModuleName
```

5. Verify service provider:
```bash
php artisan module:state ModuleName
```

### 2. Installation Failures
**Symptoms:**
- Module installation fails
- Dependencies not resolved
- Migration errors
- Service provider registration fails
- Asset publishing fails

**Solutions:**
1. Clear all caches:
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear
```

2. Check PHP version:
```bash
php -v
```

3. Verify Laravel version:
```bash
php artisan --version
```

4. Check module requirements:
```bash
cat modules/ModuleName/composer.json
```

5. Verify database connection:
```bash
php artisan db:monitor
```

### 3. Route Registration Issues
**Symptoms:**
- Routes not accessible
- 404 errors for module routes
- Route cache issues
- Middleware not applied
- Route conflicts

**Solutions:**
1. Check route registration in service provider:
```php
// In ModuleServiceProvider.php
public function boot()
{
    $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
    $this->loadRoutesFrom(__DIR__.'/../Routes/api.php');
}
```

2. Clear route cache:
```bash
php artisan route:clear
php artisan route:cache
```

3. List all routes:
```bash
php artisan route:list
```

4. Check route middleware:
```bash
php artisan route:list --except-vendor
```

5. Verify route files:
```bash
ls modules/ModuleName/src/Routes
```

### 4. Service Provider Issues
**Symptoms:**
- Module services not available
- Dependency injection failures
- Service registration errors
- Event listeners not working
- Commands not registered

**Solutions:**
1. Check service provider registration:
```bash
php artisan module:debug ModuleName
```

2. Verify service provider class:
```php
// In ModuleServiceProvider.php
namespace Modules\ModuleName\Providers;

use Modules\Core\Providers\ModuleServiceProvider;

class ModuleNameServiceProvider extends ModuleServiceProvider
{
    protected $moduleName = 'ModuleName';
    protected $moduleNameLower = 'module-name';
}
```

3. Clear configuration cache:
```bash
php artisan config:clear
```

4. Check service bindings:
```php
// In ModuleServiceProvider.php
public function register()
{
    $this->app->singleton(YourService::class, function ($app) {
        return new YourService();
    });
}
```

5. Verify event listeners:
```php
// In ModuleServiceProvider.php
protected function registerEvents()
{
    Event::listen(YourEvent::class, YourListener::class);
}
```

## Debugging Commands

### 1. Module Debug
```bash
# Get detailed module information
php artisan module:debug ModuleName

# Output includes:
# - Module status
# - Service providers
# - Routes
# - Dependencies
# - Configuration
# - Events
# - Commands
# - Assets
# - Cache keys
# - Database tables
```

### 2. Cache Management
```bash
# Clear specific caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Clear all caches
php artisan optimize:clear

# Clear module cache
php artisan module:cache-clear ModuleName

# List cache keys
php artisan cache:list
```

### 3. Autoload Management
```bash
# Regenerate autoload files
composer dump-autoload

# Optimize autoloader
composer dump-autoload -o

# Check autoload files
composer dump-autoload --dry-run
```

### 4. Database Management
```bash
# Check migration status
php artisan migrate:status

# List all migrations
php artisan migrate:list

# Check specific module migrations
php artisan migrate:status --path=modules/ModuleName/src/Database/Migrations

# Reset module migrations
php artisan migrate:reset --path=modules/ModuleName/src/Database/Migrations

# Refresh module migrations
php artisan migrate:refresh --path=modules/ModuleName/src/Database/Migrations
```

## Troubleshooting Steps

### 1. Module Installation
1. Check prerequisites:
```bash
php -v
composer -V
php artisan --version
```

2. Verify module structure:
```bash
ls -la modules/ModuleName
```

3. Check composer.json:
```bash
cat modules/ModuleName/composer.json
```

4. Install module:
```bash
php artisan module:marketplace install ModuleName
```

5. Verify installation:
```bash
php artisan module:state ModuleName
```

### 2. Module Removal
1. Disable module:
```bash
php artisan module:disable ModuleName
```

2. Remove module:
```bash
php artisan module:marketplace remove ModuleName
```

3. Clean up:
```bash
composer dump-autoload
php artisan optimize:clear
```

### 3. Module Update
1. Check current version:
```bash
php artisan module:state ModuleName
```

2. Update module:
```bash
composer update modules/module-name
```

3. Run migrations:
```bash
php artisan migrate
```

## Advanced Debugging

### 1. Logging
```php
// In your code
\Log::debug('Module state:', ['module' => $moduleName, 'state' => $state]);

// Configure logging
'logging' => [
    'channels' => [
        'module' => [
            'driver' => 'daily',
            'path' => storage_path('logs/module.log'),
            'level' => 'debug',
            'days' => 14,
        ],
    ],
],
```

### 2. Event Debugging
```php
// Listen for module events
Event::listen('module.*', function ($event) {
    \Log::debug('Module event:', ['event' => $event]);
});

// Debug specific events
Event::listen(ModuleInstalled::class, function ($event) {
    \Log::debug('Module installed:', ['module' => $event->moduleName]);
});
```

### 3. Service Provider Debugging
```php
// In ModuleServiceProvider.php
public function boot()
{
    \Log::debug('Booting module:', ['module' => $this->moduleName]);
    parent::boot();
}

public function register()
{
    \Log::debug('Registering module:', ['module' => $this->moduleName]);
    parent::register();
}
```

### 4. Route Debugging
```bash
# List all routes with middleware
php artisan route:list --except-vendor

# List routes for specific module
php artisan route:list --path=module-name

# Check route cache
php artisan route:cache

# Clear route cache
php artisan route:clear
```

### 5. Database Debugging
```bash
# Check migration status
php artisan migrate:status

# List all migrations
php artisan migrate:list

# Check specific module migrations
php artisan migrate:status --path=modules/ModuleName/src/Database/Migrations

# Debug database queries
DB::enableQueryLog();
// Your code here
dd(DB::getQueryLog());
```

## Performance Debugging

### 1. Cache Performance
```php
// Check cache hit rate
$hits = Cache::get('cache_hits', 0);
$misses = Cache::get('cache_misses', 0);
$hitRate = $hits / ($hits + $misses) * 100;

// Monitor cache size
$size = Cache::get('cache_size', 0);
```

### 2. Database Performance
```php
// Enable query logging
DB::enableQueryLog();

// Get slow queries
$slowQueries = DB::table('slow_queries')
    ->where('execution_time', '>', 1000)
    ->get();

// Check index usage
$indexUsage = DB::select('SHOW INDEX FROM table_name');
```

### 3. Route Performance
```php
// Check route loading time
$start = microtime(true);
Route::getRoutes();
$time = microtime(true) - $start;

// Monitor route cache
$cacheSize = filesize(storage_path('framework/cache/routes.php'));
```

## Security Debugging

### 1. Access Control
```php
// Check module access
if (!Gate::allows('access-module', $moduleName)) {
    \Log::warning('Unauthorized module access attempt:', [
        'module' => $moduleName,
        'user' => auth()->id()
    ]);
    abort(403);
}
```

### 2. Rate Limiting
```php
// Monitor rate limit hits
$hits = RateLimiter::attempts('module-operations');
if ($hits > 60) {
    \Log::warning('Rate limit exceeded:', [
        'ip' => request()->ip(),
        'hits' => $hits
    ]);
}
```

### 3. Input Validation
```php
// Log validation failures
try {
    $validated = $request->validate([
        'field' => 'required|string|max:255'
    ]);
} catch (\Exception $e) {
    \Log::warning('Validation failed:', [
        'errors' => $e->errors(),
        'input' => $request->all()
    ]);
    throw $e;
}
```

## Database Debugging

### 1. Migration Issues
```bash
# Check migration status
php artisan migrate:status

# List all migrations
php artisan migrate:list

# Check specific module migrations
php artisan migrate:status --path=modules/ModuleName/src/Database/Migrations

# Debug migration
php artisan migrate --pretend
```

### 2. Query Issues
```php
// Enable query logging
DB::enableQueryLog();

// Your code here
$queries = DB::getQueryLog();

// Check slow queries
$slowQueries = collect($queries)->filter(function ($query) {
    return $query['time'] > 1000;
});
```

### 3. Connection Issues
```php
// Check database connection
try {
    DB::connection()->getPdo();
} catch (\Exception $e) {
    \Log::error('Database connection failed:', [
        'error' => $e->getMessage()
    ]);
}
```

## Cache Debugging

### 1. Cache Issues
```php
// Check cache connection
try {
    Cache::put('test', 'value', 1);
    $value = Cache::get('test');
} catch (\Exception $e) {
    \Log::error('Cache connection failed:', [
        'error' => $e->getMessage()
    ]);
}
```

### 2. Cache Performance
```php
// Monitor cache operations
$start = microtime(true);
Cache::get('key');
$time = microtime(true) - $start;

// Check cache size
$size = Cache::get('cache_size', 0);
```

### 3. Cache Configuration
```php
// Check cache configuration
$config = config('cache.stores.redis');

// Monitor cache hits/misses
$hits = Cache::get('cache_hits', 0);
$misses = Cache::get('cache_misses', 0);
```

## Support

For additional support:
1. Check the [Core Module Documentation](CORE_MODULE.md)
2. Review the [Development Guide](DEVELOPMENT.md)
3. Create an issue on GitHub
4. Contact the development team

## License

This debugging guide is part of the Carpe Diem Naruto project and is licensed under the MIT License. 