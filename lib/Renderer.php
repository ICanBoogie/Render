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
 * Renders a target or an array of options.
 */
class Renderer
{
	const OPTION_LAYOUT = 'layout';
	const OPTION_PARTIAL = 'partial';
	const OPTION_TEMPLATE = 'template';
	const OPTION_CONTENT = 'content';
	const OPTION_LOCALS = 'locals';

	/**
	 * @var TemplateResolver
	 */
	private $original_template_resolver;

	/**
	 * @var EngineCollection
	 */
	private $engines;

	/**
	 * @var TemplateResolver
	 */
	protected $template_resolver;

	/**
	 * Initializes the {@link $template_resolver} and {@link $engines} properties.
	 *
	 * @param TemplateResolver $template_resolver
	 * @param EngineCollection $engines
	 */
	public function __construct(TemplateResolver $template_resolver, EngineCollection $engines)
	{
		$this->original_template_resolver = $template_resolver;
		$this->engines = $engines;
	}

	/**
	 * Renders a target or options.
	 *
	 * @param mixed $target_or_options The target or options to render.
	 * @param array $additional_options Additional render options.
	 *
	 * @return string
	 */
	public function render($target_or_options, array $additional_options = [])
	{
		if (!$target_or_options)
		{
			return null;
		}

		$options = $this->resolve_options($target_or_options, $additional_options);
		$content = $options[self::OPTION_CONTENT];
		$variables = $options[self::OPTION_LOCALS];

		$this->template_resolver = clone $this->original_template_resolver;

		#

		$template = $options[self::OPTION_PARTIAL];

		if ($template)
		{
			$content = $this->render_partial($template, $variables);
		}

		$template = $options[self::OPTION_TEMPLATE];

		if ($template)
		{
			$content = $this->render_template($template, 'template', $content, $variables);
		}

		$template = $options[self::OPTION_LAYOUT];

		if ($template)
		{
			$content = $this->render_layout($template, [ self::OPTION_CONTENT => $content ] + $variables);
		}

		return $content;
	}

	/**
	 * Renders partial.
	 *
	 * @param string $template
	 * @param array $variables
	 *
	 * @return string
	 */
	protected function render_partial($template, $variables)
	{
		$template = $this->resolve_template_name($template)->as_partial;

		return $this->render_template($template, 'partial', null, $variables);
	}

	/**
	 * Renders layout.
	 *
	 * @param string $template
	 * @param array $variables
	 *
	 * @return string
	 */
	protected function render_layout($template, array $variables)
	{
		$template = $this->resolve_template_name($template)->as_layout;

		return $this->render_template($template, 'layout', null, $variables);
	}

	/**
	 * Renders template.
	 *
	 * @param string $template
	 * @param string $type
	 * @param string $content
	 * @param array $variables
	 *
	 * @return string
	 */
	protected function render_template($template, $type, $content, $variables)
	{
		$template_pathname = $this->resolve_template_pathname($template, $type);

		return $this->engines->render($template_pathname, $content, $variables);
	}

	/**
	 * Resolves rendering options.
	 *
	 * @param mixed $target_or_options
	 * @param array $additional_options
	 *
	 * @return array
	 *
	 * @throws InvalidRenderTarget if rendering target is invalid.
	 */
	protected function resolve_options($target_or_options, array $additional_options = [])
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

	/**
	 * Resolves template name.
	 *
	 * @param mixed $content
	 *
	 * @return TemplateName
	 */
	protected function resolve_template_name($content)
	{
		return TemplateName::from($content);
	}

	/**
	 * @param string $template
	 * @param string $type One of "template", "partial", "layout".
	 *
	 * @return string Template pathname.
	 *
	 * @throws TemplateNotFound if the template pathname cannot be resolved.
	 */
	protected function resolve_template_pathname($template, $type)
	{
		$template_pathname = $this->template_resolver->resolve($template, $this->engines->extensions, $tried);

		if (!$template_pathname)
		{
			throw new TemplateNotFound("There is no $type matching `$template`.", $tried);
		}

		return $template_pathname;
	}
}
