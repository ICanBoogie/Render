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
use ICanBoogie\Render\ExtensionResolver;
use IteratorAggregate;
use Psr\Container\ContainerInterface;
use Traversable;

/**
 * An engine provider that uses a container.
 *
 * @implements IteratorAggregate<string, Engine>
 *     Where _key_ is a file extension.
 */
final class Container implements EngineProvider, IteratorAggregate
{
    /**
     * @param array<string, string> $mapping
     *     Where _key_ is a file extension and _value_ a service identifier.
     */
    public function __construct(
        private readonly ContainerInterface $container,
        private readonly array $mapping
    ) {
    }

    public function engine_for_extension(string $extension): ?Engine
    {
        ExtensionResolver::assert_extension($extension);

        $id = $this->mapping[$extension] ?? null;

        if (!$id) {
            return null;
        }

        return $this->container->get($id); // @phpstan-ignore-line
    }

    public function getIterator(): Traversable
    {
        foreach ($this->mapping as $extension => $id) {
            yield $extension => $this->makeProxy($id);
        }
    }

    public function makeProxy(string $id): Engine
    {
        return new class ($id, $this->container) implements Engine {
            public function __construct(
                private readonly string $id,
                private readonly ContainerInterface $container
            ) {
            }

            public function render(
                string $template_pathname,
                mixed $content,
                array $variables
            ): string {
                return $this->container->get($this->id)->render( // @phpstan-ignore-line
                    $template_pathname,
                    $content,
                    $variables
                );
            }
        };
    }
}
