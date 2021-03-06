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

use ArrayObject;
use Closure;
use Throwable;
use function extract;
use function is_array;
use function is_object;
use function ob_end_clean;
use function ob_get_clean;
use function ob_start;

/**
 * Renders PHP templates.
 */
class PHPEngine implements Engine
{
	/**
	 * @inheritdoc
	 * @throws Throwable
	 */
	public function __invoke($template_pathname, $thisArg, array $variables, array $options = []): string
	{
		$f = Closure::bind(function($__TEMPLATE_PATHNAME__, $__VARIABLES__) {

			unset($__VARIABLES__['this']);

			extract($__VARIABLES__);

			require $__TEMPLATE_PATHNAME__;

		}, $this->ensure_is_object($thisArg));

		ob_start();

		try
		{
			$f($template_pathname, [ self::VAR_TEMPLATE_PATHNAME => $template_pathname ] + $variables);

			return ob_get_clean();
		}
		catch (Throwable $e)
		{
			ob_end_clean();

			throw $e;
		}
	}

	/**
	 * Ensures that a value is an object.
	 *
	 * - `value` is an object, value is returned.
	 * - `value` is an array, an `ArrayObject` instance is returned.
	 * - Otherwise `value` is cast into a string and a {@link String} instance is returned.
	 *
	 * @param mixed $value
	 *
	 * @return ArrayObject|StringObject
	 */
	private function ensure_is_object($value)
	{
		if (is_object($value))
		{
			return $value;
		}

		if (is_array($value))
		{
			return new ArrayObject($value);
		}

		return new StringObject($value);
	}
}
