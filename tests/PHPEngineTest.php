<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Test\ICanBoogie\Render;

use Exception;
use ICanBoogie\Render\PHPEngine;
use PHPUnit\Framework\TestCase;
use Throwable;

class PHPEngineTest extends TestCase
{
	private const ROOT = __DIR__ . '/templates/custom/';

	protected function setUp(): void
	{
		parent::setUp();

		$this->stu = new PHPEngine();
	}

	/**
	 * @throws Throwable
	 */
	public function test_render(): void
	{
		$pathname = self::ROOT . 'var_template_pathname.php';
		$rc = $this->render($pathname, new class (){}, []);

		$this->assertEquals($pathname, $rc);
	}

	/**
	 * @throws Throwable
	 */
	public function test_bind_array(): void
	{
		$rc = $this->render(self::ROOT . 'bind_array.php', [ 1, 2, 3 ], []);

		$this->assertEquals('ArrayObject:[1, 2, 3]', $rc);
	}

	/**
	 * @throws Throwable
	 */
	public function test_bind_object(): void
	{
		$rc = $this->render(self::ROOT . 'bind_object.php', $this, []);

		$this->assertEquals(__CLASS__, $rc);
	}

	/**
	 * @throws Throwable
	 */
	public function test_bind_string(): void
	{
		$string = "string" . uniqid();
		$rc = $this->render(self::ROOT . 'bind_string.php', $string, []);

		$this->assertEquals($string, $rc);
	}

	public function test_should_discard_output_on_exception(): void
	{
		$exception = new Exception;
		$level = ob_get_level();

		try
		{
			$this->render(self::ROOT . 'with_exception.php', $exception, [ ]);

			$this->fail("Expected exception");
		}
		catch (Throwable $e)
		{
			$this->assertEquals($level, ob_get_level());
			$this->assertSame($exception, $e);
		}
	}

	/**
	 * @param string $template_pathname Pathname to the template to render.
	 * @param mixed $content _thisArg_, if supported by the engine.
	 * @param array<string, mixed> $variables Variable to render the template with.
	 *
	 * @throws Throwable
	 */
	private function render(string $template_pathname, mixed $content, array $variables): string
	{
		return $this->stu->render($template_pathname, $content, $variables);
	}
}
