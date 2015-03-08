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

/**
 * Resolves templates pathname.
 *
 * @package ICanBoogie\Render
 */
class BasicTemplateResolver implements TemplateResolver
{
	use TemplateResolverTrait;

	protected $paths = [];

	/**
	 * @inheritdoc
	 */
	public function resolve($name, array $extensions, &$tried = [])
	{
		return $this->resolve_path($this->resolve_tries($this->get_paths(), $name, $extensions), $tried);
	}

	/**
	 * @inheritdoc
	 */
	public function add_path($path, $weight = 0)
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
	 * @inheritdoc
	 */
	public function get_paths()
	{
		return array_keys(array_reverse($this->paths));
	}
}
