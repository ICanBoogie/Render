<?php

namespace ICanBoogie\Render;

use function basename;
use function dirname;
use function in_array;
use function strlen;
use function substr;

/**
 * Support functions for template resolvers.
 */
trait TemplateResolverTrait
{
    use ResolvePathTrait;

    /**
     * Resolves the path tries.
     *
     * The method resolves a try path collection from a collection of roots, template name, and
     * extension collection.
     *
     * @param string[] $paths Template directories paths.
     * @param string $name Template name.
     * @param string[] $extensions Supported extensions.
     *
     * @return string[] A collection of candidate template path names.
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
}
