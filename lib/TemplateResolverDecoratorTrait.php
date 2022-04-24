<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Render;

/**
 * An interface for template resolver decorators.
 *
 * @deprecated
 */
trait TemplateResolverDecoratorTrait
{
    public function __construct(
        private TemplateResolver $template_resolver
    ) {
    }

    /**
     * Clones {@link $template_resolver}.
     */
    public function __clone()
    {
        $this->template_resolver = clone $this->template_resolver;
    }

    /**
     * Forwards unsupported calls to the decorated template resolver.
     */
    public function __call(string $method, array $arguments)
    {
        return $this->template_resolver->$method(...$arguments);
    }

    /**
     * @inheritdoc
     */
    public function find_renderer(string $class): ?TemplateResolver
    {
        if ($this instanceof $class) {
            return $this;
        }

        if ($this->template_resolver instanceof $class) {
            return $this->template_resolver;
        }

        if ($this->template_resolver instanceof TemplateResolverDecorator) {
            return $this->template_resolver->find_renderer($class);
        }

        return null;
    }
}
