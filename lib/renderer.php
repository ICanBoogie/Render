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

class Renderer
{
	protected $renderers;

	public function __construct(array $config)
	{
		foreach ($config as $class => $renderers)
		{
			foreach ($renderers as $type => $renderer)
			{
				$this->add_renderer($class, $type, $renderer);
			}
		}
	}

	public function __invoke($source, $as, array $options=[])
	{
		$c = get_class($source);

		$renderers = &$this->renderers;
		$component = $source;
		$state = new State($component, $options);

		while ($c)
		{
			if (empty($renderers[$c][$as]))
			{
				$c = get_parent_class($c);

				continue;
			}

			$renderer = $renderers[$c][$as];

			if (class_exists($renderer, true))
			{
				$renderer = $renderers[$c][$as] = new $renderer;
			}

			return call_user_func($renderer, $source, $options);
		}

		if ($state->component === $source)
		{
			throw new RendererNotDefined($source, $as);
		}
	}

	public function add_renderer($class, $type, $renderer)
	{
		$this->renderers[$class][$type] = $renderer;
	}
}

class State
{
	public $component;
	public $options;
	public $decorators = [];

	private $parent;

	public function __construct($component, array $options)
	{

	}

	public function fork()
	{
		$state = clone $this;
		$state->parent = $this;

		return $state;
	}
}
