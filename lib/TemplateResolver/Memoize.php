<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Render\TemplateResolver;

use ICanBoogie\Render\TemplateResolver;

use function implode;

/**
 * Memoize the results of the inner {@link TemplateResolver}.
 */
final class Memoize implements TemplateResolver
{
    /**
     * @var array<string, string|null>
     */
    private array $cache = [];

    public function __construct(
        private readonly TemplateResolver $inner
    ) {
    }

    public function resolve(string $name, array $extensions, array &$tried = []): ?string
    {
        $key = $name . ' # ' . implode(' ', $extensions);

        return $this->cache[$key] ??= $this->inner->resolve($name, $extensions, $tried);
    }
}
