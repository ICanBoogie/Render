<?php

namespace ICanBoogie\Render;

use Traversable;

/**
 * @template-extends Traversable<string, Engine>
 *     Where _key_ is an extension; for example, "php" and _value_ is an Engine.
 */
interface EngineProvider extends Traversable
{
    /**
     * Provides an engine for a given file extension.
     *
     * @param string $extension A file extension; for example, "php".
     */
    public function engine_for_extension(string $extension): ?Engine;
}
