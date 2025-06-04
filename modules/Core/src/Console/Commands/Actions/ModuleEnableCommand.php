<?php

namespace Modules\Core\Console\Commands\Actions;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class ModuleEnableCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:enable {name : The name of the module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enable a module';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');

        $this->info("Enabling module [{$name}]...");

        try {
            // Check if module exists
            $modulePath = base_path("modules/{$name}");
            if (!File::exists($modulePath)) {
                $this->error("Module [{$name}] not found in modules directory");
                return 1;
            }

            // Check if module state exists
            $moduleState = DB::table('module_states')->where('name', $name)->first();
            if (!$moduleState) {
                // Create module state if it doesn't exist
                DB::table('module_states')->insert([
                    'name' => $name,
                    'version' => '1.0.0',
                    'description' => "{$name} module for the application",
                    'enabled' => true,
                    'status' => 'enabled',
                    'last_enabled_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                // Update module state
                DB::table('module_states')
                    ->where('name', $name)
                    ->update([
                        'enabled' => true,
                        'status' => 'enabled',
                        'last_enabled_at' => now(),
                        'updated_at' => now(),
                    ]);

                // Update module.json file
                $moduleJsonPath = base_path("modules/{$name}/module.json");
                if (File::exists($moduleJsonPath)) {
                    $moduleJson = json_decode(File::get($moduleJsonPath), true);
                    $moduleJson['enabled'] = true;
                    $moduleJson['last_enabled_at'] = now()->toIso8601String();
                    File::put($moduleJsonPath, json_encode($moduleJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
                }
            }

            // Run composer dump-autoload
            $this->info('Running composer dump-autoload...');
            exec('composer dump-autoload');

            // Run package discovery
            $this->info('Running package discovery...');
            $this->call('package:discover');

            $this->info("Module [{$name}] enabled successfully");
            return 0;
        } catch (\Exception $e) {
            $this->error("Failed to enable module [{$name}]: " . $e->getMessage());
            return 1;
        }
    }
} 