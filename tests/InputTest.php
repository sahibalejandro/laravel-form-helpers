<?php

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
        $this->assertBladeRender('name="name" value=""', "@input('name')");
        $this->assertBladeRender('name="name" value="default"', "@input('name', 'default')");
    }

    /** @test */
    public function it_generates_valid_attributes_when_the_model_does_not_have_the_attribute()
    {
        $model = $this->prophesize(Model::class);
        $model->getAttribute('name')->willReturn(null);

        $viewData = ['model' => $model->reveal()];

        $this->assertBladeRender('name="name" value=""', '@form($model) @input("name")', $viewData);
        $this->assertBladeRender('name="name" value="default"', '@form($model) @input("name", "default")', $viewData);
    }

    /** @test */
    public function it_generates_valid_attributes_when_old_input_exists()
    {
        $this->session(['_old_input' => ['name' => 'Old John Doe']]);

        $this->assertBladeRender('name="name" value="Old John Doe"', "@input('name')");
    }

    /** @test */
    public function it_generates_valid_attributes_when_old_input_and_model_exists()
    {
        $this->session(['_old_input' => ['name' => 'Old John Doe']]);

        $model = $this->prophesize(Model::class);
        $model->getAttribute('name')->willReturn('John Doe');

        $viewData = ['model' => $model->reveal()];

        $this->assertBladeRender('name="name" value="Old John Doe"', '@form($model) @input("name")', $viewData);
    }

    /** @test */
    public function it_generates_valid_attributes_when_model_exists()
    {
        $model = $this->prophesize(Model::class);
        $model->getAttribute('name')->willReturn('John Doe');

        $viewData = ['model' => $model->reveal()];

        $this->assertBladeRender('name="name" value="John Doe"', '@form($model) @input("name")', $viewData);
    }
}
