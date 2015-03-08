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
 *
 * @return EngineCollection
 */
function get_engines()
{
    static $engines;

    if (!$engines)
    {
        $engines = new EngineCollection([

            '.php' => 'ICanBoogie\Render\PHPEngine'

        ]);

        new EngineCollection\AlterEvent($engines);
    }

    return $engines;
}

/**
 * Returns a shared template resolver.
 *
 * @return BasicTemplateResolver
 */
function get_template_resolver()
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
 *
 * @return Renderer
 */
function get_renderer()
{
    static $renderer;

    if (!$renderer)
    {
        $renderer = new Renderer(get_template_resolver(), get_engines());

        new Renderer\AlterEvent($renderer);
    }

    return $renderer;
}
