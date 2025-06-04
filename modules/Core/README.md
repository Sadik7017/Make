# Core Module

The Core module is the foundation of the modular system in this application. It provides essential functionality for module management, including module autoloading, marketplace integration, and module lifecycle management.

## Module Management System

### Autoloading System

The application uses a centralized module management system where:
- Only the Core module is registered in the main `composer.json`
- All other modules are managed through their own individual `composer.json` files
- Module autoloading is handled automatically through the Core module

#### How It Works

1. **Main composer.json**
   - Contains only the Core module in its autoload configuration
   - Example:
   ```json
   {
       "autoload": {
           "psr-4": {
               "Modules\\Core\\": "modules/Core/src/"
           }
       }
   }
   ```

2. **Module-specific composer.json**
   - Each module has its own composer.json
   - Manages its own dependencies and autoloading
   - Example:
   ```json
   {
       "name": "modules/your-module",
       "autoload": {
           "psr-4": {
               "Modules\\YourModule\\": "src/"
           }
       }
   }
   ```

### Commands

#### `module:autoload`
Maintains the autoloading configuration by:
- Removing any non-Core module entries from main composer.json
- Ensuring Core module is properly registered
- Running composer dump-autoload

```bash
php artisan module:autoload
```

### Module Lifecycle

1. **Installing a New Module**
   ```bash
   # Create new module
   php artisan module:make ModuleName
   
   # Install module
   php artisan module:marketplace install ModuleName
   
   # Enable module
   php artisan module:enable ModuleName
   ```

2. **Removing a Module**
   ```bash
   # Remove module
   php artisan module:marketplace remove ModuleName
   
   # Clean up autoload
   php artisan module:autoload
   ```

### Best Practices

1. **Adding Dependencies**
   - Add module-specific dependencies to the module's own composer.json
   - Run `composer update` from the project root

2. **Maintaining Clean Configuration**
   - Always use `module:autoload` after removing modules
   - Keep module-specific code and dependencies within the module
   - Use the Core module's services for cross-module functionality

## Module Structure

```
modules/
├── Core/
│   ├── src/
│   │   ├── Console/
│   │   │   └── Commands/
│   │   ├── Providers/
│   │   └── Services/
│   ├── composer.json
│   └── README.md
└── YourModule/
    ├── src/
    └── composer.json
```

## Contributing

When contributing to the module system:
1. Ensure all new modules follow the established structure
2. Use the Core module's services for module management
3. Document any changes to the module system
4. Test module installation and removal processes 