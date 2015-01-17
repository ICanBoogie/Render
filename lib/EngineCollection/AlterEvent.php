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
 */
class AlterEvent extends Event
{
	/**
	 * Reference to the target instance.
	 *
	 * @var EngineCollectionInterface
	 */
	public $instance;

	public function __construct(EngineCollectionInterface &$target)
	{
		$this->instance = &$target;

		parent::__construct($target, 'alter');
	}
}
