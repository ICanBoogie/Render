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
 * @property EngineCollection $instance
 */
final class AlterEvent extends Event
{
    public const TYPE = 'alter';

	/**
	 * Reference to the target instance.
	 *
	 * @var EngineCollection
     *
     * @uses get_instance
     * @uses set_instance
	 */
	private $instance;

	protected function get_instance(): EngineCollection
	{
		return $this->instance;
	}

	protected function set_instance(EngineCollection $engines): void
	{
		$this->instance = $engines;
	}

	public function __construct(EngineCollection &$target)
	{
		$this->instance = &$target;

		parent::__construct($target, self::TYPE);
	}
}
