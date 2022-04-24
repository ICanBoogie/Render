<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
final class Immutable implements EngineProvider, IteratorAggregate
{
    private readonly Mutable $mutable;

    /**
     * @param array<string, Engine> $engines
     *     Where _key_ is an extension e.g. ".php" and _value_ is an Engine.
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
