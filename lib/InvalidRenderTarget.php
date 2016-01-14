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

use ICanBoogie\Accessor\AccessorTrait;

/**
 * Exception thrown when the target to render is invalid.
 *
 * @property-read mixed $target
 */
class InvalidRenderTarget extends \InvalidArgumentException implements Exception
{
	use AccessorTrait;

	/**
	 * @var mixed
	 */
	private $target;

	/**
	 * InvalidRenderTarget constructor.
	 *
	 * @param mixed $target
	 * @param string $message
	 * @param int $code
	 * @param \Exception|null $previous
	 */
	public function __construct($target, $message = null, $code = 500, \Exception $previous = null)
	{
		$this->target = $target;

		parent::__construct($message ?: $this->format_message($target), $code, $previous);
	}

	/**
	 * Format exception message.
	 *
	 * @param mixed $target
	 *
	 * @return string
	 */
	protected function format_message($target)
	{
		$type = gettype($target);

		return "Invalid render target. Expected object or array, got: $type (`$target`)";
	}
}
