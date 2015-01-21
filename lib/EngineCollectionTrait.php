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
 * A trait for classes implementing {@link EngineCollectionInterface}.
 *
 * @package ICanBoogie\Render
 */
trait EngineCollectionTrait
{
	/**
	 * Resolve the engine from the specified pathname.
	 *
	 * @param $pathname
	 *
	 * @return callable|bool A callable engine or `false` if none matches the extension.
	 */
	public function resolve_engine($pathname)
	{
		$extension = pathinfo($pathname, PATHINFO_EXTENSION);

		if (!$extension)
		{
			return false;
		}

		$extension = "." . $extension;

		if (!isset($this[$extension]))
		{
			return false;
		}

		return $this[$extension];
	}

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
	 * @throws EngineNotAvailable when there is no engine available to render the template.
	 */
	public function render($template_pathname, $thisArg, $variables, array $options=[])
	{
		$engine = $this->resolve_engine($template_pathname);

		if (!$engine)
		{
			throw new EngineNotAvailable("There is no engine available to render template $template_pathname.");
		}

		return $engine->render($template_pathname, $thisArg, $variables, $options);
	}
}
