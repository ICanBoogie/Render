<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Test\ICanBoogie\Render;

use ICanBoogie\Render\EngineProvider\Immutable;
use ICanBoogie\Render\PHPEngine;
use ICanBoogie\Render\Renderer;
use ICanBoogie\Render\RenderOptions;
use ICanBoogie\Render\TemplateResolver;
use ICanBoogie\Render\TemplateResolver\Basic;
use PHPUnit\Framework\TestCase;

final class RendererTest extends TestCase
{
    private TemplateResolver $template_resolver;
    private Immutable $engines;

    protected function setUp(): void
    {
        $this->template_resolver = new Basic([ __DIR__ . '/templates' ]);
        $this->engines = new Immutable([ '.phtml' => new PHPEngine() ]);
    }

    /**
     * @dataProvider provide_test_render
     */
    public function test_render(mixed $content, RenderOptions $options, mixed $expected_rendered): void
    {
        $rendered = (new Renderer($this->template_resolver, $this->engines))
            ->render($content, $options);

        $this->assertEquals($expected_rendered, trim($rendered));
    }

    /**
     * @return array<array{ mixed, RenderOptions, string }>
     */
    public function provide_test_render(): array
    {
        return [

            [
                null,
                new RenderOptions(),
                ''
            ],
            [
                [ 'a', 'b', 'c' ],
                new RenderOptions(
                    partial: 'list',
                    layout: 'alphabet'
                ),
                <<<TXT
				alphabet:
				- letter: a
				- letter: b
				- letter: c
				TXT
            ],
            [
                new \Exception(),
                new RenderOptions(
                    partial: 'renderer/exception'
                ),
                'PARTIAL: Exception'
            ],
            [
                new \Exception(),
                new RenderOptions(
                    partial: 'renderer/exception',
                    layout: 'default'
                ),
                '<LAYOUT>PARTIAL: Exception</LAYOUT>'
            ],

        ];
    }
}
