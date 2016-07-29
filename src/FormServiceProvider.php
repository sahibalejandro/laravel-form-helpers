<?php

namespace Sahib\Form;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->registerBladeDirectives();
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
