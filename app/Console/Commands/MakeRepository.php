<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRepository extends Command
{
    protected $signature = 'make:repository
                            {name : Repository name, e.g., Brand}
                            {--impl : Generate repository implementation}
                            {--model= : Model name (default = name)}';

    protected $description = 'Create a new repository class';

    public function handle()
    {
        $name  = $this->argument('name');
        $model = $this->option('model') ?? $name;
        $impl  = $this->option('impl');

        $stub = __DIR__ . '/stubs/repository.stub';

        if (!File::exists($stub)) {
            return $this->error("Repository stub not found: {$stub}");
        }

        $content = File::get($stub);
        $content = str_replace(
            ['{{ name }}', '{{ nameLower }}', '{{ model }}'],
            [$name, lcfirst($name), $model],
            $content
        );

        $path = app_path("Repository/{$name}Repository.php");

        if (File::exists($path)) {
            return $this->warn("Repository {$name}Repository already exists.");
        }

        File::ensureDirectoryExists(app_path('Repository'));
        File::put($path, $content);
        $this->info("Repository {$name}Repository created.");

        if ($impl) {
            $implStub = __DIR__ . '/stubs/repository.impl.stub';

            if (!File::exists($implStub)) {
                return $this->error("Repository impl stub not found: {$implStub}");
            }

            $implContent = File::get($implStub);
            $implContent = str_replace(
                ['{{ name }}', '{{ nameLower }}', '{{ model }}'],
                [$name, lcfirst($name), $model],
                $implContent
            );

            $implPath = app_path("Repository/{$name}RepositoryImpl.php");

            if (File::exists($implPath)) {
                return $this->warn("Repository {$name}RepositoryImpl already exists.");
            }

            File::put($implPath, $implContent);
            $this->info("Repository {$name}RepositoryImpl created.");
        }
    }
}
