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

	protected function get_target()
	{
		return $this->target;
	}

	/**
	 * InvalidRenderTarget constructor.
	 *
	 * @param mixed $target
	 * @param string $message
	 * @param int $code
	 * @param \Throwable|null $previous
	 */
	public function __construct($target, string $message = null, int $code = 500, \Throwable $previous = null)
	{
		$this->target = $target;

		parent::__construct($message ?: $this->format_message($target), $code, $previous);
	}

	private function format_message($target): string
	{
		$type = \gettype($target);

		return "Invalid render target. Expected object or array, got: $type (`$target`)";
	}
}
