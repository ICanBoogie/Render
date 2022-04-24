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

use ICanBoogie\Render\BasicTemplateResolver;
use PHPUnit\Framework\TestCase;

use const DIRECTORY_SEPARATOR;

class TemplateResolverTest extends TestCase
{
    private const TEMPLATES_ROOT = __DIR__ . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR;

    public function test_resolve()
    {
        $tr = new BasicTemplateResolver();
        $ds = DIRECTORY_SEPARATOR;

        $extensions = [ '.patron', '.php' ];

        $tried = [];
        $this->assertNull($tr->resolve('posts/index', $extensions, $tried));
        $this->assertEmpty($tried);

        $tr->add_path(__DIR__ . '/templates/default');
        $tried = [];
        $this->assertNull($tr->resolve('posts/index', $extensions, $tried));
        $this->assertNotEmpty($tried);
        $this->assertEquals([

            self::TEMPLATES_ROOT . "default{$ds}posts{$ds}index.patron",
            self::TEMPLATES_ROOT . "default{$ds}posts{$ds}index.php"

        ], $tried);

        $tr->add_path(__DIR__ . '/templates/custom');
        $tried = [];
        $this->assertNull($tr->resolve('posts/index', $extensions, $tried));
        $this->assertNotEmpty($tried);
        $this->assertEquals([

            self::TEMPLATES_ROOT . "custom{$ds}posts{$ds}index.patron",
            self::TEMPLATES_ROOT . "custom{$ds}posts{$ds}index.php",
            self::TEMPLATES_ROOT . "default{$ds}posts{$ds}index.patron",
            self::TEMPLATES_ROOT . "default{$ds}posts{$ds}index.php"

        ], $tried);

        $tr->add_path(__DIR__ . '/templates/all');
        $tried = [];
        $this->assertEquals(
            self::TEMPLATES_ROOT . "all{$ds}posts{$ds}index.php",
            $tr->resolve('posts/index', $extensions, $tried)
        );
        $this->assertNotEmpty($tried);
        $this->assertEquals([

            self::TEMPLATES_ROOT . "all{$ds}posts{$ds}index.patron",
            self::TEMPLATES_ROOT . "all{$ds}posts{$ds}index.php",

        ], $tried);
    }

    public function test_resolve_with_extension()
    {
        $tr = new BasicTemplateResolver();
        $tr->add_path(self::TEMPLATES_ROOT . 'all');
        $pathname = $tr->resolve('with-extension.html', [ '.patron' ]);
        $this->assertNull($pathname);
        $pathname = $tr->resolve('with-extension.html', [ '.html', '.patron' ]);
        $this->assertStringEndsWith('with-extension.html', $pathname);
    }

    public function test_resolve_with_double_extension()
    {
        $tr = new BasicTemplateResolver();
        $tr->add_path(self::TEMPLATES_ROOT . 'all');
        $pathname = $tr->resolve('with-double-extension.html', [ '.patron' ]);
        $this->assertStringEndsWith('with-double-extension.html.patron', $pathname);
        $pathname = $tr->resolve('with-double-extension.html', [ '.html', '.patron' ]);
        $this->assertNull($pathname);
    }

    public function test_add_invalid_path()
    {
        $tr = new BasicTemplateResolver();
        $this->assertFalse($tr->add_path('invalid/path/' . uniqid()));
    }
}
