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
 * Wraps a string inside an instance.
 */
class StringObject
{
	private $value;

	public function __construct($value)
	{
		$this->value = (string) $value;
	}

	public function __toString()
	{
		return $this->value;
	}
}
