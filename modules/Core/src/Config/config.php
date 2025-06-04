<?php

return array (
  'name' => 'Core',
  'description' => 'Core module for managing other modules',
  'version' => '1.0.0',
  'enabled' => true,
  'dependencies' => 
  array (
  ),
  'autoload' => 
  array (
    'auto_cleanup' => true,
    'core_modules' => 
    array (
      0 => 'Core',
    ),
  ),
  'commands' => 
  array (
    0 => 'Modules\\Core\\Console\\Commands\\ModuleAutoloadCommand',
    1 => 'Modules\\Core\\Console\\Commands\\Make\\ModuleMakeCommand',
    2 => 'Modules\\Core\\Console\\Commands\\Make\\ModuleModelMakeCommand',
    3 => 'Modules\\Core\\Console\\Commands\\Make\\ModuleControllerMakeCommand',
    4 => 'Modules\\Core\\Console\\Commands\\Make\\ModuleResourceMakeCommand',
    5 => 'Modules\\Core\\Console\\Commands\\Actions\\ModuleEnableCommand',
    6 => 'Modules\\Core\\Console\\Commands\\Actions\\ModuleDisableCommand',
    7 => 'Modules\\Core\\Console\\Commands\\Actions\\ModuleMarketplaceCommand',
    8 => 'Modules\\Core\\Console\\Commands\\ModuleHealthCheckCommand',
    9 => 'Modules\\Core\\Console\\Commands\\ModuleMigrateCommand',
    11 => 'Modules\\Core\\Console\\Commands\\Make\\ModuleMiddlewareCommand',
    13 => 'Modules\\Core\\Console\\Commands\\ModuleMigrationAddColumnCommand',
  ),
  'paths' => 
  array (
    'modules' => 'C:\\xampp\\htdocs\\RCVProjects\\Experiments\\carpe-diem-bagisto-fine-tuned\\carpe-diem-bagisto\\modules',
    'generator' => 
    array (
      'config' => 'src/Config',
      'command' => 'src/Console/Commands',
      'migration' => 'src/Database/Migrations',
      'seeder' => 'src/Database/Seeders',
      'factory' => 'src/Database/Factories',
      'model' => 'src/Models',
      'repository' => 'src/Repositories',
      'service' => 'src/Services',
      'controller' => 'src/Http/Controllers',
      'middleware' => 'src/Http/Middleware',
      'request' => 'src/Http/Requests',
      'provider' => 'src/Providers',
      'assets' => 'src/Resources/assets',
      'lang' => 'src/Resources/lang',
      'views' => 'src/Resources/views',
      'routes' => 'src/Routes',
      'test' => 'tests',
    ),
  ),
  'cache' => 
  array (
    'enabled' => true,
    'ttl' => 3600,
  ),
  'pagination' => 
  array (
    'per_page' => 10,
    'max_per_page' => 100,
  ),
  'modules' => 
  array (
    0 => 'Individual',
    1 => 'Agency',
    2 => 'Socialmanagement',
    3 => 'CollageStudent',
  ),
);
