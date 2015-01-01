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
 * An interface for classes implementing an engine collection.
 *
 * @package ICanBoogie\Render
 */
interface EngineCollectionInterface extends \ArrayAccess, \IteratorAggregate
{
	/**
	 * Resolve the engine from the specified pathname.
	 *
	 * @param $pathname
	 *
	 * @return callable|null A callable engine or `null` if none matches the extension.
	 */
	public function resolve_engine($pathname);

	/**
	 * Render a template with the specified variables.
	 *
	 * @param string $template_pathname The pathname of the template.
	 * @param mixed $thisArg The subject of the rendering.
	 * @param array $variables
	 * @param array $options
	 *
	 * @return mixed
	 *
	 * @throws EngineNotAvailable if there is no engine available to render the template.
	 */
	public function render($template_pathname, $thisArg, $variables, array $options=[]);
}
