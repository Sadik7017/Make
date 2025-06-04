<?php

namespace Modules\Core\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ModuleMigrateCommand extends Command
{
    protected $signature = 'module:migrate {module? : The name of the module} {--force : Force the migration}';
    protected $description = 'Run migrations for a specific module or all modules';

    public function handle()
    {
        $moduleName = $this->argument('module');
        $force = $this->option('force');

        if ($moduleName) {
            $this->migrateModule($moduleName, $force);
        } else {
            $this->migrateAllModules($force);
        }
    }

    protected function migrateModule($moduleName, $force = false)
    {
        $this->info("Migrating module [{$moduleName}]...");
        
        $migrationPath = base_path("modules/{$moduleName}/src/Database/Migrations");
        
        if (!File::exists($migrationPath)) {
            $this->warn("No migration files found in [{$migrationPath}]");
            return;
        }

        // Ensure migrations table exists
        if (!Schema::hasTable('migrations')) {
            Schema::create('migrations', function ($table) {
                $table->id();
                $table->string('migration');
                $table->integer('batch');
            });
        }

        $files = File::glob("{$migrationPath}/*.php");
        
        foreach ($files as $migration) {
            $migrationName = pathinfo($migration, PATHINFO_FILENAME);
            
            // Check if migration already exists
            $exists = DB::table('migrations')
                ->where('migration', $migrationName)
                ->exists();
                
            if (!$exists || $force) {
                try {
                    require_once $migration;
                    
                    // Get the migration class
                    $migrationClass = require $migration;
                    
                    if (!is_object($migrationClass)) {
                        throw new \Exception("Invalid migration class in file: {$migration}");
                    }
                    
                    $migrationClass->up();

                    // Record the migration
                    DB::table('migrations')->insert([
                        'migration' => $migrationName,
                        'batch' => DB::table('migrations')->max('batch') + 1
                    ]);

                    $this->info("Migration {$migrationName} completed successfully");
                } catch (\Exception $e) {
                    $this->error("Error running migration {$migrationName}: " . $e->getMessage());
                    if (!$force) {
                        throw $e;
                    }
                }
            } else {
                $this->info("Migration {$migrationName} already exists");
            }
        }
    }

    protected function migrateAllModules($force = false)
    {
        $modules = File::directories(base_path('modules'));
        
        foreach ($modules as $modulePath) {
            $moduleName = basename($modulePath);
            $this->migrateModule($moduleName, $force);
        }
    }
} 