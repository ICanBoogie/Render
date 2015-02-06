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
 * Resolve templates pathname.
 *
 * @package ICanBoogie\Render
 */
class BasicTemplateResolver implements TemplateResolver
{
	protected $paths = [];

	/**
	 * @inheritdoc
	 */
	public function resolve($name, array $extensions, &$tries = [])
	{
		$original_extension = pathinfo($name, PATHINFO_EXTENSION);

		if ($original_extension)
		{
			$extensions = array_merge([ '' ],  $extensions);
			$original_extension = '.' . $original_extension;
		}

		$dirname = dirname($name);
		$basename = basename($name);

		foreach ($this->get_paths() as $path)
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

				if (file_exists($pathname))
				{
					if (!$extension && $original_extension && !in_array($original_extension, $extensions))
					{
						continue;
					}

					return $pathname;
				}
			}
		}

		return false;
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
