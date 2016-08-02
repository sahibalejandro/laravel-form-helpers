<?php

namespace Sahib\Form;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Get configuration file path.
     *
     * @return string
     */
    protected function configFile()
    {
        return __DIR__.'/config/form-helpers.php';
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            $this->configFile() => config_path('form-helpers.php'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfig();
        $this->registerBindings();
        $this->registerBladeDirectives();
    }

    /**
     * Merge package configuration file with the application's copy.
     */
    protected function mergeConfig()
    {
        $this->mergeConfigFrom($this->configFile(), 'form-helpers');
    }

    /**
     * Register bindings.
     */
    protected function registerBindings()
    {
        $this->app->singleton('sahib_form', function () {
            return $this->app->make(Form::class);
        });
    }

    /**
     * Register blade directives.
     */
    protected function registerBladeDirectives()
    {
        Blade::directive('form', function ($expression) {
            $expression = $expression ?: '()';
            return "<?php app('sahib_form')->model{$expression}; ?>";
        });

        Blade::directive('input', function ($expression) {
            return "<?php echo app('sahib_form')->input{$expression}; ?>";
        });

        Blade::directive('text', function ($expression) {
            return "<?php echo app('sahib_form')->text{$expression}; ?>";
        });

        Blade::directive('checkbox', function ($expression) {
            return "<?php echo app('sahib_form')->checkbox{$expression}; ?>";
        });

        Blade::directive('radio', function ($expression) {
            return "<?php echo app('sahib_form')->radio{$expression}; ?>";
        });

        Blade::directive('options', function ($expression) {
            return "<?php echo app('sahib_form')->options{$expression}; ?>";
        });

        Blade::directive('error', function ($expression) {
            return "<?php echo app('sahib_form')->error{$expression}; ?>";
        });
    }
}
