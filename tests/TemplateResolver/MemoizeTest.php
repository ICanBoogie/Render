<?php

namespace Test\ICanBoogie\Render\TemplateResolver;

use ICanBoogie\Render\TemplateResolver;
use PHPUnit\Framework\TestCase;

use function array_unique;
use function uniqid;

final class MemoizeTest extends TestCase
{
    public function test_memoize(): void
    {
        $inner = new class implements TemplateResolver {
            public function resolve(string $name, array $extensions, array &$tried = []): string
            {
                return uniqid();
            }
        };

        $sut = new TemplateResolver\Memoize($inner);
        $name1 = "name1";
        $name2 = "name2";

        $result = [

            $sut->resolve($name1, [ '.php', '.phtml' ]),
            $sut->resolve($name1, [ '.php', '.phtml' ]),
            $sut->resolve($name1, [ '.php', '.phtml' ]),
            $sut->resolve($name1, [ '.php' ]),
            $sut->resolve($name1, [ '.php' ]),
            $sut->resolve($name1, [ '.php' ]),
            $sut->resolve($name2, [ '.php' ]),
            $sut->resolve($name2, [ '.php' ]),
            $sut->resolve($name2, [ '.php' ]),

        ];

        $this->assertCount(3, array_unique($result));
    }
}
