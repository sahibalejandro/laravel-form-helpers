<?php

use Sahib\Form\Form;
use Illuminate\Database\Eloquent\Model;

class TextTest extends TestCase
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

        $this->assertEquals('', $form->text('description'));
        $this->assertEquals('default', $form->text('description', 'default'));
    }

    /** @test */
    public function it_generates_valid_attributes_when_the_model_does_not_have_the_attribute()
    {
        $model = $this->prophesize(Model::class);
        $model->getAttribute('description')->willReturn(null);

        $form = app(Form::class);
        $form->model($model->reveal());

        $this->assertEquals('', $form->text('description'));
        $this->assertEquals('default', $form->text('description', 'default'));
    }

    /** @test */
    public function it_generates_valid_attributes_when_old_input_exists()
    {
        $this->session(['_old_input' => ['description' => 'Product description']]);

        $form = app(Form::class);

        $this->assertEquals('Product description', $form->text('description'));
    }

    /** @test */
    public function it_generates_valid_attributes_when_old_input_and_model_exists()
    {
        $this->session(['_old_input' => ['description' => 'Description from old input']]);

        $form = app(Form::class);

        $model = $this->prophesize(Model::class);
        $model->getAttribute('description')->willReturn('Description from model');
        $form->model($model->reveal());

        $this->assertEquals('Description from old input', $form->text('description'));
    }

    /** @test */
    public function it_generates_valid_attributes_when_model_exists()
    {
        $form = app(Form::class);

        $model = $this->prophesize(Model::class);
        $model->getAttribute('description')->willReturn('Description');
        $form->model($model->reveal());

        $this->assertEquals('Description', $form->text('description'));
    }
}
