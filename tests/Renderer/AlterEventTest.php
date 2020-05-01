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

use ICanBoogie\Render\BasicTemplateResolver;
use ICanBoogie\Render\EngineCollection;
use ICanBoogie\Render\Renderer;
use ICanBoogie\Render\TemplateResolver;
use PHPUnit\Framework\TestCase;

class AlterEventTest extends TestCase
{
	public function test_replace_instance()
	{
		/* @var $engines_stub EngineCollection */
		$engines_stub = $this
			->getMockBuilder(EngineCollection::class)
			->getMock();

		/* @var $template_resolver_stub BasicTemplateResolver */
		$template_resolver_stub = $this
			->getMockBuilder(TemplateResolver::class)
			->getMock();

		/* @var $renderer_stub Renderer */
		$renderer_stub = $this
			->getMockBuilder(Renderer::class)
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
