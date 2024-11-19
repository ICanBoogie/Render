<?php

namespace ICanBoogie\Render;

/**
 * A mutable engine provider.
 */
interface MutableEngineProvider extends EngineProvider
{
    /**
     * Adds an engine for an extension.
     */
    public function add_engine(string $extension, Engine $engine): void;
}
