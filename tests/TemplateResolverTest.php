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

class TemplateResolverTest extends \PHPUnit_Framework_TestCase
{
	static private $templates_root;

	static public function setupBeforeClass()
	{
		self::$templates_root = __DIR__ . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR;
	}

	public function test_resolve()
	{
		$tr = new BasicTemplateResolver;
		$ds = DIRECTORY_SEPARATOR;

		$extensions = [ '.patron', '.php'];

		$tried = [];
		$this->assertNull($tr->resolve('posts/index', $extensions, $tried));
		$this->assertEmpty($tried);

		$tr->add_path(__DIR__ . '/templates/default');
		$tried = [];
		$this->assertNull($tr->resolve('posts/index', $extensions, $tried));
		$this->assertNotEmpty($tried);
		$this->assertEquals([

			self::$templates_root . "default{$ds}posts{$ds}index.patron",
			self::$templates_root . "default{$ds}posts{$ds}index.php"

		], $tried);

		$tr->add_path(__DIR__ . '/templates/custom');
		$tried = [];
		$this->assertNull($tr->resolve('posts/index', $extensions, $tried));
		$this->assertNotEmpty($tried);
		$this->assertEquals([

			self::$templates_root . "custom{$ds}posts{$ds}index.patron",
			self::$templates_root . "custom{$ds}posts{$ds}index.php",
			self::$templates_root . "default{$ds}posts{$ds}index.patron",
			self::$templates_root . "default{$ds}posts{$ds}index.php"

		], $tried);

		$tr->add_path(__DIR__ . '/templates/all');
		$tried = [];
		$this->assertEquals(self::$templates_root . "all{$ds}posts{$ds}index.php", $tr->resolve('posts/index', $extensions, $tried));
		$this->assertNotEmpty($tried);
		$this->assertEquals([

			self::$templates_root . "all{$ds}posts{$ds}index.patron",
			self::$templates_root . "all{$ds}posts{$ds}index.php",

		], $tried);
	}

	public function test_resolve_with_extension()
	{
		$tr = new BasicTemplateResolver;
		$tr->add_path(self::$templates_root . 'all');
		$pathname = $tr->resolve('with-extension.html', [ '.patron' ]);
		$this->assertNull($pathname);
		$pathname = $tr->resolve('with-extension.html', [ '.html', '.patron' ]);
		$this->assertStringEndsWith('with-extension.html', $pathname);
	}

	public function test_resolve_with_double_extension()
	{
		$tr = new BasicTemplateResolver;
		$tr->add_path(self::$templates_root . 'all');
		$pathname = $tr->resolve('with-double-extension.html', [ '.patron' ]);
		$this->assertStringEndsWith('with-double-extension.html.patron', $pathname);
		$pathname = $tr->resolve('with-double-extension.html', [ '.html', '.patron' ]);
		$this->assertNull($pathname);
	}
}
