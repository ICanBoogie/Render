<?php

namespace Test\ICanBoogie\Render\EngineProvider;

use ICanBoogie\Render\Engine;
use ICanBoogie\Render\EngineProvider\Container;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Container\ContainerInterface;

class ContainerTest extends TestCase
{
    use ProphecyTrait;

    private MockObject|Engine $engine_php;
    private MockObject|Engine $engine_markdown;

    /**
     * @var ObjectProphecy<ContainerInterface>
     */
    private ObjectProphecy $container;

    protected function setUp(): void
    {
        parent::setUp();

        $this->engine_php = $this->createMock(Engine::class);
        $this->engine_php->method('render')->willReturn("ENGINE_PHP");
        $this->engine_markdown = $this->createMock(Engine::class);
        $this->engine_markdown->method('render')->willReturn("ENGINE_MARKDOWN");

        $this->container = $this->prophesize(ContainerInterface::class);
        $this->container->get('engine_php')
            ->willReturn($this->engine_php);
        $this->container->get('engine_markdown')
            ->willReturn($this->engine_markdown);
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
        return new Container($this->container->reveal(), [
            '.php' => 'engine_php',
            '.phtml' => 'engine_php',
            '.md' => 'engine_markdown',
        ]);
    }
}
