<?php

use Sahib\Form\Form;
use Illuminate\Database\Eloquent\Model;

class CheckboxTest extends TestCase
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

        $this->assertEquals('name="accept" value="1"', $form->checkbox('accept'));
        $this->assertEquals('name="accept" value="ok"', $form->checkbox('accept', 'ok'));
    }

    /** @test */
    public function it_generates_valid_attributes_when_the_model_does_not_have_the_attribute()
    {
        $model = $this->prophesize(Model::class);
        $model->getAttribute('accept')->willReturn(null);

        $form = app(Form::class);
        $form->model($model->reveal());

        $this->assertEquals('name="accept" value="1"', $form->checkbox('accept'));
        $this->assertEquals('name="accept" value="ok"', $form->checkbox('accept', 'ok'));
    }

    /** @test */
    public function it_generates_valid_attributes_when_old_input_exists()
    {
        $this->session(['_old_input' => ['accept' => '1', 'accept2' => 'not_ok']]);

        $form = app(Form::class);

        $this->assertEquals('name="accept" value="1" checked', $form->checkbox('accept'));
        $this->assertEquals('name="accept2" value="ok"', $form->checkbox('accept2', 'ok'));
    }

    /** @test */
    public function it_generates_valid_attributes_when_old_input_and_model_exists()
    {
        $this->session(['_old_input' => ['accept' => '1']]);

        $form = app(Form::class);

        $model = $this->prophesize(Model::class);
        $model->getAttribute('accept')->willReturn(null);

        $form->model($model->reveal());

        $this->assertEquals('name="accept" value="1" checked', $form->checkbox('accept'));
    }

    /** @test */
    public function it_generates_valid_attributes_when_model_exists()
    {
        $form = app(Form::class);

        $model = $this->prophesize(Model::class);
        $model->getAttribute('accept')->willReturn(1);
        $model->getAttribute('accept2')->willReturn(null);

        $form->model($model->reveal());

        $this->assertEquals('name="accept" value="1" checked', $form->checkbox('accept'));
        $this->assertEquals('name="accept2" value="1"', $form->checkbox('accept2'));
    }
}
