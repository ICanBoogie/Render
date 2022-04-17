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

use ICanBoogie\Accessor\AccessorTrait;
use ICanBoogie\ActiveRecord\Query;

use function basename;
use function dirname;
use function in_array;
use function substr;

/**
 * Representation of a template name.
 *
 * @property-read string $as_template Name as template name.
 * @property-read string $as_partial Name as partial name.
 * @property-read string $as_layout Name as layout name.
 */
final class TemplateName
{
	/**
	 * @uses get_as_template
	 * @uses get_as_partial
	 * @uses get_as_layout
	 */
	use AccessorTrait;

	public const TEMPLATE_PREFIX_VIEW = '';
	public const TEMPLATE_PREFIX_LAYOUT = '@';
	public const TEMPLATE_PREFIX_PARTIAL = '_';

	static private $instances = [];

	/**
	 * @param string|TemplateName $source
	 *
	 * @return TemplateName
	 */
	static public function from($source): self
	{
		if ($source instanceof self) {
			return $source;
		}

		if ($source instanceof Query) {
			$source = $source->model->id . '/list';
		}

		$source = static::normalize($source);

		if (isset(self::$instances[$source])) {
			return self::$instances[$source];
		}

		return self::$instances[$source] = new static($source);
	}

	/**
	 * Normalizes a template name by removing any known prefix.
	 */
	static public function normalize(string $name): string
	{
		$basename = basename($name);
		$dirname = $basename != $name ? dirname($name) : null;

		if (in_array(
			$basename[0],
			[ self::TEMPLATE_PREFIX_VIEW, self::TEMPLATE_PREFIX_LAYOUT, self::TEMPLATE_PREFIX_PARTIAL ]
		)) {
			$basename = substr($basename, 1);
		}

		if ($dirname) {
			$basename = $dirname . "/" . $basename;
		}

		return $basename;
	}

	/**
	 * @var string
	 */
	private $name;

	private function get_as_template(): string
	{
		return $this->name;
	}

	/**
	 * Returns the name as partial name.
	 */
	private function get_as_partial(): string
	{
		return $this->with_prefix(self::TEMPLATE_PREFIX_PARTIAL);
	}

	/**
	 * Returns the name as layout name.
	 */
	protected function get_as_layout(): string
	{
		return $this->with_prefix(self::TEMPLATE_PREFIX_LAYOUT);
	}

	/**
	 * Returns the template name with the specified prefix.
	 */
	public function with_prefix(string $prefix): string
	{
		$name = $this->name;

		if (!$prefix) {
			return $name;
		}

		$basename = basename($name);
		$dirname = $basename != $name ? dirname($name) : null;

		$name = $prefix . $basename;

		if ($dirname) {
			$name = $dirname . "/" . $name;
		}

		return $name;
	}

	private function __construct(string $name)
	{
		$this->name = $name;
	}

	public function __toString()
	{
		return $this->name;
	}
}
