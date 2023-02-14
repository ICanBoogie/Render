<?php

namespace Test\ICanBoogie\Render\TemplateResolver;

use ICanBoogie\Render\TemplateResolver;
use PHPUnit\Framework\TestCase;

final class ChainTest extends TestCase
{
    public function test_resolve(): void
    {
        $name = 'articles/show';
        $extensions = [ '.php', '.html' ];
        $tried = [];
        $expected = '/path/to/templates/articles/show.phtml';

        $ko = $this->createMock(TemplateResolver::class);
        $ko->method('resolve')
            ->with($name, $extensions, $tried)
            ->willReturn(null);

        $ok = $this->createMock(TemplateResolver::class);
        $ok->method('resolve')
            ->with($name, $extensions, $tried)
            ->willReturn($expected);

        $no = $this->createMock(TemplateResolver::class);
        $no->expects($this->never())
            ->method('resolve')
            ->with($this->anything(), $this->anything(), $this->anything());

        $sut = new TemplateResolver\Chain([ $ko, $ok, $no ]);

        $actual = $sut->resolve($name, $extensions, $tried);

        $this->assertEquals($expected, $actual);
    }
}
