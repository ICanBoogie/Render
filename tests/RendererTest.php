<?php

namespace ICanBoogie\Render;

use ICanBoogie\Render\EngineProvider\Immutable;
use PHPUnit\Framework\TestCase;

class RendererTest extends TestCase
{
	private readonly TemplateResolver $template_resolver;
	private readonly Immutable $engines;

	protected function setUp(): void
	{
		$this->template_resolver = new BasicTemplateResolver([ __DIR__ . '/templates' ]);
		$this->engines = new Immutable([ '.phtml' => new PHPEngine() ]);
	}

	/**
	 * @dataProvider provide_test_render
	 */
	public function test_render(mixed $target_or_options, array $additional_options, mixed $expected_rendered): void
	{
		$rendered = (new Renderer($this->template_resolver, $this->engines))
			->render($target_or_options, $additional_options);

		$this->assertEquals($expected_rendered, $rendered);
	}

	public function provide_test_render(): array
	{
		return [

			[ null, [], null ],
			[ new \Exception, [ Renderer::OPTION_PARTIAL => 'renderer/exception' ], 'PARTIAL: Exception' ],
			[ [ Renderer::OPTION_CONTENT => new \Exception, Renderer::OPTION_PARTIAL => 'renderer/exception' ], [ ], 'PARTIAL: Exception' ]

		];
	}

	/**
	 * @dataProvider provide_test_render_invalid
	 *
	 *
	 * @param mixed $target
	 */
	public function test_render_invalid($target)
	{
		$this->expectException(InvalidRenderTarget::class);
		(new Renderer($this->template_resolver, $this->engines))
			->render($target);
	}

	public function provide_test_render_invalid()
	{
		return [

			[ 123 ],
			[ uniqid() ],
			[ "madonna" . uniqid() ]

		];
	}
}
