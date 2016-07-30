<?php

class ErrorTest extends TestCase
{
    public function test_do_not_display_error_when_there_is_no_errors()
    {
        $this->assertBladeRender('', '@error("field")');
    }

    public function test_display_error()
    {
        $this->withError('field', 'Error Message');
        $this->assertBladeRender('<div class="help-block">Error Message</div>', '@error("field")');
    }

    public function test_display_error_with_custom_template()
    {
        $this->withError('field_name', 'Error Message');
        $this->assertBladeRender('has-error', "@error('field_name', 'has-error')");
        $this->assertBladeRender('<span>Error Message</span>', "@error('field_name', '<span>:message</span>')");
    }

    public function test_escape_error()
    {
        $this->withError('field_name', '<html>');
        $this->assertBladeRender('<div class="help-block">&lt;html&gt;</div>', '@error("field_name")');
    }
}
