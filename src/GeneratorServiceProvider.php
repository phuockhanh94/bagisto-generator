<?php

namespace GGPHP\Generator;

use Illuminate\Support\ServiceProvider;
use GGPHP\Generator\Console\PackageMakeCommand;
use GGPHP\Generator\Console\ControllerMakeCommand;

class GeneratorServiceProvider extends ServiceProvider
{
    protected $commands = [
        PackageMakeCommand::class,
        ControllerMakeCommand::class
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
