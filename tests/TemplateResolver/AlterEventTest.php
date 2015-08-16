<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Render\TemplateResolver;

use ICanBoogie\Render\BasicTemplateResolver;

class AlterEventTest extends \PHPUnit_Framework_TestCase
{
	public function test_replace_instance()
	{
		$instance = $backup = new BasicTemplateResolver;

		/* @var $event AlterEvent */

		$event = AlterEvent::from([ 'target' => &$instance ]);
		$event->instance = new BasicTemplateResolver;

		$this->assertSame($instance, $event->instance);
		$this->assertNotSame($backup, $event->instance);
	}
}
