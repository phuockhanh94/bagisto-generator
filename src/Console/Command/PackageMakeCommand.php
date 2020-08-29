<?php

namespace GGPHP\Generator\Console\Command;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class PackageMakeCommand extends MakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:make {package} {--force}';

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
        $namepackage = $this->getNamePackage();
        if ($this->hasPackage($namepackage)) {
            if ($this->option('force')) {
                $this->deletePackage($namepackage);
            } else {
                $this->error("Package '{$namepackage}' already exist !");

                return;
            }
        }
        $nameProvider = $this->getStudlyName();

        $this->call('package:make-provider', [
            'name'    => "{$nameProvider}ServiceProvider",
            'package' => $namepackage,
        ]);
    }

    /**
     * Checks if package exist or not
     *
     * @param  strign  $package
     * @return boolean
     */
    private function hasPackage($package)
    {
        return $this->files->isDirectory($this->laravel->basePath('packages/'. $package));
    }

    /**
     * Deletes specific package
     *
     * @param  strign  $package
     * @return void
     */
    private function deletePackage($package)
    {
        $this->files->deleteDirectory($this->laravel->basePath('packages/'. $package));
    }
}
