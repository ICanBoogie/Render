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
	/*
	 * Prototypes
	 */

	/**
	 * Synthesizes the `renderers` config.
	 *
	 * @param array $fragments
	 *
	 * @return mixed
	 */
	static public function synthesize_config(array $fragments)
	{
		return call_user_func_array('ICanBoogie\array_merge_recursive', $fragments);
	}

	/**
	 * Returns a {@link Renderer} instance created with the `renderers` config.
	 *
	 * @param Core $core
	 *
	 * @return \ICanBoogie\Render\Renderer
	 */
	static public function lazy_get_renderer(Core $core)
	{
		return new Renderer($core->configs['renderers']);
	}

	/**
	 * Use `$core->renderer` to render an object.
	 *
	 * @param Core $core
	 * @param mixed $object
	 * @param string $as
	 * @param array $options
	 */
	static public function render(Core $core, $object, $as, array $options=[])
	{
		$renderer = $core->renderer;

		return $renderer($object, $as, $options);
	}

	/*
	 * Markups
	 */

	static public function markup_render(array $args, $engine, $template)
	{
		global $core;

		$options = $args['options'] ?: [];

		if (is_string($options))
		{
			$options = trim($options);

			if ($options[0] == '{')
			{
				$options = json_decode($options,true);
			}
		}

		$options += $args;

		unset($options['as']);
		unset($options['property']);
		unset($options['select']);
		unset($options['options']);

		$type = null;

		if (isset($args['as']))
		{
			$type = 'as:' . $args['as'];
		}
		else if (isset($args['property']))
		{
			$type = 'property:' . $args['property'];
		}

		if (!$type)
		{
			throw new \Exception("'as' or 'property' is required.");
		}

		return $core->render($args['select'], $type, $options + [

			'document' => $core->document,
			'engine' => $engine

		]);
	}
}
