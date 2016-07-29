<?php

use Sahib\Form\Form;
use Illuminate\Database\Eloquent\Model;

class OptionsTest extends TestCase
{
    /*
     * Combinations:
     *
     * -old and -model            = null/default
     * -old and +model/-attribute = null/default
     * +old and +model/+attribute = old
     * -old and +model/+attribute = model's attribute
     */

    /** @test */
    public function it_generates_options()
    {
        $options = ['key' => 'value'];
        $html = '<option value="key">value</option>';

        $form = app(Form::class);
        $this->assertEquals($html, $form->options($options, 'select'));

        $html = '<option value="key" selected>value</option>';
        $this->assertEquals($html, $form->options($options, 'select', 'key'));
    }

    /** @test */
    public function it_generates_options_with_placeholder()
    {
        $options = ['key' => 'value'];
        $html = '<option value="" selected disabled>placeholder</option>';
        $html .= '<option value="key">value</option>';

        $form = app(Form::class);
        $this->assertEquals($html, $form->options($options, 'select', null, 'placeholder'));
    }

    /** @test */
    public function it_generates_options_when_the_model_does_not_have_the_attribute()
    {
        $options = ['key' => 'value'];
        $html = '<option value="key">value</option>';

        $model = $this->prophesize(Model::class);
        $model->getAttribute('select')->willReturn(null);

        $form = app(Form::class);
        $form->model($model->reveal());
        $this->assertEquals($html, $form->options($options, 'select'));

        $html = '<option value="key" selected>value</option>';
        $this->assertEquals($html, $form->options($options, 'select', 'key'));
    }

    /** @test */
    public function it_generates_options_when_the_model_exists()
    {
        $options = ['key' => 'value'];
        $html = '<option value="key" selected>value</option>';

        $model = $this->prophesize(Model::class);
        $model->getAttribute('select')->willReturn('key');

        $form = app(Form::class);
        $form->model($model->reveal());
        $this->assertEquals($html, $form->options($options, 'select'));
        $this->assertEquals($html, $form->options($options, 'select', 'default'));
    }

    /** @test */
    public function it_generates_options_when_old_input_and_the_model_exists()
    {
        $options = ['key' => 'value'];
        $html = '<option value="key" selected>value</option>';

        $model = $this->prophesize(Model::class);
        $model->getAttribute('select')->willReturn('model_key');

        $this->session(['_old_input' => ['select' => 'key']]);

        $form = app(Form::class);
        $form->model($model->reveal());
        $this->assertEquals($html, $form->options($options, 'select'));
        $this->assertEquals($html, $form->options($options, 'select', 'default'));
    }

    /** @test */
    public function it_generates_options_when_old_input_exists()
    {
        $options = ['key' => 'value'];
        $html = '<option value="key" selected>value</option>';

        $this->session(['_old_input' => ['select' => 'key']]);

        $form = app(Form::class);
        $this->assertEquals($html, $form->options($options, 'select'));
        $this->assertEquals($html, $form->options($options, 'select', 'default'));
    }
}
