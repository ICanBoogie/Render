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

use function basename;
use function dirname;
use function file_exists;
use function in_array;
use function strlen;
use function substr;

/**
 * Support functions for template resolvers.
 */
trait TemplateResolverTrait
{
    /**
     * Resolves path tries.
     *
     * The method resolves a try path collection from a collection of roots, template name, and
     * extension collection.
     *
     * @param string[] $paths Template directories paths.
     * @param string $name Template name.
     * @param string[] $extensions Supported extensions.
     *
     * @return string[] A collection of candidate template pathnames.
     */
    protected function resolve_tries(array $paths, string $name, array $extensions): array
    {
        $extension = ExtensionResolver::resolve($name);

        if ($extension && in_array($extension, $extensions)) {
            $name = substr($name, 0, -strlen($extension));
        }

        $tries = [];
        $dirname = dirname($name);
        $basename = basename($name);

        foreach ($paths as $path) {
            $parent_dir = basename(dirname($path));

            foreach ($extensions as $extension) {
                $filename = $name;

                if ($dirname && $dirname == $parent_dir) {
                    $filename = $basename;
                }

                $filename = $filename . $extension;
                $pathname = $path . $filename;

                $tries[] = $pathname;
            }
        }

        return $tries;
    }

    /**
     * Resolves a template path.
     *
     * The method returns the pathname of the first file matching the path collection. The tried
     * paths are collected in `$tried`.
     *
     * @param string[] $tries Pathname collection, as returned by {@link resolve_tries()}.
     * @param string[] $tried Tried pathname collection.
     */
    protected function resolve_path(array $tries, array &$tried): ?string
    {
        foreach ($tries as $pathname) {
            $tried[] = $pathname;

            if (file_exists($pathname)) {
                return $pathname;
            }
        }

        return null;
    }
}
