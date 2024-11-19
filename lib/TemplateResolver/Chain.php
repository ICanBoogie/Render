<?php

namespace ICanBoogie\Render\TemplateResolver;

use ICanBoogie\Render\TemplateResolver;

final readonly class Chain implements TemplateResolver
{
    /**
     * @param iterable<TemplateResolver> $chain
     */
    public function __construct(
        private iterable $chain
    ) {
    }

    public function resolve(string $name, array $extensions, array &$tried = []): ?string
    {
        foreach ($this->chain as $resolver) {
            $path = $resolver->resolve($name, $extensions, $tried);

            if ($path) {
                return $path;
            }
        }

        return null;
    }
}
