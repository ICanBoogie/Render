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

/**
 * An engine collection.
 *
 * @package ICanBoogie\Render
 *
 * @property-read array $extensions The extensions supported by the engines.
 */
class EngineCollection implements \ArrayAccess, \IteratorAggregate
{
	use AccessorTrait;

	/**
	 * @var array
	 */
	private $engines;

	/**
	 * @return array
	 */
	protected function get_extensions()
	{
		return array_keys($this->engines);
	}

	/**
	 * @var Engine[]
	 */
	private $instances;

	/**
	 * @param array $engines
	 */
	public function __construct(array $engines = [])
	{
		foreach ($engines as $extension => $engine)
		{
			$this[$extension] = $engine;
		}
	}

	/**
	 * @inheritdoc
	 */
	public function offsetExists($extension)
	{
		return isset($this->engines[$extension]);
	}

	/**
	 * @inheritdoc
	 */
	public function offsetGet($extension)
	{
		if (!$this->offsetExists($extension))
		{
			throw new EngineNotDefined([ $extension, $this ]);
		}

		if (empty($this->instances[$extension]))
		{
			$instance = $this->engines[$extension];

			if (is_string($instance))
			{
				$instance = new $instance;
			}

			$this->instances[$extension] = $instance;
		}

		return $this->instances[$extension];
	}

	/**
	 * @inheritdoc
	 */
	public function offsetSet($extension, $engine)
	{
		$this->engines[$extension] = $engine;
	}

	/**
	 * @inheritdoc
	 */
	public function offsetUnset($extension)
	{
		unset($this->engines[$extension]);
	}

	/**
	 * @inheritdoc
	 */
	public function getIterator()
	{
		return new \ArrayIterator($this->engines);
	}

	/**
	 * Resolves the engine to use from the specified pathname.
	 *
	 * @param $pathname
	 *
	 * @return Engine|bool An engine or `false` if none matches the extension.
	 */
	public function resolve_engine($pathname)
	{
		$extension = pathinfo($pathname, PATHINFO_EXTENSION);

		if (!$extension)
		{
			return false;
		}

		$extension = "." . $extension;

		if (!isset($this[$extension]))
		{
			return false;
		}

		return $this[$extension];
	}

	/**
	 * Renders a template with the specified variables.
	 *
	 * @param string $template_pathname The pathname of the template.
	 * @param mixed $thisArg The subject of the rendering.
	 * @param array $variables
	 * @param array $options
	 *
	 * @return string
	 *
	 * @throws EngineNotAvailable when there is no engine available to render the template.
	 */
	public function render($template_pathname, $thisArg, $variables, array $options = [])
	{
		$engine = $this->resolve_engine($template_pathname);

		if (!$engine)
		{
			throw new EngineNotAvailable("There is no engine available to render template $template_pathname.");
		}

		return $engine->render($template_pathname, $thisArg, $variables, $options);
	}
}
