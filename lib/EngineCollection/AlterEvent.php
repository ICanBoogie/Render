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
use ICanBoogie\Render\EngineCollection;

/**
 * Event class for the `ICanBoogie\Render\EngineCollection::alter` event.
 *
 * Event hooks may use this event to alter the engine collection, or replace it.
 *
 * @package ICanBoogie\Render
 *
 * @property-read EngineCollection $instance
 */
class AlterEvent extends Event
{
	/**
	 * Reference to the target instance.
	 *
	 * @var EngineCollection
	 */
	private $instance;

	protected function get_instance()
	{
		return $this->instance;
	}

	protected function set_instance(EngineCollection $engines)
	{
		$this->instance = $engines;
	}

	public function __construct(EngineCollection &$target)
	{
		$this->instance = &$target;

		parent::__construct($target, 'alter');
	}
}
