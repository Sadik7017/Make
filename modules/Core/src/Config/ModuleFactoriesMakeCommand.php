<?php

namespace Modules\Core\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class ModuleFactoriesMakeCommand extends Command
{
    protected $name = 'module:make-factories {name : The name of the Factories} {module : The name of the module}';
    protected $description = 'Create a new model Factories for the specified module.';

    public function handle()
    {
        $FactoriesPath = $this->getDestinationFilePath();

        if (File::exists($FactoriesPath)) {
            $this->error("Factories already exists: {$FactoriesPath}");
            return;
        }

        File::ensureDirectoryExists(dirname($FactoriesPath));
        File::put($FactoriesPath, $this->getTemplateContents());

        $this->info("Factories created at: {$FactoriesPath}");
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the model.'],
            ['module', InputArgument::OPTIONAL, 'The name of the module.'],
        ];
    }

    protected function getModuleName(): string
    {
        return Str::studly($this->argument('module') ?? $this->ask('Module name?'));
    }

    protected function getModelName(): string
    {
        return Str::studly($this->argument('name'));
    }

    protected function getFileName(): string
    {
        return $this->getModelName() . 'Factories.php';
    }

    protected function getDestinationFilePath(): string
    {
        return base_path("Modules/{$this->getModuleName()}/Database/Factories/{$this->getFileName()}");
    }

    protected function getClassNamespace(): string
    {
        return "Modules\\{$this->getModuleName()}\\Database\\Factories";
    }

    protected function getModelNamespace(): string
    {
        return "Modules\\{$this->getModuleName()}\\Entities\\{$this->getModelName()}";
    }

        protected function getTemplateContents(): string
        {
            $namespace = $this->getClassNamespace();
            $modelNamespace = $this->getModelNamespace();
            $className = $this->getModelName();
    
            return <<<EOT
    
    
    EOT;
        }
}



