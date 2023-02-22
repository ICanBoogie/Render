<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Test\ICanBoogie\Render\EngineProvider;

use ICanBoogie\Render\Engine;
use ICanBoogie\Render\EngineProvider\Container;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

final class ContainerTest extends TestCase
{
    private MockObject & Engine $engine_php;
    private MockObject & Engine $engine_markdown;
    private MockObject & ContainerInterface $container;

    protected function setUp(): void
    {
        parent::setUp();

        $this->engine_php = $this->createMock(Engine::class);
        $this->engine_php->method('render')->willReturn("ENGINE_PHP");
        $this->engine_markdown = $this->createMock(Engine::class);
        $this->engine_markdown->method('render')->willReturn("ENGINE_MARKDOWN");

        $this->container = $this->createMock(ContainerInterface::class);
        $this->container
            ->method('get')
            // @phpstan-ignore-next-line
            ->willReturnCallback(fn(string $id) => match ($id) {
                'engine_php' => $this->engine_php,
                'engine_markdown' => $this->engine_markdown
            });
    }

    public function test_engine_for_extension(): void
    {
        $stu = $this->makeSTU();

        $this->assertSame($this->engine_php, $stu->engine_for_extension('.php'));
        $this->assertSame($this->engine_php, $stu->engine_for_extension('.phtml'));
        $this->assertSame($this->engine_markdown, $stu->engine_for_extension('.md'));
    }

    public function test_iterator(): void
    {
        $extensions = [];
        $rendered = [];

        foreach ($this->makeSTU() as $extension => $engine) {
            $this->assertInstanceOf(Engine::class, $engine);

            $extensions[] = $extension;
            $rendered[] = $engine->render('template_pathname', 'content', []);
        }

        $this->assertCount(3, $extensions);
        $this->assertEquals([
            'ENGINE_PHP',
            'ENGINE_PHP',
            'ENGINE_MARKDOWN',
        ], $rendered);
    }

    private function makeSTU(): Container
    {
        return new Container($this->container, [
            '.php' => 'engine_php',
            '.phtml' => 'engine_php',
            '.md' => 'engine_markdown',
        ]);
    }
}
