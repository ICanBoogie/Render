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
 * An optional interface for template engines.
 */
interface Engine
{
    /**
     * The pathname of the template being rendered.
     */
    public const VAR_TEMPLATE_PATHNAME = '__TEMPLATE_PATHNAME__';

    /**
     * Renders a template.
     *
     * **Note**: Template engines implementing this interface are expected to add
     * {@link VAR_TEMPLATE_PATHNAME} to the variables, so that the template being rendered can be
     * tracked easily.
     *
     * @param string $template_pathname Pathname to the template to render.
     * @param mixed $content The content to render.
     * @param array<string, mixed> $variables Variable to render the template with.
     */
    public function render(string $template_pathname, mixed $content, array $variables): string;
}
