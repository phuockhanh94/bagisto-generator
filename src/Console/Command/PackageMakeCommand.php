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
    protected $signature = 'package:make {package} {--force} {--plain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new package class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'package';

    /**
     * Contains subs files information
     *
     * @var string
     */
    protected $stubFiles = [
        'package'  => [
            'views/index'                     => 'Resources/views/index.blade.php',
            'scaffold/menu'                   => 'Config/menu.php',
            'scaffold/acl'                    => 'Config/acl.php',
            'assets/js/app'                   => 'Resources/assets/js/app.js',
            'assets/sass/default'             => 'Resources/assets/sass/default.scss',
            'assets/sass/velocity'            => 'Resources/assets/sass/velocity.scss',
            'assets/publishable/css/default'  => '../publishable/assets/css/default.css',
            'assets/publishable/css/velocity' => '../publishable/assets/css/velocity.css',
            'assets/publishable/js/app'       => '../publishable/assets/js/app.js',
            'webpack'                         => '../webpack.mix.js',
            'package'                         => '../package.json',
        ]
    ];

    /**
     * Contains package file paths for creation
     *
     * @var array
     */
    protected $paths = [
        'package'  => [
            'config'     => 'Config',
            'command'    => 'Console/Commands',
            'migration'  => 'Database/Migrations',
            'seeder'     => 'Database/Seeders',
            'contracts'  => 'Contracts',
            'model'      => 'Models',
            'routes'     => 'Http',
            'controller' => 'Http/Controllers',
            'filter'     => 'Http/Middleware',
            'request'    => 'Http/Requests',
            'provider'   => 'Providers',
            'repository' => 'Repositories',
            'event'      => 'Events',
            'listener'   => 'Listeners',
            'emails'     => 'Mail',
            'assets'     => 'Resources/assets',
            'lang'       => 'Resources/lang',
            'views'      => 'Resources/views',
            'images'     => 'Resources/assets/images'
        ],
    ];

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

        $this->createFolders();

        if (! $this->option('plain')) {
            $this->createFiles();
            $this->createClasses();
        }

        $this->info("Package '{$namepackage}' created successfully.");
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

    /**
     * Generate package folders
     *
     * @return void
     */
    public function createFolders()
    {
        foreach ($this->paths[$this->type] as $key => $folder) {
            $path = base_path('packages/'. $this->getNamePackage(). '/src'). '/'. $folder;
            $this->files->makeDirectory($path, 0755, true);
        }
    }

    /**
     * Generate package classes
     *
     * @return void
     */
    public function createClasses()
    {
        $namepackage = $this->getNamePackage();
        $name = $this->getStudlyName();

        $this->call('package:make-provider', [
            'name'    => "{$name}ServiceProvider",
            'package' => $namepackage,
        ]);
        $this->call('package:make-controller', [
            'name'    => "{$name}Controller",
            'package' => $namepackage,
            '--route' => true
        ]);
    }

    /**
     * Generate package files
     *
     * @return void
     */
    public function createFiles()
    {
        foreach ($this->stubFiles[$this->type] as $stub => $file) {
            $path = base_path('packages/' .$this->getNamePackage(). '/src') . '/' . $file;

            if (! $this->files->isDirectory($dir = dirname($path))) {
                $this->files->makeDirectory($dir, 0775, true);
            }

            $this->files->put($path, $this->buildClass($stub));
        }
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($stub)
    {
        $path = __DIR__ . '/../stubs/' . $stub . '.stub';
        $stub = $this->files->get($path);

        return $stub;
    }
}
