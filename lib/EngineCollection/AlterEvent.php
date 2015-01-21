<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Render\EngineCollection;

use ICanBoogie\Event;
use ICanBoogie\Render\EngineCollectionInterface;

/**
 * Event class for the `ICanBoogie\Render\EngineCollection::alter` event.
 *
 * Event hooks may use this event to alter the engine collection, or replace it.
 *
 * @package ICanBoogie\Render
 *
 * @property-read EngineCollectionInterface $instance
 */
class AlterEvent extends Event
{
	/**
	 * Reference to the target instance.
	 *
	 * @var EngineCollectionInterface
	 */
	private $instance;

	public function __construct(EngineCollectionInterface &$target)
	{
		$this->instance = &$target;

		parent::__construct($target, 'alter');
	}

	public function __get($property)
	{
		if ($property == 'instance')
		{
			return $this->instance;
		}

		return parent::__get($property);
	}

	/**
	 * Replaces the instance.
	 *
	 * @param EngineCollectionInterface $engines
	 */
	public function replace_with(EngineCollectionInterface $engines)
	{
		$this->instance = $engines;
	}
}
