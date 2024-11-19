<?php

namespace ICanBoogie\Render\EngineProvider;

use Closure;
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
final readonly class Container implements EngineProvider, IteratorAggregate
{
    /**
     * @param array<string, string> $mapping
     *     Where _key_ is a file extension and _value_ a service identifier.
     */
    public function __construct(
        private ContainerInterface $container,
        private array $mapping
    ) {
    }

    public function engine_for_extension(string $extension): ?Engine
    {
        ExtensionResolver::assert_extension($extension);

        $id = $this->mapping[$extension] ?? null;

        if (!$id) {
            return null;
        }

        /** @var Engine */
        return $this->container->get($id);
    }

    public function getIterator(): Traversable
    {
        foreach ($this->mapping as $extension => $id) {
            yield $extension => $this->makeProxy($id);
        }
    }

    public function makeProxy(string $id): Engine
    {
        return new class ($id, $this->container->get(...)) implements Engine {
            public function __construct(
                private readonly string $id,
                private readonly Closure $get,
            ) {
            }

            public function render(
                string $template_pathname,
                mixed $content,
                array $variables
            ): string {
                return ($this->get)($this->id)->render(
                    $template_pathname,
                    $content,
                    $variables
                );
            }
        };
    }
}
