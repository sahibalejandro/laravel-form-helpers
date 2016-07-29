<?php

use Sahib\Form\Form;
use Illuminate\Database\Eloquent\Model;

class InputTest extends TestCase
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
    public function it_generates_valid_attributes()
    {
        $form = app(Form::class);

        $this->assertEquals('name="name" value=""', $form->input('name'));
        $this->assertEquals('name="name" value="default"', $form->input('name', 'default'));
    }

    /** @test */
    public function it_generates_valid_attributes_when_the_model_does_not_have_the_attribute()
    {
        $model = $this->prophesize(Model::class);
        $model->getAttribute('name')->willReturn(null);

        $form = app(Form::class);
        $form->model($model->reveal());

        $this->assertEquals('name="name" value=""', $form->input('name'));
        $this->assertEquals('name="name" value="default"', $form->input('name', 'default'));
    }

    /** @test */
    public function it_generates_valid_attributes_when_old_input_exists()
    {
        $this->session(['_old_input' => ['name' => 'Old John Doe']]);

        $form = app(Form::class);

        $this->assertEquals('name="name" value="Old John Doe"', $form->input('name'));
    }

    /** @test */
    public function it_generates_valid_attributes_when_old_input_and_model_exists()
    {
        $this->session(['_old_input' => ['name' => 'Old John Doe']]);

        $form = app(Form::class);

        $model = $this->prophesize(Model::class);
        $model->getAttribute('name')->willReturn('John Doe');
        $form->model($model->reveal());

        $this->assertEquals('name="name" value="Old John Doe"', $form->input('name'));
    }

    /** @test */
    public function it_generates_valid_attributes_when_model_exists()
    {
        $form = app(Form::class);

        $model = $this->prophesize(Model::class);
        $model->getAttribute('name')->willReturn('John Doe');
        $form->model($model->reveal());

        $this->assertEquals('name="name" value="John Doe"', $form->input('name'));
    }
}
