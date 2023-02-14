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

use function assert;
use function is_string;
use function iterator_to_array;

/**
 * Renders a target or an array of options.
 */
class Renderer
{
    public const VARIABLE_CONTENT = 'content';

    /**
     * @var string[]
     */
    private readonly array $extensions;

    public function __construct(
        public readonly TemplateResolver $template_resolver,
        private readonly EngineProvider $engines
    ) {
        $this->extensions = array_keys(iterator_to_array($this->engines));
    }

    /**
     * Resolve a template pathname from its name and type.
     *
     * @return string Template pathname.
     *
     * @throws TemplateNotFound if the template pathname cannot be resolved.
     */
    public function resolve_template(string $name): string
    {
        $tried = [];
        $template_pathname = $this->template_resolver->resolve($name, $this->extensions, $tried);

        if (!$template_pathname) {
            throw new TemplateNotFound("There is no template matching `$name`.", $tried);
        }

        return $template_pathname;
    }

    /**
     * Renders a content.
     */
    public function render(mixed $content, RenderOptions $options = new RenderOptions()): string
    {
        $variables = $options->locals;

        if ($options->partial) {
            $content = $this->render_partial($options->partial, $content, $variables);
        }

        if ($options->template) {
            $content = $this->render_template($options->template, $content, $variables);
        }

        if ($options->layout) {
            $content = $this->render_layout($options->layout, [ self::VARIABLE_CONTENT => $content ] + $variables);
        }

        if ($content === null) {
            return '';
        }

        return $content;
    }

    /**
     * @param array<string, mixed> $variables
     */
    private function render_partial(string $template, mixed $content, array $variables): string
    {
        return $this->render_template(
            $this->resolve_template_name($template)->as_partial,
            $content,
            $variables
        );
    }

    /**
     * @param array<string, mixed> $variables
     */
    private function render_layout(string $template, array $variables): string
    {
        return $this->render_template(
            $this->resolve_template_name($template)->as_layout,
            null,
            $variables
        );
    }

    /**
     * @param array<string, mixed> $variables
     */
    private function render_template(string $name, mixed $content, array $variables): string
    {
        $template_pathname = $this->resolve_template($name);
        $extension = ExtensionResolver::resolve($template_pathname);

        assert(is_string($extension));

        $engine = $this->engines->engine_for_extension($extension)
            ?? throw new EngineNotAvailable("There is no engine available to render template `$template_pathname`.");

        return $engine->render($template_pathname, $content, $variables);
    }

    protected function resolve_template_name(mixed $content): TemplateName
    {
        return TemplateName::from($content);
    }
}
