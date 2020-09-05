<?php

namespace GGPHP\Generator\Providers;

use Illuminate\Support\ServiceProvider;
use GGPHP\Generator\Console\Command\PackageMakeCommand;
use GGPHP\Generator\Console\Command\ProviderMakeCommand;
use GGPHP\Generator\Console\Command\ControllerMakeCommand;
use GGPHP\Generator\Console\Command\RouteMakeCommand;

class GeneratorServiceProvider extends ServiceProvider
{
    protected $commands = [
        PackageMakeCommand::class,
        ProviderMakeCommand::class,
        ControllerMakeCommand::class,
        RouteMakeCommand::class
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
