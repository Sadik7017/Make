# Core Module Documentation

## Overview
The Core module is the foundation of the Carpe Diem Naruto system, providing essential services and functionality for module management, system configuration, and marketplace features. This documentation provides a comprehensive guide to understanding and working with the Core module.

## Table of Contents
1. [Architecture](#architecture)
2. [Services](#services)
3. [Models](#models)
4. [Commands](#commands)
5. [Events](#events)
6. [Configuration](#configuration)
7. [Module Management](#module-management)
8. [Marketplace Integration](#marketplace-integration)
9. [Cache Management](#cache-management)
10. [Security](#security)
11. [Troubleshooting](#troubleshooting)

## Architecture

### Directory Structure
```
Core/
├── src/
│   ├── Console/          # Artisan commands
│   │   └── Commands/     # Command implementations
│   ├── Database/         # Migrations and seeders
│   ├── Events/           # Event classes
│   ├── Http/             # Controllers and middleware
│   ├── Models/           # Eloquent models
│   ├── Notifications/    # Notification classes
│   ├── Providers/        # Service providers
│   ├── Services/         # Core services
│   └── Support/          # Helper classes
├── resources/
│   ├── views/            # Blade templates
│   ├── lang/             # Language files
│   └── assets/           # Frontend assets
├── tests/                # Test files
└── composer.json         # Module dependencies
```

### Key Components

1. **ModuleState Model**
   - Tracks module installation status
   - Manages module versions
   - Handles module dependencies
   - Stores module configuration
   - Manages module lifecycle

2. **MarketplaceService**
   - Module discovery and installation
   - Dependency resolution
   - Version management
   - Cache handling
   - Update management

3. **ModuleRegistrationService**
   - Service provider registration
   - Autoload configuration
   - Asset management
   - Route registration
   - View registration

## Services

### 1. MarketplaceService

```php
class MarketplaceService
{
    // Module Installation
    public function installModule($name)
    {
        // Validate module
        $this->validateModule($name);
        
        // Check dependencies
        $this->checkDependencies($name);
        
        // Install module
        $this->performInstallation($name);
        
        // Register service provider
        $this->registerServiceProvider($name);
        
        // Run migrations
        $this->runMigrations($name);
        
        // Publish assets
        $this->publishAssets($name);
        
        // Update autoload
        $this->regenerateAutoload();
    }

    public function uninstallModule($name)
    {
        // Validate module
        $this->validateModule($name);
        
        // Check dependents
        $this->checkDependents($name);
        
        // Uninstall module
        $this->performUninstallation($name);
        
        // Unregister service provider
        $this->unregisterServiceProvider($name);
        
        // Rollback migrations
        $this->rollbackMigrations($name);
        
        // Remove assets
        $this->removeAssets($name);
        
        // Update autoload
        $this->regenerateAutoload();
    }

    public function enableModule($name)
    {
        // Validate module
        $this->validateModule($name);
        
        // Check dependencies
        $this->checkDependencies($name);
        
        // Enable module
        $this->performEnable($name);
        
        // Register service provider
        $this->registerServiceProvider($name);
        
        // Clear caches
        $this->clearCaches();
    }

    public function disableModule($name)
    {
        // Validate module
        $this->validateModule($name);
        
        // Check dependents
        $this->checkDependents($name);
        
        // Disable module
        $this->performDisable($name);
        
        // Unregister service provider
        $this->unregisterServiceProvider($name);
        
        // Clear caches
        $this->clearCaches();
    }
    
    // Module Discovery
    public function getAvailableModules()
    {
        return Cache::remember('available_modules', 3600, function () {
            return $this->discoverModules();
        });
    }

    public function getModuleDetails($name)
    {
        return Cache::remember("module_details_{$name}", 3600, function () use ($name) {
            return $this->loadModuleDetails($name);
        });
    }
    
    // Cache Management
    public function clearCache()
    {
        Cache::forget('available_modules');
        Cache::forget('module_states');
        $this->clearModuleCaches();
    }

    protected function getModuleCacheKey($name)
    {
        return "module_{$name}_cache";
    }
}
```

### 2. ModuleRegistrationService

```php
class ModuleRegistrationService
{
    // Module Registration
    public function registerModule($name)
    {
        // Register service provider
        $this->registerServiceProvider($name);
        
        // Register routes
        $this->registerRoutes($name);
        
        // Register views
        $this->registerViews($name);
        
        // Register translations
        $this->registerTranslations($name);
        
        // Register commands
        $this->registerCommands($name);
    }

    public function unregisterModule($name)
    {
        // Unregister service provider
        $this->unregisterServiceProvider($name);
        
        // Unregister routes
        $this->unregisterRoutes($name);
        
        // Unregister views
        $this->unregisterViews($name);
        
        // Unregister translations
        $this->unregisterTranslations($name);
        
        // Unregister commands
        $this->unregisterCommands($name);
    }
    
    // Service Provider Management
    protected function registerServiceProvider($name)
    {
        $providerClass = "Modules\\{$name}\\Providers\\{$name}ServiceProvider";
        
        if (class_exists($providerClass)) {
            $this->app->register($providerClass);
        }
    }

    protected function unregisterServiceProvider($name)
    {
        $providerClass = "Modules\\{$name}\\Providers\\{$name}ServiceProvider";
        
        if (class_exists($providerClass)) {
            $this->app->unregister($providerClass);
        }
    }
}
```

## Models

### 1. ModuleState

```php
class ModuleState extends Model
{
    protected $fillable = [
        'name',
        'version',
        'status',
        'enabled',
        'last_enabled_at',
        'last_disabled_at',
        'applied_migrations',
        'failed_migrations',
        'dependencies',
        'dependents',
        'config',
        'cache_key'
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'last_enabled_at' => 'datetime',
        'last_disabled_at' => 'datetime',
        'applied_migrations' => 'array',
        'failed_migrations' => 'array',
        'dependencies' => 'array',
        'dependents' => 'array',
        'config' => 'array'
    ];

    public function isEnabled()
    {
        return $this->enabled;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getDependencies()
    {
        return $this->dependencies;
    }

    public function getDependents()
    {
        return $this->dependents;
    }

    public function getConfig()
    {
        return $this->config;
    }
}
```

## Commands

### 1. Module Management Commands

```bash
# Create new module
php artisan module:make ModuleName

# Install module
php artisan module:marketplace install ModuleName

# Enable module
php artisan module:enable ModuleName

# Disable module
php artisan module:disable ModuleName

# Remove module
php artisan module:marketplace remove ModuleName

# Update module
php artisan module:marketplace update ModuleName

# Check module state
php artisan module:state ModuleName

# Debug module
php artisan module:debug ModuleName

# Health check
php artisan module:health-check ModuleName
```

### 2. Debug Commands

```bash
# Check module state
php artisan module:state ModuleName

# Debug module information
php artisan module:debug ModuleName

# Check module health
php artisan module:health-check ModuleName

# List all modules
php artisan module:marketplace list

# Check for updates
php artisan module:marketplace check-updates
```

## Events

### 1. Module Lifecycle Events

```php
// Installation Events
ModuleInstalled::class
ModuleUninstalled::class

// State Change Events
ModuleEnabled::class
ModuleDisabled::class

// Removal Events
ModuleRemoved::class

// Update Events
ModuleUpdated::class
ModuleUpdateFailed::class

// Cache Events
ModuleCacheCleared::class
ModuleCacheFailed::class
```

### 2. Event Usage

```php
// Listen for module installation
Event::listen(ModuleInstalled::class, function ($event) {
    // Handle module installation
    Log::info("Module {$event->moduleName} installed");
    
    // Clear caches
    Cache::forget('available_modules');
    
    // Update module list
    $this->updateModuleList();
});

// Listen for module enabling
Event::listen(ModuleEnabled::class, function ($event) {
    // Handle module enabling
    Log::info("Module {$event->moduleName} enabled");
    
    // Clear route cache
    Route::clearCache();
    
    // Clear config cache
    Config::clearCache();
});

// Listen for module update
Event::listen(ModuleUpdated::class, function ($event) {
    // Handle module update
    Log::info("Module {$event->moduleName} updated to version {$event->version}");
    
    // Clear caches
    Cache::forget('available_modules');
    Cache::forget("module_details_{$event->moduleName}");
    
    // Update module list
    $this->updateModuleList();
});
```

## Configuration

### 1. Module Configuration

```php
// config/modules.php
return [
    'cache' => [
        'enabled' => true,
        'ttl' => 3600,
        'prefix' => 'module_',
    ],
    
    'marketplace' => [
        'local' => [
            'path' => base_path('packages/modules'),
        ],
        'remote' => [
            'url' => env('MARKETPLACE_URL'),
            'token' => env('MARKETPLACE_TOKEN'),
        ],
        'modules' => [
            'backup' => [
                'enabled' => true,
                'path' => storage_path('app/modules/backups'),
            ],
        ],
    ],
    
    'autoload' => [
        'auto_cleanup' => true,
        'core_modules' => ['Core'],
    ],
    
    'security' => [
        'allowed_ips' => explode(',', env('ALLOWED_IPS', '')),
        'max_attempts' => env('MAX_ATTEMPTS', 3),
        'lockout_time' => env('LOCKOUT_TIME', 60),
    ],
];
```

### 2. Service Provider Configuration

```php
// CoreServiceProvider.php
class CoreServiceProvider extends ServiceProvider
{
    protected $moduleName = 'Core';
    protected $moduleNameLower = 'core';

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'core');
        
        // Register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                ModuleMakeCommand::class,
                ModuleMarketplaceCommand::class,
                ModuleStateCommand::class,
                ModuleEnableCommand::class,
                ModuleDisableCommand::class,
                ModuleDebugCommand::class,
                ModuleHealthCheckCommand::class,
            ]);
        }
        
        // Register middleware
        $this->app['router']->aliasMiddleware('module', ModuleMiddleware::class);
        
        // Register events
        $this->registerEvents();
    }

    public function register()
    {
        // Register services
        $this->app->singleton(ModuleManager::class);
        $this->app->singleton(MarketplaceService::class);
        $this->app->singleton(ModuleRegistrationService::class);
        
        // Register config
        $this->mergeConfigFrom(__DIR__.'/../Config/config.php', 'core');
        $this->mergeConfigFrom(__DIR__.'/../Config/marketplace.php', 'marketplace');
    }
}
```

## Module Management

### 1. Module Lifecycle

1. **Installation**
   - Validate module
   - Check dependencies
   - Install module
   - Register service provider
   - Run migrations
   - Publish assets
   - Update autoload

2. **Enabling**
   - Validate module
   - Check dependencies
   - Enable module
   - Register service provider
   - Clear caches

3. **Disabling**
   - Validate module
   - Check dependents
   - Disable module
   - Unregister service provider
   - Clear caches

4. **Removal**
   - Validate module
   - Check dependents
   - Disable module
   - Unregister service provider
   - Rollback migrations
   - Remove assets
   - Update autoload

### 2. Module State Management

```php
// Check if module is enabled
$isEnabled = $moduleState->isEnabled();

// Get module version
$version = $moduleState->getVersion();

// Get module status
$status = $moduleState->getStatus();

// Get module dependencies
$dependencies = $moduleState->getDependencies();

// Get module dependents
$dependents = $moduleState->getDependents();

// Get module config
$config = $moduleState->getConfig();
```

## Marketplace Integration

### 1. Module Discovery

```php
// Get available modules
$modules = $marketplaceService->getAvailableModules();

// Get module details
$details = $marketplaceService->getModuleDetails('ModuleName');

// Check for updates
$updates = $marketplaceService->checkForUpdates();
```

### 2. Module Installation

```php
// Install module
$marketplaceService->installModule('ModuleName');

// Enable module
$marketplaceService->enableModule('ModuleName');

// Remove module
$marketplaceService->removeModule('ModuleName');
```

## Cache Management

### 1. Cache Configuration

```php
// config/modules.php
'cache' => [
    'enabled' => true,
    'ttl' => 3600,
    'prefix' => 'module_',
],
```

### 2. Cache Operations

```php
// Clear module cache
$marketplaceService->clearCache();

// Get cached module list
$modules = $marketplaceService->getAvailableModules();

// Cache module details
$details = Cache::remember("module_details_{$name}", 3600, function () use ($name) {
    return $this->loadModuleDetails($name);
});
```

## Security

### 1. Access Control

```php
// Check module access
if (!Gate::allows('access-module', $moduleName)) {
    abort(403);
}

// Check module permission
if (!auth()->user()->can('manage-module', $moduleName)) {
    abort(403);
}
```

### 2. Rate Limiting

```php
// Rate limit module operations
RateLimiter::for('module-operations', function (Request $request) {
    return Limit::perMinute(60)->by($request->ip());
});
```

## Troubleshooting

### 1. Common Issues

1. **Module Not Found**
   - Check module name case sensitivity
   - Verify module exists in packages/modules
   - Run composer dump-autoload

2. **Installation Failures**
   - Check PHP version compatibility
   - Verify Laravel version requirements
   - Check for conflicting dependencies

3. **Cache Issues**
   - Clear all caches
   - Check cache configuration
   - Verify cache permissions

### 2. Debug Commands

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Regenerate autoload files
composer dump-autoload

# Check module status
php artisan module:debug ModuleName
```

## Support

For Core module support:
- Create an issue on GitHub
- Contact core@naruto.com
- Join our developer community

## License

This documentation is part of the Carpe Diem Naruto project and is licensed under the MIT License. 