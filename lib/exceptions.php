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

class RendererNotDefined extends \Exception
{
	use \ICanBoogie\PrototypeTrait;

	private $source;

	private $as;

	public function __construct($source, $as, $code=500, \Exception $previous=null)
	{
		$this->source = $source;
		$this->as = $as;

		$class= get_class($source);

		parent::__construct("There is no renderer defined to render <q>$class</q> as <q>$as</q>.", $code, $previous);
	}

	protected function get_source()
	{
		return $this->source;
	}

	protected function get_as()
	{
		return $this->as;
	}
}
