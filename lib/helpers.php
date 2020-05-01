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
 * Returns a shared engine collection.
 */
function get_engines(): EngineCollection
{
    static $engines;

    if (!$engines)
    {
        $engines = new EngineCollection([

            '.phtml' => PHPEngine::class

        ]);

        new EngineCollection\AlterEvent($engines);
    }

    return $engines;
}

/**
 * Returns a shared template resolver.
 */
function get_template_resolver(): TemplateResolver
{
    static $template_resolver;

    if (!$template_resolver)
    {
        $template_resolver = new BasicTemplateResolver;

        new TemplateResolver\AlterEvent($template_resolver);
    }

    return $template_resolver;
}

/**
 * Returns a shared renderer.
 *
 * The renderer is created with the shared template resolver and the shared engine collection
 * respectively provided by the {@link get_template_resolver()} and {@link get_engines()}
 * functions.
 */
function get_renderer(): Renderer
{
    static $renderer;

    if (!$renderer)
    {
        $renderer = new Renderer(get_template_resolver(), get_engines());

        new Renderer\AlterEvent($renderer);
    }

    return $renderer;
}

/**
 * Renders a target or options using the default renderer.
 *
 * @param mixed $target_or_options The target or options to render.
 * @param array $additional_options Additional render options.
 */
function render($target_or_options, array $additional_options = []): string
{
    return get_renderer()->render($target_or_options, $additional_options);
}
