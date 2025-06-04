<?php

namespace Modules\Core\Console\Commands\Make;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
// use Modules\Core\src\Console\Commands\Generators\GeneratorCommand;
use Modules\Core\Console\Commands\GeneratorCommand;

class ModuleMakeViewCommand extends Command
{
    protected $signature = 'module:make-view 
                            {name : The name of the view (e.g. users.index)} 
                            {module : The name of the module}';

    protected $description = 'Create a new view file for the specified module';

    public function handle(): int
    {
        $view = $this->argument('name');
        $module = Str::studly($this->argument('module'));

        $path = $this->getDestinationFilePath();
        $directory = dirname($path);

        if (File::exists($path)) {
            $this->error("View file already exists: {$path}");
            return Command::FAILURE;
        }

        if (! File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $stub = $this->getTemplateContents();

        File::put($path, $stub);

        $this->info("View created: {$path}");
        return Command::SUCCESS;
    }

    protected function getTemplateContents(): string
    {
        $view = $this->argument('name');
        $module = Str::studly($this->argument('module'));

        $stubPath = base_path('Modules/Core/src/Console/Commands/stubs/view.stub');

        return str_replace(
            ['{{ view_name }}', '{{ module_name }}'],
            [$view, $module],
            File::get($stubPath)
        );
    }

    protected function getDestinationFilePath(): string
    {
        $view = $this->argument('name');
        $module = Str::studly($this->argument('module'));

        $viewPath = str_replace('.', '/', $view) . '.blade.php';

        return base_path("Modules/{$module}/src/resources/views/{$viewPath}");
    }
}
