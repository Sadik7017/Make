<?php

namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use Modules\Core\Contracts\RepositoryInterface;
use Modules\Core\Contracts\ServiceInterface;
use Modules\Core\Repositories\BaseRepository;
use Modules\Core\Services\BaseService;
use Modules\Core\Console\Commands\Make\ModuleMakeCommand;
use Modules\Core\Services\ModuleManager;
use Modules\Core\Services\MarketplaceService;
use Modules\Core\Console\Commands\Actions\ModuleCheckUpdatesCommand;
use Modules\Core\Console\Commands\Actions\ModuleDisableCommand;
use Modules\Core\Console\Commands\Actions\ModuleCommandsListCommand;
use Modules\Core\Console\Commands\Actions\ModuleShowModelCommand;
use Modules\Core\Console\Commands\Actions\ModuleUnuseCommand;
use Modules\Core\Console\Commands\Actions\ModuleUseCommand;
use Modules\Core\Console\Commands\Actions\ModuleCheckLangCommand;
use Modules\Core\Console\Commands\Actions\ModuleMarketplaceCommand;
use Modules\Core\Console\Commands\ModuleStateCommand;
use Modules\Core\Console\Commands\Actions\ModuleEnableCommand;
use Modules\Core\Services\ModuleRegistrationService;
use Modules\Core\Console\Commands\ModuleDebugCommand;
use Modules\Core\Services\ModuleLoader;
use Modules\Core\Console\Commands\ModuleAutoloadCommand;
use Modules\Core\Console\Commands\Make\ModuleControllerMakeCommand;
use Modules\Core\Console\Commands\Make\ModuleModelMakeCommand;
use Modules\Core\Console\Commands\Make\ModuleResourceMakeCommand;
use Modules\Core\Console\Commands\Make\ModuleRepositoryMakeCommand;
use Modules\Core\Console\Commands\Make\ModuleMakeEventCommand;
use Modules\Core\Console\Commands\Make\MakeModuleRequest;
use Modules\Core\Console\Commands\Make\ModuleMakeHelperCommand;
use Modules\Core\Console\Commands\Make\ModuleMakeExceptionCommand;
use Modules\Core\Console\Commands\Make\ModuleMakeScopeCommand;
use Modules\Core\Console\Commands\Make\MakeComponentView;
use Modules\Core\Console\Commands\Make\MakeChannel;
use Modules\Core\Console\Commands\Make\MakeModuleClass;
use Modules\Core\Console\Commands\Make\MakeModuleArtisanCommand;
use Modules\Core\Console\Commands\Make\MakeModuleObserver;
use Modules\Core\Console\Commands\Make\MakeModulePolicy;
use Modules\Core\Console\Commands\Make\MakeModuleRule;
use Modules\Core\Console\Commands\Make\ModuleMiddlewareCommand;
use Modules\Core\Console\Commands\Make\MakeModuleTrait;
use Modules\Core\Console\Commands\Make\ModuleServiceMakeCommand;
use Modules\Core\Console\Commands\MigrateV1ModulesToV2;
use Modules\Core\Console\Commands\UpdatePhpunitCoverage;
use Modules\Core\Console\Commands\Actions\ModulePruneCommand;
use Modules\Core\Console\Commands\Make\MakeEnum;
use Modules\Core\Console\Commands\Make\ModuleEventProviderCommand;
use Modules\Core\Console\Commands\Make\MakeModuleComponent;
use Modules\Core\Console\Commands\Make\ModuleMakeListener;
use Modules\Core\Console\Commands\Make\ModuleMakeViewCommand;
use Modules\Core\Console\Commands\Make\MakeJobCommand;
use Modules\Core\Console\Commands\Make\MakeMailCommand;
use Modules\Core\Console\Commands\Make\MakeAction;
use Modules\Core\Console\Commands\Make\MakeModuleNotification;
use Modules\Core\Console\Commands\Make\MakeCastCommand;
use Modules\Core\Console\Commands\Make\MakeInterfaceCommand;
use Modules\Core\Console\Commands\Make\ModuleRouteProviderMakeCommand;
use Modules\Core\Console\Commands\Publish\ModulePublishAssetsCommand;
use Modules\Core\Console\Commands\Publish\ModulePublishConfig;
use Modules\Core\Console\Commands\Publish\ModulePublishMigration;
use Modules\Core\Console\Commands\Publish\ModulePublishTranslation;
use Modules\Core\Console\Commands\Database\Factories\MakeModuleFactory;
use Modules\Core\Console\Commands\Database\Migrations\MigrateRefresh;
use Modules\Core\Console\Commands\Database\Migrations\MigrateSingleModuleMigration;
use Modules\Core\Console\Commands\Database\Migrations\MigrateStatusCommand;
use Modules\Core\Console\Commands\Database\Migrations\ModuleMigrateFresh;
use Modules\Core\Console\Commands\Database\Migrations\ModuleMigrateResetCommand;
use Modules\Core\Console\Commands\Database\Migrations\ModuleMigrateRollbackCommand;
use Modules\Core\Console\Commands\Database\Migrations\ModuleMigrationMakeCommand;
use Modules\Core\Console\Commands\Database\Seeders\ListSeeders;
use Modules\Core\Console\Commands\Database\Seeders\MakeModuleSeeder;
use Modules\Core\Console\Commands\Database\Seeders\ModuleSeedCommand;







use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Modules\Core\Repositories\MainRepository;

class CoreServiceProvider extends ServiceProvider
{
    protected $moduleName = 'Core';
    protected $moduleNameLower = 'core';
    protected $moduleNamespace = 'Modules\Core';

    protected $commands = [
        ModuleMarketplaceCommand::class,
        ModuleStateCommand::class,
        ModuleEnableCommand::class,
        ModuleDisableCommand::class,
        ModuleMakeCommand::class,
        ModuleDebugCommand::class,
        ModuleCheckUpdatesCommand::class,
        ModuleControllerMakeCommand::class,
        ModuleModelMakeCommand::class,
        ModuleResourceMakeCommand::class, 
        ModuleRepositoryMakeCommand::class,
        ModuleMakeEventCommand::class,
        ModuleMakeHelperCommand::class,
        ModuleMakeExceptionCommand::class,
        ModuleMakeScopeCommand::class,
        MakeComponentView ::class,
        MakeChannel::class,
        MakeModuleClass::class,
        MakeModuleArtisanCommand::class,
        MakeModuleObserver::class,
        MakeModulePolicy::class,
        MakeModuleRule::class,
        MakeModuleTrait::class,
        MigrateV1ModulesToV2::class,
        UpdatePhpunitCoverage::class,
        ModulePruneCommand::class,
        MakeEnum::class,
        ModuleAutoloadCommand::class,
        MakeModuleComponent::class,
        MakeModuleRequest::class,
        ModuleMakeListener::class,
        ModuleMakeViewCommand::class,
        ModuleRouteProviderMakeCommand::class,
        ModulePublishAssetsCommand::class,
        ModulePublishConfig::class,
        ModulePublishMigration::class,
        ModulePublishTranslation::class,
        MakeModuleFactory::class,
        MigrateRefresh::class,
        MigrateSingleModuleMigration::class,
        MigrateStatusCommand::class,
        ModuleMigrateFresh::class,
        ModuleMigrateResetCommand::class,
        ModuleMigrateRollbackCommand::class,
        ModuleMigrationMakeCommand::class,
        ListSeeders::class,
        MakeModuleSeeder::class,
        ModuleSeedCommand::class,
        ModuleMiddlewareCommand::class,
        ModuleCommandsListCommand::class,
        ModuleShowModelCommand::class,
        ModuleUnuseCommand::class,
        ModuleUseCommand::class,
        ModuleEventProviderCommand::class,
        ModuleServiceMakeCommand::class,
        ModuleMarketplaceCommand::class,
        MakeCastCommand::class,
        MakeJobCommand::class,
        MakeMailCommand::class,
        MakeModuleNotification::class,
        MakeAction::class,
        MakeInterfaceCommand::class,
        ModuleCheckLangCommand::class





      
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        parent::register();

        $this->app->bind(RepositoryInterface::class, BaseRepository::class);
        // $this->app->bind(Repository::class, MainRepository::class);
        $this->app->bind(ServiceInterface::class, BaseService::class);
        $this->registerConfig();

        $this->app->singleton(ModuleManager::class);
        $this->app->singleton(ModuleRegistrationService::class);
        $this->app->singleton(MarketplaceService::class);

        $this->app->singleton(ModuleLoader::class, function ($app) {
            return new ModuleLoader();
        });

        $this->commands($this->commands);

        $this->registerModuleProviders();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerConfig();
        $this->registerCommands();
        $this->registerRoutes();
        $this->registerViews();
        $this->registerTranslations();
        $this->registerMigrations();
        $this->bootModules();
    }

    /**
     * Register config.
     */
    protected function registerConfig(): void
    {
        $configPath = base_path('modules/Core/src/Config/config.php');
        $marketplaceConfigPath = base_path('modules/Core/src/Config/marketplace.php');
        
        if (File::exists($configPath)) {
            $this->mergeConfigFrom($configPath, 'core');
        }

        if (File::exists($marketplaceConfigPath)) {
            $this->mergeConfigFrom($marketplaceConfigPath, 'marketplace');
        }

        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('core.php'),
        ], 'config');
    }

    /**
     * Register commands.
     */
    protected function registerCommands(): void
    {
        $configPath = base_path('modules/Core/src/Config/config.php');
        if (File::exists($configPath)) {
            $config = require $configPath;
            if (isset($config['commands'])) {
                $this->commands($config['commands']);
            }
        }

        $this->commands([
            ModuleAutoloadCommand::class,
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }
    }

    /**
     * Register routes.
     */
    protected function registerRoutes(): void
    {
        Route::group(['middleware' => ['web']], function () {
            $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
        });

        Route::group(['middleware' => ['api']], function () {
            $this->loadRoutesFrom(__DIR__.'/../Routes/api.php');
        });
    }

    /**
     * Register views.
     */
    protected function registerViews(): void
    {
        $viewPath = base_path('modules/Core/src/Resources/views');
        
        if (File::exists($viewPath)) {
            $this->loadViewsFrom($viewPath, 'core');
        }
    }

    /**
     * Register translations.
     */
    protected function registerTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'core');
    }

    /**
     * Register migrations.
     */
    protected function registerMigrations(): void
    {
        $migrationsPath = base_path('modules/Core/src/Database/Migrations');
        
        if (File::exists($migrationsPath)) {
            $this->loadMigrationsFrom($migrationsPath);
        }
    }

    /**
     * Register module service providers.
     */
    protected function registerModuleProviders(): void
    {
        try {
            $moduleManager = $this->app->make(ModuleManager::class);
            $modules = $moduleManager->getEnabledModules();
            
            \Illuminate\Support\Facades\Log::info('Enabled modules:', $modules);
            
            foreach ($modules as $module) {
                $studlyModule = Str::studly($module);
                $providerClass = "Modules\\{$studlyModule}\\Providers\\{$studlyModule}ServiceProvider";
                \Illuminate\Support\Facades\Log::info("Attempting to register provider: {$providerClass}");
                
                if (class_exists($providerClass)) {
                    try {
                        $provider = $this->app->resolveProvider($providerClass);
                        $this->app->register($provider);
                        \Illuminate\Support\Facades\Log::info("Successfully registered provider: {$providerClass}");
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error("Failed to register provider {$providerClass}: " . $e->getMessage());
                        throw $e;
                    }
                } else {
                    \Illuminate\Support\Facades\Log::warning("Provider class not found: {$providerClass}");
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error in registerModuleProviders: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Boot registered modules.
     */
    protected function bootModules(): void
    {
        try {
            $moduleManager = $this->app->make(ModuleManager::class);
            $modules = $moduleManager->getEnabledModules();
            
            foreach ($modules as $module) {
                $studlyModule = Str::studly($module);
                $providerClass = "Modules\\{$studlyModule}\\Providers\\{$studlyModule}ServiceProvider";
                if (class_exists($providerClass)) {
                    try {
                        $provider = $this->app->resolveProvider($providerClass);
                        if (method_exists($provider, 'boot')) {
                            // Call boot only if it exists and is callable
                            call_user_func([$provider, 'boot']);
                        }
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error("Failed to boot provider {$providerClass}: " . $e->getMessage());
                        throw $e;
                    }
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error in bootModules: " . $e->getMessage());
            throw $e;
        }
    }
} 