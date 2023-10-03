<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Render;

use PHPUnit\Framework\TestCase;

class TemplateNameTest extends TestCase
{
    public function test_from_instance()
    {
        $name = TemplateName::from('testing' . uniqid());
        $this->assertEquals($name, TemplateName::from($name));
    }

    /**
     * @dataProvider provide_test_normalize
     */
    public function test_normalize(string $expected, string $name)
    {
        $this->assertEquals($expected, TemplateName::normalize($name));
    }

    /**
     * @dataProvider provide_test_with_prefix
     */
    public function test_with_prefix(string $name, string $prefix, string $expected)
    {
        $name = TemplateName::from($name);
        $this->assertEquals($expected, $name->with_prefix($prefix));
    }

    public static function provide_test_with_prefix()
    {
        return [

            [ 'page', '', 'page' ],
            [ 'page', '@', '@page' ],
            [ 'page', '_', '_page' ],
            [ 'site/page', '', 'site/page' ],
            [ 'site/page', '@', 'site/@page' ],
            [ 'site/page', '_', 'site/_page' ],
            [ '//page', '', '//page' ],
            [ '//page', '@', '//@page' ],
            [ '//page', '_', '//_page' ],
            [ '//path/to/page', '', '//path/to/page' ],
            [ '//path/to/page', '@', '//path/to/@page' ],
            [ '//path/to/page', '_', '//path/to/_page' ]

        ];
    }

    public static function provide_test_normalize()
    {
        return [

            [ 'page', 'page' ],
            [ 'page', '_page' ],
            [ 'page', '@page' ],
            [ 'site/page', 'site/page' ],
            [ 'site/page', 'site/_page' ],
            [ 'site/page', 'site/@page' ],
            [ '/path/to/page', '/path/to/page' ],
            [ '/path/to/page', '/path/to/_page' ],
            [ '/path/to/page', '/path/to/@page' ],
            [ '//page', '//page' ],
            [ '//page', '//_page' ],
            [ '//page', '//@page' ]

        ];
    }

    /**
     * @dataProvider provide_test_get_as_template
     */
    public function test_get_as_template(string $expected, string $name)
    {
        $name = TemplateName::from($name);
        $this->assertEquals($expected, $name->as_template);
    }

    public static function provide_test_get_as_template()
    {
        return [

            [ 'page', 'page' ],
            [ 'page', '_page' ],
            [ 'page', '@page' ],
            [ 'site/page', 'site/page' ],
            [ 'site/page', 'site/_page' ],
            [ 'site/page', 'site/@page' ],
            [ '/path/to/page', '/path/to/page' ],
            [ '/path/to/page', '/path/to/_page' ],
            [ '/path/to/page', '/path/to/@page' ],
            [ '//page', '//page' ],
            [ '//page', '//_page' ],
            [ '//page', '//@page' ]

        ];
    }

    /**
     * @dataProvider provide_test_get_as_partial
     */
    public function test_get_as_partial(string $expected, string $name)
    {
        $name = TemplateName::from($name);
        $this->assertEquals($expected, $name->as_partial);
    }

    public static function provide_test_get_as_partial()
    {
        return [

            [ '_page', 'page' ],
            [ '_page', '_page' ],
            [ '_page', '@page' ],
            [ 'site/_page', 'site/page' ],
            [ 'site/_page', 'site/_page' ],
            [ 'site/_page', 'site/@page' ],
            [ '/path/to/_page', '/path/to/page' ],
            [ '/path/to/_page', '/path/to/_page' ],
            [ '/path/to/_page', '/path/to/@page' ],
            [ '//_page', '//page' ],
            [ '//_page', '//_page' ],
            [ '//_page', '//@page' ]

        ];
    }

    /**
     * @dataProvider provide_test_get_as_layout
     */
    public function test_get_as_layout(string $expected, string $name)
    {
        $name = TemplateName::from($name);
        $this->assertEquals($expected, $name->as_layout);
    }

    public static function provide_test_get_as_layout()
    {
        return [

            [ '@page', 'page' ],
            [ '@page', '_page' ],
            [ '@page', '@page' ],
            [ 'site/@page', 'site/page' ],
            [ 'site/@page', 'site/_page' ],
            [ 'site/@page', 'site/@page' ],
            [ '/path/to/@page', '/path/to/page' ],
            [ '/path/to/@page', '/path/to/_page' ],
            [ '/path/to/@page', '/path/to/@page' ],
            [ '//@page', '//page' ],
            [ '//@page', '//_page' ],
            [ '//@page', '//@page' ]

        ];
    }

    public function test_toString()
    {
        $name = '//page';

        $this->assertEquals($name, (string) TemplateName::from($name));
    }
}
