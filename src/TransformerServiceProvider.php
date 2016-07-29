<?php

namespace Dizzy\Transformer;

use Illuminate\Support\ServiceProvider;

class TransformerServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . "/config/transformer.php" => config_path('transformer.php')
        ]);
        $this->mergeConfigFrom(
            __DIR__ . "/config/transformer.php", 'transformer'
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() { } // Nothing to register sorry :(
}
