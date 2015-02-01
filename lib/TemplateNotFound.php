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
 * @property-read array $tries The files that were tried.
 */
class TemplateNotFound extends \LogicException implements Exception
{
    use AccessorTrait;

    private $tries;

    protected function get_tries()
    {
        return $this->tries;
    }

    public function __construct($message, array $tries, $code = 404, \Exception $exception = null)
    {
        $this->tries = $tries;

        if ($tries)
        {
            $tries = implode("\n", array_map(function ($v) { return "- $v"; }, $tries));
            $message .= " The following files were tried:\n\n" . $tries;
        }

        parent::__construct($message, $code, $exception);
    }
}
