<?php

namespace ICanBoogie\Render;

final class RenderOptions
{
    /**
     * @param array<string, mixed> $locals
     */
    public function __construct(
        public readonly ?string $template = null,
        public readonly ?string $partial = null,
        public readonly ?string $layout = null,
        public readonly array $locals = [],
    ) {
    }
}
