<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeCrud extends Command
{
    protected $signature = 'make:crud
                            {name : Resource name e.g., Brand}
                            {--impl : Generate Repository implementation}
                            {--model= : Model name (default = name)}';
                        //          ↑ Add = here

    protected $description = 'Generate repository, service, and controller using existing stubs';

    public function handle()
{
    $name  = $this->argument('name');
    $model = $this->option('model') ?? $name;
    $impl  = $this->option('impl');

    $this->info("⚙️ Generating CRUD for {$name}");

    // -----------------------------
    // 1️⃣ REPOSITORY
    // -----------------------------
    $repoArgs = [
        'name'    => $name,
        '--model' => $model,
    ];
    if ($impl) $repoArgs['--impl'] = true; // ✅ only pass when true

    $this->call('make:repository', $repoArgs);

    // -----------------------------
    // 2️⃣ SERVICE
    // -----------------------------
    $serviceArgs = [
        'name' => $name,
    ];
    if ($impl) $serviceArgs['--impl'] = true; // ✅ only pass when true

    $this->call('make:service', $serviceArgs);

    // -----------------------------
    // 3️⃣ CONTROLLER
    // -----------------------------
    $this->makeController($name);

    // -----------------------------
    // 4️⃣ MODEL
    // -----------------------------
    $this->makeModel($model);

    $this->info("\n✨ CRUD for {$name} generated successfully.");
}

    protected function makeController(string $name)
    {
        $controllerPath = app_path("Http/Controllers/{$name}Controller.php");

        if (File::exists($controllerPath)) {
            return $this->warn("Controller {$name}Controller already exists.");
        }

        $stub = __DIR__ . '/stubs/controller.stub';

        if (!File::exists($stub)) {
            return $this->error("Controller stub not found: {$stub}");
        }

        $content = File::get($stub);

        $content = str_replace(
            ['{{ name }}', '{{ nameLower }}'],
            [$name,        lcfirst($name)],
            $content
        );

        File::ensureDirectoryExists(app_path("Http/Controllers"));
        File::put($controllerPath, $content);

        $this->info("Controller {$name}Controller created."); // ✅ Added success message
    }

    protected function makeModel(string $name)
    {
        $modelPath = app_path("Models/{$name}.php");

        if (File::exists($modelPath)) {
            return $this->warn("Model {$name} already exists.");
        }

        $stub = __DIR__ . '/stubs/model.stub';

        if (!File::exists($stub)) {
            return $this->error("Model stub not found: {$stub}");
        }

        $content = File::get($stub);

        $content = str_replace(
            ['{{ name }}', '{{ nameLower }}'],
            [$name, lcfirst($name)],
            $content
        );

        File::ensureDirectoryExists(app_path("Models"));
        File::put($modelPath, $content);

        $this->info("Model {$name} created.");
    }
}
