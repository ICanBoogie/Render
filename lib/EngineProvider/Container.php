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

final class Container implements EngineProvider, IteratorAggregate
{
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
		return new class($id, $this->container) implements Engine {
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
				return $this->container->get($this->id)->render(
					$template_pathname,
					$content,
					$variables
				);
			}
		};
	}
}
