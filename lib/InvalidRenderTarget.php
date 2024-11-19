<?php

namespace ICanBoogie\Render;

use InvalidArgumentException;
use Throwable;

use function get_debug_type;

/**
 * Exception thrown when the target to render is invalid.
 */
class InvalidRenderTarget extends InvalidArgumentException implements Exception
{
    public function __construct(
        public readonly mixed $target,
        ?string $message = null,
        ?Throwable $previous = null
    ) {
        parent::__construct($message ?? $this->format_message($target), previous: $previous);
    }

    private function format_message(mixed $target): string
    {
        $type = get_debug_type($target);

        return "Invalid render target. Expected object or array, got: $type";
    }
}
