<?php

namespace ICanBoogie\Render\EngineProvider;

use ICanBoogie\Render\Engine;
use ICanBoogie\Render\EngineProvider;
use IteratorAggregate;
use Traversable;

/**
 * An immutable engine provider.
 *
 * @implements IteratorAggregate<string, Engine>
 *     Where _key_ is a file extension.
 */
final readonly class Immutable implements EngineProvider, IteratorAggregate
{
    private Mutable $mutable;

    /**
     * @param array<string, Engine> $engines
     *     Where _key_ is an extension; for example, ".php" and _value_ is an Engine.
     */
    public function __construct(array $engines = [])
    {
        $this->mutable = new Mutable();

        foreach ($engines as $extension => $engine) {
            $this->mutable->add_engine($extension, $engine);
        }
    }

    public function engine_for_extension(string $extension): ?Engine
    {
        return $this->mutable->engine_for_extension($extension);
    }

    public function getIterator(): Traversable
    {
        return $this->mutable->getIterator();
    }
}
