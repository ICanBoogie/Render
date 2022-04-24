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

use ArrayIterator;
use ICanBoogie\Render\Engine;
use ICanBoogie\Render\ExtensionResolver;
use ICanBoogie\Render\MutableEngineProvider;
use IteratorAggregate;
use Traversable;

/**
 * A mutable engine provider.
 *
 * @implements IteratorAggregate<string, Engine>
 *     Where _key_ is a file extension.
 */
final class Mutable implements MutableEngineProvider, IteratorAggregate
{
    /**
     * @var array<string, Engine>
     *     Where _key_ is an extension e.g. ".php" and _value_ is an Engine.
     */
    private array $engines = [];

    public function engine_for_extension(string $extension): ?Engine
    {
        ExtensionResolver::assert_extension($extension);

        return $this->engines[$extension] ?? null;
    }

    public function add_engine(string $extension, Engine $engine): void
    {
        ExtensionResolver::assert_extension($extension);

        $this->engines[$extension] = $engine;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->engines);
    }
}
