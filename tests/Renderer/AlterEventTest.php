<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Render\Renderer;

use ICanBoogie\Render\Renderer;

class AlterEventTest extends \PHPUnit\Framework\TestCase
{
	public function test_replace_instance()
	{
		/* @var $engines_stub \ICanBoogie\Render\EngineCollection */
		$engines_stub = $this
			->getMockBuilder('ICanBoogie\Render\EngineCollection')
			->getMock();

		/* @var $template_resolver_stub \ICanBoogie\Render\BasicTemplateResolver */
		$template_resolver_stub = $this
			->getMockBuilder('ICanBoogie\Render\TemplateResolver')
			->getMock();

		/* @var $renderer_stub \ICanBoogie\Render\Renderer */
		$renderer_stub = $this
			->getMockBuilder('ICanBoogie\Render\Renderer')
			->disableOriginalConstructor()
			->getMock();

		$instance = new Renderer($template_resolver_stub, $engines_stub);

		/* @var $event AlterEvent */

		$event = AlterEvent::from([ 'target' => &$instance ]);
		$this->assertSame($instance, $event->instance);

		$event->instance = $renderer_stub;
		$this->assertSame($renderer_stub, $event->instance);
		$this->assertSame($renderer_stub, $instance);
	}
}
