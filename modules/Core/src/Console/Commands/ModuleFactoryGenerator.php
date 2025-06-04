<?php

namespace Modules\Core\Generators;

use Dom\Comment;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FactoryGenerator extends Comment
{
    protected string $name;
    protected string $module;

    public function __construct(string $name, string $module)
    {
        $this->name = Str::studly($name);
        $this->module = Str::studly($module);
    }

    public function getPath(): string
    {
        return base_path("Modules/{$this->module}/Database/Factories/{$this->name}Factory.php");
    }

    public function exists(): bool
    {
        return File::exists($this->getPath());
    }

    public function generate(): void
    {
        $directory = dirname($this->getPath());

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        File::put($this->getPath(), $this->getStubContents());
    }

    protected function getStubContents(): string
    {
        $stubPath = base_path('Modules/Core/Resources/stubs/factory.stub');

        if (!File::exists($stubPath)) {
            throw new \RuntimeException("Stub file not found at: {$stubPath}");
        }

        $stub = File::get($stubPath);

        return str_replace(
            ['{{ module_name }}', '{{ class_name }}', '{{ model_namespace }}'],
            [$this->module, $this->name, "Modules\\{$this->module}\\Entities\\{$this->name}"],
            $stub
        );
    }
}
