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
 * Event class for the `ICanBoogie\Render\BasicTemplateResolver::alter` event.
 *
 * Event hooks may use this event to alter the engine collection, or replace it.
 *
 * @package ICanBoogie\Render
 *
 * @property-read TemplateResolver $instance
 */
class AlterEvent extends Event
{
	/**
	 * Reference to the target instance.
	 *
	 * @var TemplateResolver
	 */
	public $instance;

	public function __construct(TemplateResolver &$target)
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
	 * @param TemplateResolver $template_resolver
	 */
	public function replace_with(TemplateResolver $template_resolver)
	{
		$this->instance = $template_resolver;
	}
}
