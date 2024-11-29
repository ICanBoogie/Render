<?php

namespace ICanBoogie\Render;

use LogicException;

use function pathinfo;

use const PATHINFO_EXTENSION;

final class ExtensionResolver
{
    public const string EXTENSION_DOT = '.';

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
