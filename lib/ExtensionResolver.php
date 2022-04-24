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

use LogicException;

use function pathinfo;

use const PATHINFO_EXTENSION;

final class ExtensionResolver
{
    public const EXTENSION_DOT = '.';

    public static function resolve(string $pathname): ?string
    {
        $extension = pathinfo($pathname, PATHINFO_EXTENSION);

        if (!$extension) {
            return null;
        }

        return self::EXTENSION_DOT . $extension;
    }

    public static function assert_extension(string $extension): void
    {
        if ($extension[0] !== self::EXTENSION_DOT) {
            throw new LogicException("Extension must start with a dot: $extension.");
        }
    }
}
