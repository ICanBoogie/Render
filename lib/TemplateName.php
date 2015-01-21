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

use ICanBoogie\ActiveRecord\Query;
use ICanBoogie\GetterTrait;

/**
 * Representation of a template name.
 *
 * @package ICanBoogie\Render
 *
 * @property-read string $as_template Name as template name.
 * @property-read string $as_partial Name as partial name.
 * @property-read string $as_layout Name as layout name.
 */
class TemplateName
{
	use GetterTrait;

	const TEMPLATE_PREFIX_VIEW = '';
	const TEMPLATE_PREFIX_LAYOUT = '@';
	const TEMPLATE_PREFIX_PARTIAL = '_';

	static private $instances = [];

	/**
	 * @param string|TemplateName $source
	 *
	 * @return TemplateName
	 */
	static public function from($source)
	{
		if ($source instanceof self)
		{
			return $source;
		}

		if ($source instanceof Query)
		{
			$source = $source->model->id . '/list';
		}

		$source = static::normalize($source);

		if (isset(self::$instances[$source]))
		{
			return self::$instances[$source];
		}

		return self::$instances[$source] = new static($source);
	}

	/**
	 * Normalizes a template name by removing any known prefix.
	 *
	 * @param string $name
	 *
	 * @return string
	 */
	static public function normalize($name)
	{
		$basename = basename($name);
		$dirname = $basename != $name ? dirname($name) : null;

		if (in_array($basename{0}, [ self::TEMPLATE_PREFIX_VIEW, self::TEMPLATE_PREFIX_LAYOUT, self::TEMPLATE_PREFIX_PARTIAL ]))
		{
			$basename = substr($basename, 1);
		}

		if ($dirname)
		{
			$basename = $dirname . "/". $basename;
		}

		return $basename;
	}

	private $name;

	/**
	 * Returns the name as template name.
	 *
	 * @return string
	 */
	protected function get_as_template()
	{
		return $this->name;
	}

	/**
	 * Returns the name as partial name.
	 *
	 * @return string
	 */
	protected function get_as_partial()
	{
		return $this->with_prefix(self::TEMPLATE_PREFIX_PARTIAL);
	}

	/**
	 * Returns the name as layout name.
	 *
	 * @return string
	 */
	protected function get_as_layout()
	{
		return $this->with_prefix(self::TEMPLATE_PREFIX_LAYOUT);
	}

	/**
	 * Returns the template name with the specified prefix.
	 *
	 * @param string $prefix
	 *
	 * @return string
	 */
	public function with_prefix($prefix)
	{
		$name = $this->name;

		if (!$prefix)
		{
			return $name;
		}

		$basename = basename($name);
		$dirname = $basename != $name ? dirname($name) : null;

		$name = $prefix . $basename;

		if ($dirname)
		{
			$name = $dirname . "/" . $name;
		}

		return $name;
	}

	/**
	 * Initializes the {@link $name} property.
	 *
	 * @param string $name
	 */
	protected function __construct($name)
	{
		$this->name = (string) $name;
	}

	/**
	 * Returns the {@link $name} property.
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->name;
	}
}
