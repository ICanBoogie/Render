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
 * Render PHP templates.
 *
 * @package ICanBoogie\Render
 */
class PHPEngine implements EngineInterface
{
	/**
	 * @inheritdoc
	 */
	public function __invoke($template_pathname, $thisArg, array $variables, array $options=[])
	{
		$f = function($template_pathname, $variables) {

			extract($variables);

			require $template_pathname;

		};

		if (is_array($thisArg))
		{
			$thisArg = new \ArrayObject($thisArg);
		}

		if (is_object($thisArg))
		{
			$f = \Closure::bind($f, $thisArg);
		}

		ob_start();

		try
		{
			$f($template_pathname, $variables);

			return ob_get_clean();
		}
		catch (\Exception $e)
		{
			ob_end_clean();

			throw $e;
		}
	}
}
