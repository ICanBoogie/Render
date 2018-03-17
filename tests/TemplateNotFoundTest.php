<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Render;

class TemplateNotFoundTest extends \PHPUnit\Framework\TestCase
{
    public function test_get_tried()
    {
        $tried = [ "one", "two", "three" ];
        $exception = new TemplateNotFound("Not found.", $tried);
        $this->assertEquals($tried, $exception->tried);
    }

    public function test_empty_tried()
    {
	    $exception = new TemplateNotFound("Not found.", []);
	    $this->assertContains("no possible files", $exception->getMessage());
	    $this->assertEmpty($exception->tried);
    }
}
