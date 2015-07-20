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
 * Support functions for template resolvers.
 */
trait TemplateResolverTrait
{
	/**
	 * Resolves path tries.
	 *
	 * The method resolves a try path collection from a collection of roots, template name, and
	 * extension collection.
	 *
	 * @param array $paths Template directories paths.
	 * @param string $name Template name.
	 * @param array $extensions Supported extensions.
	 *
	 * @return array A collection of candidate template pathnames.
	 */
	protected function resolve_tries(array $paths, $name, array $extensions)
	{
		$extension = pathinfo($name, PATHINFO_EXTENSION);

		if ($extension && in_array('.' . $extension, $extensions))
		{
			$name = substr($name, 0, -strlen($extension) - 1);
		}

		$tries = [];
		$dirname = dirname($name);
		$basename = basename($name);

		foreach ($paths as $path)
		{
			foreach ($extensions as $extension)
			{
				$filename = $name;

				if ($dirname && $dirname == basename(dirname($path)))
				{
					$filename = $basename;
				}

				$filename = $filename . $extension;
				$pathname = $path . $filename;

				$tries[] = $pathname;
			}
		}

		return $tries;
	}

	/**
	 * Resolves a template path.
	 *
	 * The method returns the pathname of the first file matching the path collection. The tried
	 * paths are collected in `$tried`.
	 *
	 * @param array $tries Pathname collection, as returned by {@link resolve_tries()}.
	 * @param array $tried Tried pathname collection.
	 *
	 * @return string|null
	 */
	protected function resolve_path(array $tries, &$tried)
	{
		foreach ($tries as $pathname)
		{
			$tried[] = $pathname;

			if (file_exists($pathname))
			{
				return $pathname;
			}
		}

		return null;
	}
}
