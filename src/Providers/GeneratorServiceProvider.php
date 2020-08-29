<?php

namespace GGPHP\Generator\Providers;

use Illuminate\Support\ServiceProvider;
use GGPHP\Generator\Console\Command\PackageMakeCommand;
use GGPHP\Generator\Console\Command\ProviderMakeCommand;

class GeneratorServiceProvider extends ServiceProvider
{
    protected $commands = [
        PackageMakeCommand::class,
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
