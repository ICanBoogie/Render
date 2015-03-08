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

use ICanBoogie\ActiveRecord\Query;

class Renderer
{
	/**
	 * @var BasicTemplateResolver
	 */
	private $original_template_resolver;

	/**
	 * @var EngineCollection
	 */
	private $engines;

	/**
	 * @var BasicTemplateResolver
	 */
	protected $template_resolver;

	public function __construct(TemplateResolver $template_resolver, EngineCollection $engines)
	{
		$this->original_template_resolver = $template_resolver;
		$this->engines = $engines;
	}

	public function render($target_or_options, array $additional_options=[])
	{
		$this->template_resolver = clone $this->original_template_resolver;
		$options = $this->resolve_options($target_or_options, $additional_options);

		if (isset($options['partial']))
		{
			$tried = [];
			$template = TemplateName::from($options['partial'])->as_partial;
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

		return $this->engines->render($template_pathname, $options['content'], $options['locals']);
	}

	protected function resolve_options($target_or_options, array $additional_options=[])
	{
		$options = [];

		if (is_object($target_or_options))
		{
			$additional_options['content'] = $target_or_options;
			$additional_options['locals']['this'] = $target_or_options;
			$additional_options['partial'] = $this->resolve_template($target_or_options);

			if ($target_or_options instanceof Query)
			{
				$model_id = $target_or_options->model->id;
				$module_path = \ICanBoogie\app()->modules[$model_id]->path;
				$this->template_resolver->add_path($module_path . 'templates');
			}
		}
		else if (is_array($target_or_options))
		{
			$options = $target_or_options;
		}

		return $additional_options + $options;
	}

	protected function resolve_template($content)
	{
		return TemplateName::from($content);
	}
}
