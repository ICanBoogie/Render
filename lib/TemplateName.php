<?php

namespace ICanBoogie\Render;

use ICanBoogie\ActiveRecord\Query;

use function basename;
use function dirname;
use function in_array;
use function is_string;
use function substr;

/**
 * Representation of a template name.
 */
final class TemplateName
{
    public const string TEMPLATE_PREFIX_VIEW = '';
    public const string TEMPLATE_PREFIX_LAYOUT = '@';
    public const string TEMPLATE_PREFIX_PARTIAL = '_';
    public const string TEMPLATE_NAMESPACE_SEPARATOR = '/';

    /**
     * @var array<string, self>
     */
    private static array $instances = [];

    public static function from(mixed $source): self
    {
        if ($source instanceof self) {
            return $source;
        }

        if ($source instanceof Query) { // @phpstan-ignore-line
            $source = $source->model->id . self::TEMPLATE_NAMESPACE_SEPARATOR . 'list'; // @phpstan-ignore-line
        }

        assert(is_string($source));

        $source = self::normalize($source);

        if (isset(self::$instances[$source])) {
            return self::$instances[$source];
        }

        return self::$instances[$source] = new self($source);
    }

    /**
     * Normalizes a template name by removing any known prefix.
     */
    public static function normalize(string $name): string
    {
        $basename = basename($name);
        $dirname = $basename != $name ? dirname($name) : null;

        if (
            in_array(
                $basename[0],
                [ self::TEMPLATE_PREFIX_VIEW, self::TEMPLATE_PREFIX_LAYOUT, self::TEMPLATE_PREFIX_PARTIAL ]
            )
        ) {
            $basename = substr($basename, 1);
        }

        if ($dirname) {
            $basename = $dirname . self::TEMPLATE_NAMESPACE_SEPARATOR . $basename;
        }

        return $basename;
    }

    /**
     * Template name.
     */
    public string $as_template
    {
        get => $this->name;
    }

    /**
     * Partial template name.
     */
    public string $as_partial
    {
        get => $this->with_prefix(self::TEMPLATE_PREFIX_PARTIAL);
    }

    /**
     * Layout template name.
     */
    public string $as_layout
    {
        get => $this->with_prefix(self::TEMPLATE_PREFIX_LAYOUT);
    }

    /**
     * Returns the template name with the specified prefix.
     */
    public function with_prefix(string $prefix): string
    {
        $name = $this->name;

        if (!$prefix) {
            return $name;
        }

        $basename = basename($name);
        $dirname = $basename != $name ? dirname($name) : null;

        $name = $prefix . $basename;

        if ($dirname) {
            $name = $dirname . self::TEMPLATE_NAMESPACE_SEPARATOR . $name;
        }

        return $name;
    }

    private function __construct(
        private readonly string $name
    ) {
    }

    public function __toString()
    {
        return $this->name;
    }
}
