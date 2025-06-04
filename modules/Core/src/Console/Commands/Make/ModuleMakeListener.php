<?php

namespace Modules\Core\Console\Commands\Make;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ModuleMakeListener extends Command
{
    protected $signature = 'module:make-listener {module} {name} {event}';

    protected $description = 'Create a new event listener class for the specified module';

    public function handle()
    {
        $module = Str::studly($this->argument('module'));
        $name = Str::studly($this->argument('name'));
        $event = Str::studly($this->argument('event'));

        $basePath = base_path("Modules/{$module}/src/Listeners");
        $namespace = "Modules\\{$module}\\Listeners";
        $eventClass = "Modules\\{$module}\\Events\\{$event}";

        $stub = File::get(base_path("Modules/Core/src/console/commands/stubs/listener.stub"));
        $stub = str_replace(
            ['{{ namespace }}', '{{ class }}', '{{ event }}'],
            [$namespace, $name, $eventClass],
            $stub
        );

        if (!File::exists($basePath)) {
            File::makeDirectory($basePath, 0755, true);
        }

        $filePath = "{$basePath}/{$name}.php";

        if (File::exists($filePath)) {
            $this->error("Listener {$name} already exists in module {$module}.");
            return;
        }

        File::put($filePath, $stub);

        $this->info("Listener {$name} created successfully in module {$module}.");
    }
}
