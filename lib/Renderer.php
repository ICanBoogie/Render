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
		$this->template_resolver = clone $this->original_template_resolver;
		$options = $this->resolve_options($target_or_options, $additional_options);

		if (isset($options['partial']))
		{
			$tried = [];
			$template = $this->resolve_template_name($options['partial'])->as_partial;
			$template_pathname = $this->template_resolver->resolve($template, $this->engines->extensions, $tried);

			if (!$template_pathname)
			{
				throw new TemplateNotFound("There is no partial matching <q>$template</q>.", $tried);
			}

			return $this->engines->render($template_pathname, null, $options['locals']);
		}

		$tried = [];
		$template = $options['template'];
		$template_pathname = $this->template_resolver->resolve($template, $this->engines->extensions, $tried);

		if (!$template_pathname)
		{
			throw new TemplateNotFound("There is no template matching <q>$template</q>.", $tried);
		}

		$rc = $this->engines->render($template_pathname, $options['content'], $options['locals']);

		if (isset($options['layout']))
		{
			$template = $this->resolve_template_name($options['layout'])->as_layout;
			$template_pathname = $this->template_resolver->resolve($template, $this->engines->extensions, $tried);

			if (!$template_pathname)
			{
				throw new TemplateNotFound("There is no partial matching <q>$template</q>.", $tried);
			}

			$rc = $this->engines->render($template_pathname, null, [ 'content' => $rc ] + $options['locals']);
		}

		return $rc;
	}

	/**
	 * Resolves rendering options.
	 *
	 * @param mixed $target_or_options
	 * @param array $additional_options
	 *
	 * @return array
	 */
	protected function resolve_options($target_or_options, array $additional_options = [])
	{
		$options = [];

		if (is_object($target_or_options))
		{
			$additional_options['content'] = $target_or_options;
			$additional_options['locals']['this'] = $target_or_options;

			if (empty($additional_options['partial']) && empty($additional_options['template']))
			{
				$additional_options['partial'] = $this->resolve_template_name($target_or_options);
			}
		}
		else if (is_array($target_or_options))
		{
			$options = $target_or_options;
		}

		return $additional_options + $options;
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
}
