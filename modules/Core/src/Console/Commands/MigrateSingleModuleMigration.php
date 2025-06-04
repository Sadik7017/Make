<?php

namespace Modules\Core\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class MigrateSingleModuleMigration extends Command
{
    protected $signature = 'module:migrate-one {migration_name} {module_name}';
    protected $description = 'Run a specific migration file from a specific module';

    public function handle()
    {
        $migrationName = $this->argument('migration_name');
        $moduleName = $this->argument('module_name');

        $migrationPath = base_path("Modules/{$moduleName}/src/Database/Migrations");

        // Check if migration directory exists
        if (!File::exists($migrationPath)) {
            $this->error(" Module '{$moduleName}' does not exist or has no migrations at: {$migrationPath}");
            return 1;
        }

        // Find matching migration file
        $migrationFile = collect(File::files($migrationPath))->first(function ($file) use ($migrationName) {
            return str_contains($file->getFilename(), $migrationName);
        });

        if (!$migrationFile) {
            $this->error(" Migration '{$migrationName}' not found in module '{$moduleName}'.");
            return 1;
        }

        $this->info(" Running migration: {$migrationFile->getFilename()}");

        // Normalize and convert to relative path (cross-platform)
        $fullPath = str_replace('\\', '/', $migrationFile->getPathname());
        $relativePath = str_replace(str_replace('\\', '/', base_path()) . '/', '', $fullPath);

        // Run the specific migration
        Artisan::call('migrate', [
            '--path' => $relativePath,
        ]);

        // Output migration result
        $this->line(Artisan::output());

        return 0;
    }
}