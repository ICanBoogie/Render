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
	public function test_resolve()
	{
		$tr = new TemplateResolver;
		$ds = DIRECTORY_SEPARATOR;

		$extensions = [ '.patron', '.php'];

		$tries = [];
		$this->assertFalse($tr->resolve('posts/index', $extensions, $tries));
		$this->assertEmpty($tries);

		$tr->add_path(__DIR__ . '/templates/default');
		$tries = [];
		$this->assertFalse($tr->resolve('posts/index', $extensions, $tries));
		$this->assertNotEmpty($tries);
		$this->assertEquals([

			__DIR__ . "{$ds}templates{$ds}default{$ds}posts{$ds}index.patron",
			__DIR__ . "{$ds}templates{$ds}default{$ds}posts{$ds}index.php"

		], $tries);

		$tr->add_path(__DIR__ . '/templates/custom');
		$tries = [];
		$this->assertFalse($tr->resolve('posts/index', $extensions, $tries));
		$this->assertNotEmpty($tries);
		$this->assertEquals([

			__DIR__ . "{$ds}templates{$ds}custom{$ds}posts{$ds}index.patron",
			__DIR__ . "{$ds}templates{$ds}custom{$ds}posts{$ds}index.php",
			__DIR__ . "{$ds}templates{$ds}default{$ds}posts{$ds}index.patron",
			__DIR__ . "{$ds}templates{$ds}default{$ds}posts{$ds}index.php"

		], $tries);

		$tr->add_path(__DIR__ . '/templates/all');
		$tries = [];
		$this->assertEquals(__DIR__ . "{$ds}templates{$ds}all{$ds}posts{$ds}index.php", $tr->resolve('posts/index', $extensions, $tries));
		$this->assertNotEmpty($tries);
		$this->assertEquals([

			__DIR__ . "{$ds}templates{$ds}all{$ds}posts{$ds}index.patron",
			__DIR__ . "{$ds}templates{$ds}all{$ds}posts{$ds}index.php",

		], $tries);
	}
}
