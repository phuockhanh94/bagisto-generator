<?php

namespace GGPHP\Generator\Console\Command;

class ControllerMakeCommand extends MakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:make-controller {name} {package} {--api} {--route} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new controller class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (parent::handle() === false && ! $this->option('force')) {
            return;
        }

        if ($this->option('route')) {
            $this->createRoute();
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
        return $rootNamespace. '\Http\Controllers';
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $stub = $this->option('api') ? 'scaffold/controller-api.stub' : 'controller.stub';

        return realpath(__DIR__. "/../stubs/{$stub}");
    }

    /**
     * Create a model factory for the model.
     *
     * @return void
     */
    protected function createRoute()
    {
        $namepackage = $this->getNamePackage();

        $this->call('package:make-route', [
            'package' => $namepackage,
            '--api' => $this->option('api'),
        ]);
    }
}
