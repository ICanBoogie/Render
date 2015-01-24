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

class TemplateNotFoundTest extends \PHPUnit_Framework_TestCase
{
    public function test_get_tries()
    {
        $tries = [ "one", "two", "three" ];
        $exception = new TemplateNotFound("Not found.", $tries);
        $this->assertEquals($tries, $exception->tries);
    }
}
