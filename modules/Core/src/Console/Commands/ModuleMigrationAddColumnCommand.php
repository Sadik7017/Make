<?php
namespace Modules\Core\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ModuleMigrationAddColumnCommand extends Command
{
    protected $signature = 'module:add-column
        {table : The table to modify}
        {column : The column to add}
        {module : The module name}
        {--type=string : The column type (string, text, integer, etc.)}';
    protected $description = 'Create a new migration to add a column to a module table';

    public function handle()
    {
        $table  = $this->argument('table');
        $column = $this->argument('column');
        $module = $this->argument('module');
        $type   = $this->option('type');

        $basePath = base_path("modules/{$module}/src/Database/Migrations");
        if (!File::exists($basePath)) {
            File::makeDirectory($basePath, 0755, true);
        }

        $timestamp     = date('Y_m_d_His');
        $fileName      = "{$timestamp}add{$column}to{$table}_table.php";
        $migrationPath = "{$basePath}/{$fileName}";

        $stub = File::get(__DIR__ . '/stubs/add_column.stub');
        $content = str_replace(
            ['{{ table }}','{{ column }}','{{ type }}'],
            [$table, $column, $type],
            $stub
        );

        File::put($migrationPath, $content);
        $this->info("Migration [{$fileName}] created: add '{$column}' to '{$table}' in module '{$module}'");
    }
}