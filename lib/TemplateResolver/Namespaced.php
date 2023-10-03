<?php

namespace ICanBoogie\Render\TemplateResolver;

use ICanBoogie\Render\ResolvePathTrait;
use ICanBoogie\Render\TemplateName;
use ICanBoogie\Render\TemplateResolver;

use function array_map;
use function explode;
use function rtrim;
use function var_dump;

use const DIRECTORY_SEPARATOR;

final class Namespaced implements TemplateResolver
{
    use ResolvePathTrait;

    /**
     * @var array<string, string> $namespaces
     *     Where _key_ is a namespace e.g. 'articles' and _value_ a directory.
     */
    private readonly array $namespaces;

    /**
     * @param array<string, string> $namespaces
     *     Where _key_ is a namespace e.g. 'articles' and _value_ a directory.
     */
    public function __construct(array $namespaces)
    {
        $this->namespaces = array_map(
            fn(string $path) => rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR,
            $namespaces
        );
    }

    public function resolve(string $name, array $extensions, array &$tried = []): ?string
    {
        [ $namespace, $name ] = explode(TemplateName::TEMPLATE_NAMESPACE_SEPARATOR, $name);

        $base = $this->namespaces[$namespace] ?? null;

        if (!$base) {
            return null;
        }

        $tries = $this->resolve_tries($base, $name, $extensions);

        return $this->resolve_path($tries, $tried);
    }

    /**
     * @param string[] $extensions
     *
     * @return string[]
     */
    private function resolve_tries(string $base, string $name, array $extensions): array
    {
        $paths = [];

        foreach ($extensions as $extension) {
            $paths[] = $base . $name . $extension;
        }

        return $paths;
    }
}
