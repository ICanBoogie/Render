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

class Hooks
{
	/**
	 * Returns a shared engine collection.
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
	 * Returns a shared template resolver.
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

	/**
	 * Returns a shared renderer.
	 *
	 * The renderer is created with the shared template resolver and the shared engine collection
	 * respectively provided by the {@link get_template_resolver()} and {@link get_engines()}
	 * functions.
	 *
	 * @return Renderer
	 */
	static public function get_renderer()
	{
		static $renderer;

		if (!$renderer)
		{
			$renderer = new Renderer(self::get_template_resolver(), self::get_engines());

			new Renderer\AlterEvent($renderer);
		}

		return $renderer;
	}

	/*
	 * Prototypes
	 */

	/**
	 * Returns the shared engine collection.
	 *
	 * @return EngineCollection
	 */
	static public function lazy_get_engines()
	{
		return self::get_engines();
	}

	/**
	 * Returns a clone of the shared template resolver.
	 *
	 * @return TemplateResolver
	 */
	static public function lazy_get_template_resolver()
	{
		return clone self::get_template_resolver();
	}
}
