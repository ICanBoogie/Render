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

use ArrayObject;
use InvalidArgumentException;
use Stringable;
use Throwable;

use function extract;
use function get_debug_type;
use function is_array;
use function is_object;
use function is_string;
use function ob_end_clean;
use function ob_get_clean;
use function ob_start;

/**
 * Renders PHP templates.
 */
final class PHPEngine implements Engine
{
    private const FORBIDDEN_VAR_THIS = 'this';

    /**
     * @throws Throwable
     */
    public function render(string $template_pathname, mixed $content, array $variables): string
    {
        if (isset($variables[self::FORBIDDEN_VAR_THIS])) {
            throw new InvalidArgumentException("The usage of 'this' is forbidden in variables.");
        }

        $f = function ($__TEMPLATE_PATHNAME__, $__VARIABLES__) {
            extract($__VARIABLES__);

            require $__TEMPLATE_PATHNAME__;
        };

        if ($content) {
            $f = $f->bindTo($this->ensure_is_object($content));
        }

        ob_start();

        try {
            $f($template_pathname, [ self::VAR_TEMPLATE_PATHNAME => $template_pathname ] + $variables);

            return ob_get_clean() ?: "";
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }
    }

    /**
     * Ensures that a value is an object.
     *
     * - `value` is an object, value is returned.
     * - `value` is an array, an `ArrayObject` instance is returned.
     * - Otherwise `value` is cast into a string and a {@link String} instance is returned.
     */
    private function ensure_is_object(mixed $value): object
    {
        if (is_object($value)) {
            return $value;
        }

        if (is_array($value)) {
            return new ArrayObject($value);
        }

        if (is_string($value)) {
            return new class ($value) implements Stringable {
                public function __construct(
                    private readonly string $value
                ) {
                }

                public function __toString(): string
                {
                    return $this->value;
                }
            };
        }

        throw new InvalidArgumentException("Don't know what to do with: " . get_debug_type($value) . ".");
    }
}
