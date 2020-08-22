<?php

namespace GGPHP\Generator\Console;

use Illuminate\Foundation\Console\ProviderMakeCommand as BaseProviderMakeCommand;
use InvalidArgumentException;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class ProviderMakeCommand extends BaseProviderMakeCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'gg:make-provider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new provider class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Provider';

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Providers';
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        return $this->option('space') ? $this->option('space'). '\\' : 'GGPHP';
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = str_replace_first($this->rootNamespace(), $this->rootNamespace().'src'. '\\', $name);

        return $this->laravel->basePath(). '/packages/'. str_replace('\\', '/', $name).'.php';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array_merge(
            parent::getOptions(),
            [
                ['space', 's', InputOption::VALUE_OPTIONAL, 'Generate a name space.']
            ]
        );
    }
}
