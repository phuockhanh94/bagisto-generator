<?php

namespace GGPHP\Generator\Console\Command;

class RouteMakeCommand extends MakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:make-route {package} {--controller=} {--api} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new route class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Route';

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $this->getClassNamespace($rootNamespace). '\Http';
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $stub = $this->option('api') ? 'scaffold/routes-api.stub' : 'routes.stub';

        return realpath(__DIR__. "/../stubs/{$stub}");
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $classController = $this->getClassController();
        if (!str_contains($stub, 'NamespacedDummyController')) {
            $classController = $this->getNamespaceController(). '\\'. $classController;
        }

        return str_replace(
            ['NamespacedDummyController', 'DummyResource', 'ClassedDummyController', 'DummyEndPoint'],
            [$this->getNamespaceController(), $this->getLowerName(), $classController, $this->getPluralName()],
            $stub
        );
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return 'routes';
    }

    /**
     * Get the name space Controller
     *
     * @return string
     */
    protected function getNamespaceController()
    {
        return $this->rootNamespace(). 'Http\Controllers';
    }

    /**
     * Get the name class Controller
     *
     * @return string
     */
    protected function getClassController()
    {
        if (!empty($this->option('controller'))) {
            $class = $this->option('controller');
        } else {
            $class = $this->getStudlyName(). 'Controller';
        }

        return $class;
    }
}
