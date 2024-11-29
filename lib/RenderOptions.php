<?php

namespace ICanBoogie\Render;

final readonly class RenderOptions
{
    /**
     * @param array<string, mixed> $locals
     */
    public function __construct(
        public ?string $template = null,
        public ?string $partial = null,
        public ?string $layout = null,
        public array $locals = [],
    ) {
    }
}
