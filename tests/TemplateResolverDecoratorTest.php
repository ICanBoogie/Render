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

use ICanBoogie\Render\TemplateResolverDecoratorTest\A;
use ICanBoogie\Render\TemplateResolverDecoratorTest\B;
use ICanBoogie\Render\TemplateResolverDecoratorTest\C;

class TemplateResolverDecoratorTest extends \PHPUnit\Framework\TestCase
{
	public function test_find_decorated()
	{
		$c = new C;
		$b = new B($c);
		$a = new A($b);

		$this->assertSame($c, $a->find_renderer(C::class));
		$this->assertSame($c, $b->find_renderer(C::class));
		$this->assertSame($b, $a->find_renderer(B::class));
		$this->assertSame($a, $a->find_renderer(A::class));
		$this->assertNull($b->find_renderer(A::class));
	}

	public function test_clone()
	{
		$c = new C;
		$b = new B($c);
		$a = new A($b);
		$d = clone $a;

		$this->assertSame($c, $a->find_renderer(C::class));
		$this->assertSame($b, $a->find_renderer(B::class));
		$this->assertSame($a, $a->find_renderer(A::class));
		$this->assertNotSame($c, $d->find_renderer(C::class));
		$this->assertNotSame($b, $d->find_renderer(B::class));
		$this->assertNotSame($a, $d->find_renderer(A::class));
	}

	public function test_resolve()
	{
		$c = new C;
		$b = new B($c);
		$a = new A($b);

		$expected = 'TESTING.html';

		$this->assertEquals($expected, $a->resolve('TESTING', []));
		$this->assertEquals($expected, $b->resolve('TESTING', []));
		$this->assertEquals($expected, $c->resolve('TESTING', []));
	}
}
