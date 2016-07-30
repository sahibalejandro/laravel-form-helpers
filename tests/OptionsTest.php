<?php

use Sahib\Form\Form;
use Illuminate\Database\Eloquent\Model;

class OptionsTest extends TestCase
{
    /** @test */
    public function it_generates_options()
    {
        $viewData = ['options' => ['option_value' => 'Option Text']];

        $html = '<option value="option_value">Option Text</option>';
        $this->assertBladeRender($html, '@options($options, "select")', $viewData);

        $html = '<option value="option_value" selected>Option Text</option>';
        $this->assertBladeRender($html, '@options($options, "select", "option_value")', $viewData);
    }

    /** @test */
    public function it_generates_options_with_placeholder()
    {
        $viewData = ['options' => ['option_value' => 'Option Text']];

        $html = '<option value="" selected disabled>Placeholder</option>';
        $html .= '<option value="option_value">Option Text</option>';

        $this->assertBladeRender($html, '@options($options, "select", null, "Placeholder")', $viewData);
    }

    /** @test */
    public function it_generates_options_when_the_model_does_not_have_the_attribute()
    {
        $model = $this->prophesize(Model::class);
        $model->getAttribute('select')->willReturn(null);

        $viewData = [
            'model' => $model->reveal(),
            'options' => ['option_value' => 'Option Text'],
        ];

        $html = '<option value="option_value">Option Text</option>';
        $this->assertBladeRender($html, '@form($model) @options($options, "select")', $viewData);

        $html = '<option value="option_value" selected>Option Text</option>';
        $this->assertBladeRender($html, '@form($model) @options($options, "select", "option_value")', $viewData);
    }

    /** @test */
    public function it_generates_options_when_the_model_exists()
    {
        $model = $this->prophesize(Model::class);
        $model->getAttribute('select')->willReturn('option_value');

        $viewData = [
            'model' => $model->reveal(),
            'options' => ['option_value' => 'Option Text'],
        ];

        $html = '<option value="option_value" selected>Option Text</option>';
        $this->assertBladeRender($html, '@form($model) @options($options, "select")', $viewData);
        $this->assertBladeRender($html, '@form($model) @options($options, "select", "default_value")', $viewData);
    }

    /** @test */
    public function it_generates_options_when_old_input_and_the_model_exists()
    {
        $model = $this->prophesize(Model::class);
        $model->getAttribute('select')->willReturn('model_option_value');

        $viewData = [
            'model' => $model->reveal(),
            'options' => ['option_value' => 'Option Text'],
        ];

        $this->session(['_old_input' => ['select' => 'option_value']]);

        $html = '<option value="option_value" selected>Option Text</option>';
        $this->assertBladeRender($html, '@form($model) @options($options, "select")', $viewData);
        $this->assertBladeRender($html, '@form($model) @options($options, "select", "default_value")', $viewData);
    }

    /** @test */
    public function it_generates_options_when_old_input_exists()
    {
        $viewData = [
            'options' => ['option_value' => 'Option Text'],
        ];

        $this->session(['_old_input' => ['select' => 'option_value']]);

        $html = '<option value="option_value" selected>Option Text</option>';
        $this->assertBladeRender($html, '@options($options, "select")', $viewData);
        $this->assertBladeRender($html, '@options($options, "select", "default_value")', $viewData);
    }
}
