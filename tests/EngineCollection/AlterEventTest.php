<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Render\EngineCollection;

use ICanBoogie\Render\EngineCollection;

class AlterEventTest extends \PHPUnit_Framework_TestCase
{
	public function test_replace_instance()
	{
		$instance = new EngineCollection;
		$instance2 = new EngineCollection;
		$instance3 = new EngineCollection;

		/* @var AlterEvent $event */

		$event = AlterEvent::from([ 'target' => &$instance ]);
		$this->assertSame($instance, $event->instance);

		$event->instance = $instance2;
		$this->assertSame($instance2, $instance);
		$event->instance = $instance3;
		$this->assertSame($instance3, $instance);
	}
}
