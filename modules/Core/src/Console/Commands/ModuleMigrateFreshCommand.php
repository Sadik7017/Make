<?php

namespace Modules\Core\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class ModuleMigrateFreshCommand extends Command
{
    protected $signature = 'module:migrate-fresh 
        {name : The name of the request class (optional usage)} 
        {module : The module name}';

    protected $description = 'Reset all database tables and re-run the specified module\'s migrations';

    public function handle()
    {
        $name = Str::studly($this->argument('name'));
        $module = Str::studly($this->argument('module'));

        $this->info("Resetting all migrations...");
        Artisan::call('migrate:fresh', [], $this->getOutput());

        $this->info("Running migrations for module: {$module}");

        // Assumes you're using `nwidart/laravel-modules`
        Artisan::call("module:migrate", [
            'module' => $module,
        ], $this->getOutput());

        $this->info(" Fresh migration completed for module: {$module}");

        // Optional: generate a request class if needed
        $this->info("Note: You provided a request class name: {$name} (not used in migration).");
    }
}
