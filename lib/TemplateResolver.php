<?php

namespace ICanBoogie\Render;

/**
 * An interface for template resolvers.
 */
interface TemplateResolver
{
    /**
     * Returns the pathname to the matching template.
     *
     * @param string $name The base name of the template.
     * @param string[] $extensions The supported extensions.
     * @param string[] $tried Tried path names.
     *
     * @return string|null The pathname to the matching template or `null` if none match.
     */
    public function resolve(string $name, array $extensions, array &$tried = []): ?string;
}
