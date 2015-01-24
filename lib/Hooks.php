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
		return get_engines();
	}

	/**
	 * Returns a clone of the shared template resolver.
	 *
	 * @return TemplateResolver
	 */
	static public function lazy_get_template_resolver()
	{
		return clone get_template_resolver();
	}
}
