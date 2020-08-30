<?php

namespace GGPHP\Generator\Console\Command;

class ProviderMakeCommand extends MakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:make-provider {name} {package} {--force} {--plain}';

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
        return $this->getClassNamespace($rootNamespace). '\Providers';
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $stub = $this->option('plain') ? 'provider.stub' : 'scaffold/package-provider.stub';

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
        $class = str_replace($this->getNamespace($name).'\\', '', $name);

        return str_replace(
            ['DummyClass', 'DummyResource'],
            [$class, $this->getLowerName()],
            $stub
        );
    }

    /**
     * @return string
     */
    private function getLowerName()
    {
        return strtolower(class_basename($this->getNamePackage()));
    }
}
