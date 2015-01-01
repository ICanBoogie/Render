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

use ICanBoogie\Core;

class Hooks
{
	/**
	 * Return the available template engines.
	 *
	 * @return EngineCollection
	 */
	static public function get_engines()
	{
		static $engines;

		if (!$engines)
		{
			$engines = new EngineCollection([

				'.php' => 'ICanBoogie\Render\PHPEngine'

			]);

			new EngineCollection\AlterEvent($engines);
		}

		return $engines;
	}

	/**
	 * Return the template resolver.
	 *
	 * @return TemplateResolver
	 */
	static public function get_template_resolver()
	{
		static $template_resolver;

		if (!$template_resolver)
		{
			$template_resolver = new TemplateResolver;

			new TemplateResolver\AlterEvent($template_resolver);
		}

		return $template_resolver;
	}

	/*
	 * Prototypes
	 */

	/**
	 * Return the shared engine collection.
	 *
	 * @return EngineCollection
	 */
	static public function lazy_get_render_engines()
	{
		return self::get_engines();
	}

	/**
	 * Return a clone of the shared template resolver.
	 *
	 * @return TemplateResolver
	 */
	static public function lazy_get_render_template_resolver()
	{
		return clone self::get_template_resolver();
	}
}
