<?php

use Illuminate\Support\Facades\File;
use Sahib\Form\FormServiceProvider;

class TestCase extends \Illuminate\Foundation\Testing\TestCase
{
    protected function setUp()
    {
        parent::setUp();

        // Unbind model before each test.
        app('sahib_form')->model(null);
    }

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../vendor/laravel/laravel/bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        $app->register(FormServiceProvider::class);

        return $app;
    }

    protected function assertBladeRender($render, $string, $data = [])
    {
        $path = __DIR__."/views/test.blade.php";

        File::put($path, $string);

        $this->assertEquals($render, view()->file($path, $data)->render());
    }

}
