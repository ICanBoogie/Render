<?php

namespace ICanBoogie\Render;

use function file_exists;

trait ResolvePathTrait
{
    /**
     * Resolves a template path.
     *
     * The method returns the pathname of the first file matching the path collection. The tried
     * paths are collected in `$tried`.
     *
     * @param string[] $tries Pathname collection, as returned by {@see resolve_tries()}.
     * @param string[] $tried Tried path names.
     */
    private function resolve_path(array $tries, array &$tried): ?string
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
