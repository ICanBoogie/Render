<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Test\ICanBoogie\Render\TemplateResolverDecoratorTest;

use ICanBoogie\Render\TemplateResolver;
use ICanBoogie\Render\TemplateResolverTrait;

class C implements TemplateResolver
{
	use TemplateResolverTrait;

	/**
	 * @inheritdoc
	 */
	public function resolve($name, array $extensions, &$tried = [ ]): ?string
    {
		return "$name.html";
	}
}
