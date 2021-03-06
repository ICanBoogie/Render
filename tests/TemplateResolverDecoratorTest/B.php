<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Render\TemplateResolverDecoratorTest;

use ICanBoogie\Render\TemplateResolverDecorator;
use ICanBoogie\Render\TemplateResolverDecoratorTrait;

class B implements TemplateResolverDecorator
{
	use TemplateResolverDecoratorTrait;

	/**
	 * @inheritdoc
	 */
	public function resolve($name, array $extensions, &$tried = [ ])
	{
		return $this->template_resolver->resolve($name, $extensions, $tried);
	}
}
