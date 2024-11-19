<?php

namespace ICanBoogie\Render;

use LogicException;
use Throwable;

use function array_map;
use function implode;

/**
 * Exception throw when a template can't be found.
 */
class TemplateNotFound extends LogicException implements Exception
{
    /**
     * @param string[] $tried Tried path names.
     */
    public function __construct(
        string $message,
        public readonly array $tried,
        ?Throwable $exception = null
    ) {
        if ($tried) {
            $tried = implode("\n", array_map(fn($v) => "- $v", $tried));
            $message .= " The following files were tried:\n\n" . $tried;
        } else {
            $message .= " Also, no possible files were specified.";
        }

        parent::__construct($message, 0, $exception);
    }
}
