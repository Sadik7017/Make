<?php

namespace Modules\Core\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ModuleSeederMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make-seed {name : The name of the seeder} {module : The name of the module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new seeder for a module';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $module = $this->argument('module');

        // Ensure module exists
        if (!File::exists(base_path("modules/{$module}"))) {
            $this->error("Module [{$module}] does not exist.");
            return 1;
        }

        // Create seeders directory if it doesn't exist
        $seederPath = base_path("modules/{$module}/src/Database/Seeders");
        if (!File::exists($seederPath)) {
            File::makeDirectory($seederPath, 0755, true);
        }

        // Generate seeder file
        $seederFile = "{$seederPath}/{$name}.php";
        $stub = File::get(__DIR__ . '/stubs/seeder.stub');

        // Replace placeholders
        $content = str_replace(
            ['{{ module_name }}', '{{ class_name }}'],
            [$module, str_replace('.php', '', $name)],
            $stub
        );

        // Create seeder file
        File::put($seederFile, $content);
        $this->info("Seeder [{$name}] created successfully.");
        $this->info("Path: {$seederFile}");

        return 0;
    }
}