<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Render\Renderer;

use ICanBoogie\Event;
use ICanBoogie\Render\Renderer;

/**
 * Event class for the `ICanBoogie\Render\Renderer::alter` event.
 *
 * Event hooks may use this event to alter a renderer, or replace it.
 *
 * @package ICanBoogie\Render
 *
 * @property-read Renderer $instance
 */
class AlterEvent extends Event
{
	/**
	 * Reference to the target instance.
	 *
	 * @var Renderer
	 */
	public $instance;

	public function __construct(Renderer &$target)
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
	 * @param Renderer $template_resolver
	 */
	public function replace_with(Renderer $template_resolver)
	{
		$this->instance = $template_resolver;
	}
}