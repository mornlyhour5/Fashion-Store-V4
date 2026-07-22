<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BindingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    // public function register(): void
    // {
    //     $config = config('bindings.paths', []); //

    //     foreach ($config as $file) { // loop over every resister binding file path.
    //         if (!file_exists($file)) continue;
    //         // Safety check if a listed file is missing, skip, it silently instead of crashing the whole app on boot

    //         $bindings = require $file;
    //         // Actually loads the PHP file and captures whatever array it return
    //         // -> this is the same trick Laravel own config/*.php files use.

    //         $isSingleton = str_contains($file, 'singleton');
    //         // A naming convention, not a config flag if the word "singleton" appears anywhere
    //         // in the file path , every binding in the file is treated as a singleton.

    //         foreach ($bindings as $abstract => $concrete)
    //         // Loops over the key-value pair in that file $abstract
    //         // is usually an interface, $concrete is the class that inplements it.
    //         {
    //             if($isSingleton) {
    //                 $this->app->singleton($abstract, $concrete);
    //             } else {
    //                 $this->app->bind($abstract, $concrete);
    //             }
    //             //Registers the pair into Laravel's service container using the appropriate lifecycle.
    //         }
    //     }
    // }

    public function register(): void
    {
        $config = config('bindings.paths', []);

        foreach ($config as $file) {
            if (!file_exists($file)) continue;

            $bindings = require $file;

            if (!is_array($bindings)) {
                dd($file, $bindings);
            }

            $isSingleton = str_contains($file, 'singleton');

            foreach ($bindings as $abstract => $concrete) {
                if ($isSingleton) {
                    $this->app->singleton($abstract, $concrete);
                } else {
                    $this->app->bind($abstract, $concrete);
                }
            }
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
