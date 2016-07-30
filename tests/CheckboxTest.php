<?php

use Illuminate\Database\Eloquent\Model;

class CheckboxTest extends TestCase
{
    /** @test */
    public function it_generates_valid_attributes()
    {
        $this->assertBladeRender('name="accept" value="1"', "@checkbox('accept')");
        $this->assertBladeRender('name="accept" value="ok"', "@checkbox('accept', 'ok')");
        $this->assertBladeRender('name="accept" value="1" checked', "@checkbox('accept', 1, true)");
    }

    /** @test */
    public function it_generates_valid_attributes_when_the_model_does_not_have_the_attribute()
    {
        $model = $this->prophesize(Model::class);
        $model->getAttribute('accept')->willReturn(null);

        $viewData = ['model' => $model->reveal()];

        $this->assertBladeRender('name="accept" value="1"', '@form($model) @checkbox("accept")', $viewData);
        $this->assertBladeRender('name="accept" value="ok"', '@form($model) @checkbox("accept", "ok")', $viewData);
    }

    /** @test */
    public function it_generates_valid_attributes_when_old_input_exists()
    {
        $this->session(['_old_input' => ['accept' => '1', 'accept2' => 'not_ok']]);

        $this->assertBladeRender('name="accept" value="1" checked', "@checkbox('accept')");
        $this->assertBladeRender('name="accept2" value="ok"', "@checkbox('accept2', 'ok')");
    }

    /** @test */
    public function it_generates_valid_attributes_when_old_input_and_model_exists()
    {
        $model = $this->prophesize(Model::class);
        $model->getAttribute('accept')->willReturn(null);

        $this->session(['_old_input' => ['accept' => '1']]);

        $viewData = ['model' => $model->reveal()];

        $this->assertBladeRender('name="accept" value="1" checked', '@form($model) @checkbox("accept")', $viewData);
    }

    /** @test */
    public function it_generates_valid_attributes_when_model_exists()
    {
        $model = $this->prophesize(Model::class);
        $model->getAttribute('accept')->willReturn(1);
        $model->getAttribute('accept2')->willReturn(null);

        $viewData = ['model' => $model->reveal()];

        $this->assertBladeRender('name="accept" value="1" checked', '@form($model) @checkbox("accept")', $viewData);
        $this->assertBladeRender('name="accept2" value="1"', '@form($model) @checkbox("accept2")', $viewData);
    }
}
