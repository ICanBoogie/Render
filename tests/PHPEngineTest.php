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

class PHPEngineTest extends \PHPUnit_Framework_TestCase
{
	public function test_render()
	{
		$engine = new PHPEngine;
		$pathname = __DIR__ . '/templates/custom/var_template_pathname.php';
		$rc = $engine->render($pathname, null, []);

		$this->assertEquals($pathname, $rc);
	}
}
