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

use function is_array;
use function is_object;

/**
 * Renders a target or an array of options.
 */
class Renderer
{
	public const OPTION_LAYOUT = 'layout';
	public const OPTION_PARTIAL = 'partial';
	public const OPTION_TEMPLATE = 'template';
	public const OPTION_CONTENT = 'content';
	public const OPTION_LOCALS = 'locals';

	/**
	 * @var EngineCollection
	 */
	private $engines;

	/**
	 * @var TemplateResolver
	 */
	protected $template_resolver;

	public function __construct(TemplateResolver $template_resolver, EngineCollection $engines)
	{
		$this->template_resolver = $template_resolver;
		$this->engines = $engines;
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
		$template_pathname = $this->template_resolver->resolve($name, $this->engines->extensions, $tried);

		if (!$template_pathname)
		{
			throw new TemplateNotFound("There is no template matching `$name`.", $tried);
		}

		return $template_pathname;
	}

	/**
	 * Renders a target or options.
	 *
	 * @param mixed $target_or_options The target or options to render.
	 * @param array $additional_options Additional render options.
	 */
	public function render($target_or_options, array $additional_options = []): ?string
	{
		if (!$target_or_options && !$additional_options)
		{
			return null;
		}

		$options = $this->resolve_options($target_or_options, $additional_options);
		$content = $options[self::OPTION_CONTENT];
		$variables = $options[self::OPTION_LOCALS];

		#

		$template = $options[self::OPTION_PARTIAL];

		if ($template)
		{
			$content = $this->render_partial($template, $content, $variables);
		}

		$template = $options[self::OPTION_TEMPLATE];

		if ($template)
		{
			$content = $this->render_template($template, $content, $variables);
		}

		$template = $options[self::OPTION_LAYOUT];

		if ($template)
		{
			$content = $this->render_layout($template, [ self::OPTION_CONTENT => $content ] + $variables);
		}

		return $content;
	}

	/**
	 * @param mixed $content
	 */
	private function render_partial(string $template, $content, array $variables): string
	{
		return $this->render_template(
			$this->resolve_template_name($template)->as_partial,
			$content,
			$variables
		);
	}

	private function render_layout(string $template, array $variables): string
	{
		return $this->render_template(
			$this->resolve_template_name($template)->as_layout,
			null,
			$variables
		);
	}

	/**
	 * @param mixed $content
	 */
	private function render_template(string $name, $content, array $variables): string
	{
		return $this->engines->render(
			$this->resolve_template($name),
			$content,
			$variables
		);
	}

	/**
	 * @param mixed $content
	 */
	protected function resolve_template_name($content): TemplateName
	{
		return TemplateName::from($content);
	}

	/**
	 * @param mixed $target_or_options
	 *
	 * @throws InvalidRenderTarget if rendering target is invalid.
	 */
	private function resolve_options($target_or_options, array $additional_options = []): array
	{
		$options = [];

		if (is_object($target_or_options))
		{
			$additional_options[self::OPTION_CONTENT] = $target_or_options;
			$additional_options[self::OPTION_LOCALS]['this'] = $target_or_options;

			if (empty($additional_options[self::OPTION_PARTIAL]) && empty($additional_options[self::OPTION_TEMPLATE]))
			{
				$additional_options[self::OPTION_PARTIAL] = $this->resolve_template_name($target_or_options);
			}
		}
		else if (is_array($target_or_options))
		{
			$options = $target_or_options;
		}
		else
		{
			throw new InvalidRenderTarget($target_or_options);
		}

		return $additional_options + $options + [

			self::OPTION_CONTENT => null,
			self::OPTION_PARTIAL => null,
			self::OPTION_TEMPLATE => null,
			self::OPTION_LAYOUT => null,
			self::OPTION_LOCALS => []

		];
	}
}
