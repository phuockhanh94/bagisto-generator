<?php

namespace GGPHP\Generator\Console\Command;

use Illuminate\Console\GeneratorCommand;

class MakeCommand extends GeneratorCommand
{
    /**
     * The package name
     *
     * @var string
     */
    protected $packageName;

    /**
     * @param  string  $name
     * @return string
     */
    protected function getClassNamespace($name)
    {
        return str_replace('/', '\\', $name);
    }

    /**
     * @param  string  $name
     * @return string
     */
    protected function getNamePackage()
    {
        return $this->argument('package') ?? 'GGPHP';
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        return $this->getClassNamespace($this->getNamePackage()). '\\';
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
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = str_replace_first($this->rootNamespace(), $this->rootNamespace(). 'src'. '\\', $name);

        return $this->laravel->basePath(). '/packages/'. str_replace('\\', '/', $name).'.php';
    }

    /**
     * Get name in studly case.
     *
     * @return string
     */
    public function getStudlyName()
    {
        return class_basename($this->getNamePackage());
    }

}