<?php

namespace ICanBoogie\Render;

use ICanBoogie\ActiveRecord\Query;

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
			$template = '_' . $options['partial']; // TODO: articles/_partial
			$template_pathname = $this->template_resolver->resolve($template, $this->engines);

			if (!$template_pathname)
			{
				$type_name = 'partial';
				$tries = implode("\n", array_map(function($v) { return "- $v"; }, $this->template_resolver->tries));

				throw new TemplateNotFound("There is no $type_name matching <q>$template</q>, tried the following files:\n\n" . $tries);
			}

			return $this->engines->render($template_pathname, null, $options['locals']);
		}

		$template = $options['template'];
		$template_pathname = $this->template_resolver->resolve($template, $this->engines);

		if (!$template_pathname)
		{
			$type_name = 'template';
			$tries = implode("\n", array_map(function($v) { return "- $v"; }, $this->template_resolver->tries));

			throw new TemplateNotFound("There is no $type_name matching <q>$template</q>, tried the following files:\n\n" . $tries);
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
			$additional_options['template'] = $this->resolve_template($target_or_options);

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
		if ($content instanceof Query)
		{
			return $content->model->id . '/index';
		}

		var_dump($content); exit;
	}
}
