<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Render\TemplateResolver;

use ICanBoogie\Event;
use ICanBoogie\Render\TemplateResolver;

/**
 * Event class for the `ICanBoogie\Render\TemplateResolver::alter` event.
 *
 * Event hooks may use this event to alter the engine collection.
 *
 * @package ICanBoogie\Render\TemplateResolver
 */
class AlterEvent extends Event
{
	public function __construct(TemplateResolver $target)
	{
		parent::__construct($target, 'alter');
	}
}
