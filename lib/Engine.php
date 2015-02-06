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

/**
 * An interface for template engines.
 *
 * @package ICanBoogie\Render
 */
interface Engine
{
	/**
	 * @param string $template_pathname Pathname to the template to render.
	 * @param mixed $thisArg _thisArg_, if supported by the engine.
	 * @param array $variables Variable to render the template with.
	 * @param array $options Miscellaneous options.
	 *
	 * @return mixed
	 */
	public function render($template_pathname, $thisArg, array $variables, array $options=[]);
}
