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
 *
 * @deprecated
 */
interface TemplateResolverDecorator extends TemplateResolver
{
	/**
	 * Finds decorated template resolver.
	 *
	 * @param string $class Class of the decorated resolver to find.
	 */
	public function find_renderer(string $class): ?TemplateResolver;
}
