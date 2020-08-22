<?php

namespace GGPHP\Generator;

use Illuminate\Support\ServiceProvider;
use GGPHP\Generator\Console\PackageMakeCommand;
use GGPHP\Generator\Console\ControllerMakeCommand;
use GGPHP\Generator\Console\ProviderMakeCommand;

class GeneratorServiceProvider extends ServiceProvider
{
    protected $commands = [
        PackageMakeCommand::class,
        ControllerMakeCommand::class,
        ProviderMakeCommand::class
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
    }
}
