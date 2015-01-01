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

use ICanBoogie\GetterTrait;

/**
 * Resolve templates pathname.
 *
 * @package ICanBoogie\Render
 *
 * @property-read array $tries The filename tried during the last resolving.
 */
class TemplateResolver
{
	use GetterTrait;

	private $paths = [];

	protected $tries = [];

	protected function get_tries()
	{
		return $this->tries;
	}

	/**
	 * Return the pathname to the matching template.
	 *
	 * @param string $name The base name of the template.
	 * @param EngineCollectionInterface $engines The available engine.
	 *
	 * @return string The pathname to the matching template or `null` if none match.
	 */
	public function __invoke($name, EngineCollectionInterface $engines)
	{
		return $this->resolve($name, $engines);
	}

	/**
	 * Return the pathname to the matching template.
	 *
	 * @param string $name The base name of the template.
	 * @param EngineCollectionInterface $engines The available engine.
	 *
	 * @return string The pathname to the matching template or `null` if none match.
	 */
	public function resolve($name, EngineCollectionInterface $engines)
	{
		$this->tries = [];
		$dirname = dirname($name);
		$basename = basename($name);

		$extensions = $engines->extensions;

		foreach (array_keys(array_reverse($this->paths)) as $path)
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

				$this->tries[] = $pathname;

				if (file_exists($pathname))
				{
					return $pathname;
				}
			}
		}
	}

	/**
	 * Add a path to search templates in.
	 *
	 * Note: The path is discarded if it cannot be resolved with `realpath()`.
	 *
	 * @param $path
	 * @param int $weight
	 *
	 * @return string|void The real path, or `null` if the path was not added.
	 */
	public function add_path($path, $weight=0)
	{
		$path = realpath($path);

		if (!$path)
		{
			return;
		}

		$path = $path . DIRECTORY_SEPARATOR;
		$this->paths[$path] = $weight;

		return $path;
	}
}
