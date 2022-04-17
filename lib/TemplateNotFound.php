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

use LogicException;
use Throwable;

use function array_map;
use function implode;

/**
 * Exception throw when a template cannot be found.
 *
 * @property-read array $tried Tried pathname collection.
 */
class TemplateNotFound extends LogicException implements Exception
{
	public function __construct(
		string $message,
		public readonly array $tried,
		Throwable $exception = null
	) {
		if ($tried) {
			$tried = implode("\n", array_map(fn($v) => "- $v", $tried));
			$message .= " The following files were tried:\n\n" . $tried;
		} else {
			$message .= " Also, no possible files were specified.";
		}

		parent::__construct($message, 0, $exception);
	}
}
