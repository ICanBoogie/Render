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
 * An engine collection.
 *
 * @package ICanBoogie\Render
 *
 * @property-read array $extensions The extensions supported by the engines.
 */
class EngineCollection implements EngineCollectionInterface
{
	use GetterTrait;
	use EngineCollectionTrait;

	private $engines;

	/**
	 * @return array
	 */
	protected function get_extensions()
	{
		return array_keys($this->engines);
	}

	private $instances;

	public function __construct(array $engines)
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
			$class = $this->engines[$extension];
			$this->instances[$extension] = new $class;
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
}
