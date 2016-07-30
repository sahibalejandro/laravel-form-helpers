<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Sahib\Form\FormServiceProvider;

class TestCase extends \Illuminate\Foundation\Testing\TestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        // Unbind model before each test.
        app('sahib_form')->model(null);

        // Remove errors before each test.
        $this->session(['errors' => null]);
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

    /**
     * Assert that a blade string is rendered correctly.
     *
     * @param  string $render
     * @param  string $string
     * @param  array $data
     * @return $this
     */
    protected function assertBladeRender($render, $string, $data = [])
    {
        $path = __DIR__."/views/test.blade.php";

        File::put($path, $string);

        $this->assertEquals($render, view()->file($path, $data)->render());

        return $this;
    }

    /**
     * Push an error into the session.
     *
     * @param  string $field
     * @param  string $message
     * @return $this
     */
    protected function withError($field, $message)
    {
        $errors = new ViewErrorBag();

        $errors->put('default', new MessageBag([$field => [$message]]));

        $this->session(['errors' => $errors]);

        return $this;
    }

}
