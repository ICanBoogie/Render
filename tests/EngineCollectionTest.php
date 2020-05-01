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

use ICanBoogie\Render\EngineCollectionTest\PHTMLEngine;
use PHPUnit\Framework\TestCase;

class EngineCollectionTest extends TestCase
{
	/**
	 * @var EngineCollection
	 */
	static private $instance;

	static public function setupBeforeClass(): void
	{
		self::$instance = new EngineCollection([

			'.php' => PHPEngine::class,
			'.phtml' => PHTMLEngine::class

		]);
	}

	public function test_get_extensions()
	{
		$this->assertEquals([ '.php', '.phtml' ], self::$instance->extensions);
	}

	public function test_offsetGet()
	{
		$this->assertInstanceOf(PHPEngine::class, self::$instance['.php']);
	}

	public function test_offsetGet_with_undefined()
	{
		$this->expectException(EngineNotDefined::class);

		self::$instance['.undefined'];
	}

	public function test_offsetSet()
	{
		$instance = new EngineCollection;
		$instance['.php'] = PHPEngine::class;
		$instance['.phtml'] = new PHPEngine;

		$this->assertInstanceOf(PHPEngine::class, $instance['.php']);
		$this->assertInstanceOf(PHPEngine::class, $instance['.phtml']);
	}

	public function test_offsetExists()
	{
		$this->assertTrue(isset(self::$instance['.php']));
		$this->assertFalse(isset(self::$instance['.undefined']));
	}

	public function test_offsetUnset()
	{
		$instance = clone self::$instance;
		$this->assertTrue(isset($instance['.php']));
		unset($instance['.php']);
		$this->assertFalse(isset($instance['.php']));
	}

	public function test_getIterator()
	{
		$instance = new EngineCollection([

			'.php' => PHPEngine::class

		]);

		foreach ($instance as $extension => $engine)
		{
			$this->assertEquals('.php', $extension);
			$this->assertEquals(PHPEngine::class, $engine);
		}
	}

	public function test_resolve_engine()
	{
		$this->assertInstanceOf(PHPEngine::class, self::$instance->resolve_engine('testing.php'));
		$this->assertInstanceOf(PHTMLEngine::class, self::$instance->resolve_engine('testing.phtml'));
		$this->assertFalse(self::$instance->resolve_engine('testing.madonna'));
		$this->assertFalse(self::$instance->resolve_engine('no-extension'));
	}

	public function test_render_engine_not_available()
	{
		$this->expectException(EngineNotAvailable::class);
		self::$instance->render("template.twig", null, []);
	}

	public function test_render()
	{
		$template = 'testing.php';
		$thisArg = [ 1, 2, 3 ];
		$variables = [ "one", "two" ];
		$options = [ "opt1" => 1 ];
		$expected = 'RENDERED';

		$engine_stub = $this
			->getMockBuilder(Engine::class)
			->getMock();
		$engine_stub
			->expects($this->once())
			->method('__invoke')
			->with($template, $thisArg, $variables, $options)
			->willReturn($expected);

		$instance = new EngineCollection([

			'.php' => $engine_stub

		]);

		$this->assertEquals($expected, $instance->render($template, $thisArg, $variables, $options));
	}
}

namespace ICanBoogie\Render\EngineCollectionTest;

use ICanBoogie\Render\PHPEngine;

class PHTMLEngine extends PHPEngine
{

}
