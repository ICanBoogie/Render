<?php

namespace Test\ICanBoogie\Render;

use ICanBoogie\Render\TemplateNotFound;
use PHPUnit\Framework\TestCase;

class TemplateNotFoundTest extends TestCase
{
    public function test_get_tried(): void
    {
        $tried = [ "one", "two", "three" ];
        $exception = new TemplateNotFound("Not found.", $tried);
        $this->assertEquals($tried, $exception->tried);
    }

    public function test_empty_tried(): void
    {
        $exception = new TemplateNotFound("Not found.", []);
        $this->assertStringContainsString("no possible files", $exception->getMessage());
        $this->assertEmpty($exception->tried);
    }
}
