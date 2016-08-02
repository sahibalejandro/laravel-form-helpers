<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class ConfigTest extends TestCase
{
    public function test_config_file_is_published()
    {
        $configFile = __DIR__.'/../vendor/laravel/laravel/config/form-helpers.php';

        File::delete($configFile);

        $this->assertFileNotExists($configFile);

        Artisan::call('vendor:publish', [
            '--provider' => 'Sahib\Form\FormServiceProvider',
        ]);

        $this->assertFileExists($configFile);
    }
}
