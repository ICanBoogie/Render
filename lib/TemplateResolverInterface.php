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
 * An interface for template resolvers.
 *
 * @package ICanBoogie\Render
 */
interface TemplateResolverInterface
{
	/**
	 * Returns the pathname to the matching template.
	 *
	 * @param string $name The base name of the template.
	 * @param array $extensions The supported extensions.
	 * @param array $tries Path name tried.
	 *
	 * @return string|false The pathname to the matching template or `false` if none match.
	 */
	public function resolve($name, array $extensions, &$tries = []);

	/**
	 * Adds a path to search templates in.
	 *
	 * Note: The path is discarded if it cannot be resolved with `realpath()`.
	 *
	 * @param string $path
	 * @param int $weight
	 *
	 * @return string|false The real path, or `false` if the path was not added.
	 */
	public function add_path($path, $weight = 0);

	/**
	 * Returns the paths used to search templates.
	 *
	 * @return array
	 */
	public function get_paths();
}
