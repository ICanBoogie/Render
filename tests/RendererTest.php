<?php

namespace ICanBoogie\Render;

use PHPUnit\Framework\TestCase;

class RendererTest extends TestCase
{
	/**
	 * @var TemplateResolver
	 */
	private $template_resolver;

	/**
	 * @var EngineCollection
	 */
	private $engines;

	protected function setUp(): void
	{
		$this->template_resolver = new BasicTemplateResolver([ __DIR__ . '/templates' ]);
		$this->engines = new EngineCollection([ '.phtml' => PHPEngine::class ]);
	}

	/**
	 * @dataProvider provide_test_render
	 *
	 * @param mixed $target_or_options
	 * @param array $additional_options
	 * @param string $expected_rendered
	 */
	public function test_render($target_or_options, array $additional_options, $expected_rendered)
	{
		$rendered = (new Renderer($this->template_resolver, $this->engines))
			->render($target_or_options, $additional_options);

		$this->assertEquals($expected_rendered, $rendered);
	}

	public function provide_test_render()
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
