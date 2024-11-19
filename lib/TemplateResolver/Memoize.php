<?php

namespace ICanBoogie\Render\TemplateResolver;

use ICanBoogie\Render\TemplateResolver;

use function implode;

/**
 * Memoize the results of the inner {@see TemplateResolver}.
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
