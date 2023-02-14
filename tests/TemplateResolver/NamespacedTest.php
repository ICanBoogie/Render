<?php

namespace Test\ICanBoogie\Render\TemplateResolver;

use ICanBoogie\Render\TemplateResolver\Namespaced;
use PHPUnit\Framework\TestCase;

final class NamespacedTest extends TestCase
{
    private Namespaced $template_resolver;

    protected function setUp(): void
    {
        parent::setUp();

        $this->template_resolver = new Namespaced([

            'articles' => dirname(__DIR__) . '/Acme/components/articles/templates',
            'comments' => dirname(__DIR__) . '/Acme/components/comments/templates',

        ]);
    }

    /**
     * @dataProvider provide_resolve
     */
    public function test_resolve(string $name, string $expected): void
    {
        $tried = [];
        $actual = $this->template_resolver->resolve($name, [ '.patron', '.phtml' ], $tried);

        $this->assertNotNull($actual);
        $this->assertStringEndsWith($expected, $actual);
    }

    /**
     * @return array<array{ string, string }>
     */
    public static function provide_resolve(): array
    {
        return [

            [
                'articles/_show',
                '/tests/Acme/components/articles/templates/_show.phtml',
            ],

            [
                'comments/_show',
                '/tests/Acme/components/comments/templates/_show.patron',
            ],

        ];
    }

    public function test_resolve_failure(): void
    {
        $tried = [];
        $actual = $this->template_resolver->resolve('images/_show', [ '.patron', '.phtml' ], $tried);

        $this->assertNull($actual);
        $this->assertEmpty($tried);
    }
}
