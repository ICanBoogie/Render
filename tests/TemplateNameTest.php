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

class TemplateNameTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider provide_test_normalize
	 *
	 * @param string $expected
	 * @param string $name
	 */
	public function test_normalize($expected, $name)
	{
		$this->assertEquals($expected, TemplateName::normalize($name));
	}

	/**
	 * @dataProvider provide_test_with_prefix
	 *
	 * @param string $name
	 * @param string $prefix
	 * @param string $expected
	 */
	public function test_with_prefix($name, $prefix, $expected)
	{
		$name = TemplateName::from($name);
		$this->assertEquals($expected, $name->with_prefix($prefix));
	}

	public function provide_test_with_prefix()
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

	public function provide_test_normalize()
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
	 *
	 * @param string $expected
	 * @param string $name
	 */
	public function test_get_as_template($expected, $name)
	{
		$name = TemplateName::from($name);
		$this->assertEquals($expected, $name->as_template);
	}

	public function provide_test_get_as_template()
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
	 *
	 * @param string $expected
	 * @param string $name
	 */
	public function test_get_as_partial($expected, $name)
	{
		$name = TemplateName::from($name);
		$this->assertEquals($expected, $name->as_partial);
	}

	public function provide_test_get_as_partial()
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
	 *
	 * @param string $expected
	 * @param string $name
	 */
	public function test_get_as_layout($expected, $name)
	{
		$name = TemplateName::from($name);
		$this->assertEquals($expected, $name->as_layout);
	}

	public function provide_test_get_as_layout()
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
