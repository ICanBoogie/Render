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
 * An interface for template resolvers.
 */
interface TemplateResolver
{
	/**
	 * Returns the pathname to the matching template.
	 *
	 * @param string $name The base name of the template.
	 * @param array $extensions The supported extensions.
	 * @param array $tried Tried pathname collection.
	 *
	 * @return string|null The pathname to the matching template or `null` if none match.
	 */
	public function resolve(string $name, array $extensions, array &$tried = []): ?string;
}
