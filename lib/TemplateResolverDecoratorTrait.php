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
 * An interface for template resolver decorators.
 */
trait TemplateResolverDecoratorTrait
{
	/**
	 * @var TemplateResolver
	 */
	protected $template_resolver;

	/**
	 * Initializes the {@link $template_resolver} property.
	 *
	 * @param TemplateResolver $template_resolver
	 */
	public function __construct(TemplateResolver $template_resolver)
	{
		$this->template_resolver = $template_resolver;
	}

	/**
	 * @inheritdoc
	 */
	public function find_renderer($class)
	{
		if ($this instanceof $class)
		{
			return $this;
		}

		if ($this->template_resolver instanceof $class)
		{
			return $this->template_resolver;
		}

		if ($this->template_resolver instanceof TemplateResolverDecorator)
		{
			return $this->template_resolver->find_renderer($class);
		}

		return null;
	}
}
