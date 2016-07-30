<?php

use Illuminate\Database\Eloquent\Model;

class TextTest extends TestCase
{
    /** @test */
    public function it_generates_valid_attributes()
    {
        $this->assertBladeRender('', "@text('description')");
        $this->assertBladeRender('default', "@text('description', 'default')");
    }

    /** @test */
    public function it_generates_valid_attributes_when_the_model_does_not_have_the_attribute()
    {
        $model = $this->prophesize(Model::class);
        $model->getAttribute('description')->willReturn(null);

        $viewData = ['model' => $model->reveal()];

        $this->assertBladeRender('', '@form($model) @text("description")', $viewData);
        $this->assertBladeRender('default', '@form($model) @text("description", "default")', $viewData);
    }

    /** @test */
    public function it_generates_valid_attributes_when_old_input_exists()
    {
        $this->session(['_old_input' => ['description' => 'Description']]);

        $this->assertBladeRender('Description', '@text("description")');
    }

    /** @test */
    public function it_generates_valid_attributes_when_old_input_and_model_exists()
    {
        $this->session(['_old_input' => ['description' => 'Description from old input']]);

        $model = $this->prophesize(Model::class);
        $model->getAttribute('description')->willReturn('Description from model');

        $viewData = ['model' => $model->reveal()];

        $this->assertBladeRender('Description from old input', '@form($model) @text("description")', $viewData);
    }

    /** @test */
    public function it_generates_valid_attributes_when_model_exists()
    {
        $model = $this->prophesize(Model::class);
        $model->getAttribute('description')->willReturn('Description');

        $viewData = ['model' => $model->reveal()];

        $this->assertBladeRender('Description', '@form($model) @text("description")', $viewData);
    }
}
