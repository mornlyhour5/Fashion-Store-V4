<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeService extends Command  // ✅ MakeService not MakeServices
{
    protected $signature = 'make:service
                            {name : Service name, e.g., Brand}
                            {--impl : Generate service implementation}';

    protected $description = 'Create a new service class';

    public function handle()
    {
        $name = $this->argument('name');
        $impl = $this->option('impl');

        $stub = __DIR__ . '/stubs/service.stub';

        if (!File::exists($stub)) {
            return $this->error("Service stub not found: {$stub}");
        }

        $content = File::get($stub);
        $content = str_replace(
            ['{{ name }}', '{{ nameLower }}'],
            [$name, lcfirst($name)],
            $content
        );

        $path = app_path("Services/{$name}Service.php");

        if (File::exists($path)) {
            return $this->warn("Service {$name}Service already exists.");
        }

        File::ensureDirectoryExists(app_path('Services'));
        File::put($path, $content);
        $this->info("Service {$name}Service created.");
    }
}
