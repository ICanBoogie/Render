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

class EngineCollectionTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var EngineCollection
	 */
	static private $instance;

	static public function setupBeforeClass()
	{
		self::$instance = new EngineCollection([

			'.php' => 'ICanBoogie\Render\PHPEngine',
			'.phtml' => 'ICanBoogie\Render\EngineCollectionTest\PHTMLEngine'

		]);
	}

	public function test_get_extensions()
	{
		$this->assertEquals([ '.php', '.phtml' ], self::$instance->extensions);
	}

	public function test_offsetGet()
	{
		$this->assertInstanceOf('ICanBoogie\Render\PHPEngine', self::$instance['.php']);
	}

	/**
	 * @expectedException \ICanBoogie\Render\EngineNotDefined
	 */
	public function test_offsetGet_with_undefined()
	{
		self::$instance['.undefined'];
	}

	public function test_offsetSet()
	{
		$instance = new EngineCollection;
		$instance['.php'] = 'ICanBoogie\Render\PHPEngine';
		$instance['.phtml'] = new PHPEngine;

		$this->assertInstanceOf('ICanBoogie\Render\PHPEngine', $instance['.php']);
		$this->assertInstanceOf('ICanBoogie\Render\PHPEngine', $instance['.phtml']);
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

			'.php' => 'ICanBoogie\Render\PHPEngine'

		]);

		foreach ($instance as $extension => $engine)
		{
			$this->assertEquals('.php', $extension);
			$this->assertEquals('ICanBoogie\Render\PHPEngine', $engine);
		}
	}

	public function test_resolve_engine()
	{
		$this->assertInstanceOf('ICanBoogie\Render\PHPEngine', self::$instance->resolve_engine('testing.php'));
		$this->assertInstanceOf('ICanBoogie\Render\EngineCollectionTest\PHTMLEngine', self::$instance->resolve_engine('testing.phtml'));
		$this->assertFalse(self::$instance->resolve_engine('testing.madonna'));
	}

	/**
	 * @expectedException \ICanBoogie\Render\EngineNotAvailable
	 */
	public function test_render_engine_not_available()
	{
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
			->getMockBuilder('ICanBoogie\Render\Engine')
			->getMock();
		$engine_stub
			->expects($this->once())
			->method('render')
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
