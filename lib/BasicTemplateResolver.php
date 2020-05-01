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

use function array_keys;
use function array_reverse;
use function realpath;
use const DIRECTORY_SEPARATOR;

/**
 * Resolves templates pathname.
 */
class BasicTemplateResolver implements TemplateResolver
{
	use TemplateResolverTrait;

	/**
	 * An array of key/value pairs, where _key_ if a pathname and _value_ its weight.
	 *
	 * @var array<string, int>
	 */
	protected $paths = [];

	/**
	 * @param string[] $paths
	 */
	public function __construct(array $paths = [])
	{
		foreach ($paths as $path)
		{
			$this->add_path($path);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function resolve(string $name, array $extensions, array &$tried = [])
	{
		return $this->resolve_path($this->resolve_tries($this->get_paths(), $name, $extensions), $tried);
	}

	/**
	 * Adds a path to search templates in.
	 *
	 * Note: The path is discarded if it cannot be resolved with `realpath()`.
	 *
	 * @return string|false The real path, or `false` if the path was not added.
	 */
	public function add_path(string $path, int $weight = 0)
	{
		$path = realpath($path);

		if (!$path)
		{
			return false;
		}

		$path = $path . DIRECTORY_SEPARATOR;
		$this->paths[$path] = $weight;

		return $path;
	}

	/**
	 * Returns the paths used to search templates.
	 *
	 * @return string[]
	 */
	public function get_paths(): array
	{
		return array_keys(array_reverse($this->paths));
	}
}
