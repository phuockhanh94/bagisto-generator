<?php

namespace GGPHP\Generator\Console;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class PackageMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:package';

    // protected $signature = 'make:package {name : The name of the class} {--path= : Path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new package class';

    /**
     * The console command name space.
     *
     * @var string
     */
    protected $nameSpace;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $nameSpace = str_replace('/', '\\', $this->argument('name'));

        $this->nameSpace = $nameSpace;

        $nameProvider = str_replace($this->getNamespace($this->nameSpace).'\\', '', $this->nameSpace);

        // Check exists Provider
        if (!$this->checkExistsFile('provider', Str::studly("{$nameProvider}ServiceProvider"))) {
            $this->createProvider($nameProvider);
        }

        if ($this->option('all')) {
            $this->input->setOption('controller', true);
        }

        if ($this->option('controller')) {
            do {
                // Check exists base controller
                if (!$this->checkExistsFile('controller', 'Controller')) {
                    $this->createController('');
                }
                $name = $this->ask('What is name of Controller?');
                $this->createController($name);

            } while ($this->confirm('Do you want continue create Controller?'));
        }
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace;
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        return $this->nameSpace ?? 'GGPHP';
    }

     /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return;
    }

    /**
     * Determine if the class already exists.
     *
     * @param  string  $rawName
     * @return bool
     */
    protected function checkExistsFile($type, $rawName)
    {
        if ($type === 'controller') {
            $rawName = 'Http\Controllers\\'. $rawName;
        }

        if ($type === 'provider') {
            $rawName = 'Providers\\'. $rawName;
        }

        $rawName = $this->rootNamespace(). '\src\\'. $rawName;
        $path = $this->laravel->basePath(). '/packages/'. str_replace('\\', '/', $rawName). '.php';

        return $this->files->exists($path);
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['all', 'a', InputOption::VALUE_NONE, 'Generate a migration, factory, and resource controller for the model'],
            ['force', 'f', InputOption::VALUE_NONE, 'Create the class even if the repository already exists.'],
            ['controller', 'c', InputOption::VALUE_NONE, 'Create a new controller for the model'],
            ['storage', 's', InputOption::VALUE_NONE, 'Create a new controller for the model'],
        ];
    }

    /**
     * Create a controller for the package.
     *
     * @return void
     */
    protected function createController($name)
    {
        $controller = Str::studly($name);

        $this->call('gg:make-controller', [
            'name' => "{$controller}Controller",
            '--space' => $this->nameSpace
        ]);
    }

    /**
     * Create a provider for the package.
     *
     * @return void
     */
    protected function createProvider($name)
    {
        $name = Str::studly($name);

        $this->call('gg:make-provider', [
            'name' => "{$name}ServiceProvider",
            '--space' => $this->nameSpace
        ]);
    }
}
