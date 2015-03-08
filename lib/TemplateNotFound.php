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

use ICanBoogie\Accessor\AccessorTrait;

/**
 * Exception throw when a template cannot be found.
 *
 * @package ICanBoogie\Render
 *
 * @property-read array $tried Tried pathname collection.
 */
class TemplateNotFound extends \LogicException implements Exception
{
    use AccessorTrait;

    private $tried;

    protected function get_tried()
    {
        return $this->tried;
    }

    public function __construct($message, array $tried, $code = 404, \Exception $exception = null)
    {
        $this->tried = $tried;

        if ($tried)
        {
            $tried = implode("\n", array_map(function ($v) { return "- $v"; }, $tried));
            $message .= " The following files were tried:\n\n" . $tried;
        }

        parent::__construct($message, $code, $exception);
    }
}
