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

class helpersTest extends \PHPUnit_Framework_TestCase
{
	public function test_get_engines()
	{
		$instance = get_engines();
		$this->assertSame($instance, get_engines());
	}

	public function test_get_template_resolver()
	{
		$instance = get_template_resolver();
		$this->assertSame($instance, get_template_resolver());
	}

	public function test_get_renderer()
	{
		$instance = get_renderer();
		$this->assertSame($instance, get_renderer());
	}
}