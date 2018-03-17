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

class PHPEngineTest extends \PHPUnit\Framework\TestCase
{
	static private $root;

	static public function setupBeforeClass()
	{
		self::$root = __DIR__ . '/templates/custom/';
	}

	public function test_render()
	{
		$engine = new PHPEngine;
		$pathname = self::$root . 'var_template_pathname.php';
		$rc = $engine($pathname, null, []);

		$this->assertEquals($pathname, $rc);
	}

	public function test_bind_array()
	{
		$engine = new PHPEngine;
		$rc = $engine(self::$root . 'bind_array.php', [ 1, 2, 3 ], []);

		$this->assertEquals('ArrayObject:[1, 2, 3]', $rc);
	}

	public function test_bind_object()
	{
		$engine = new PHPEngine;
		$rc = $engine(self::$root . 'bind_object.php', $this, []);

		$this->assertEquals(__CLASS__, $rc);
	}

	public function test_bind_string()
	{
		$engine = new PHPEngine;
		$string = "string" . uniqid();
		$rc = $engine(self::$root . 'bind_string.php', $string, []);

		$this->assertEquals($string, $rc);
	}

	public function test_should_discard_output_on_exception()
	{
		$exception = new \Exception;
		$level = ob_get_level();
		$engine = new PHPEngine;

		try
		{
			$engine(self::$root . 'with_exception.php', $exception, [ ]);

			$this->fail("Expected exception");
		}
		catch (\Exception $e)
		{
			$this->assertEquals($level, ob_get_level());
			$this->assertSame($exception, $e);
		}
	}
}
