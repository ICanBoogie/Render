<?php

namespace ICanBoogie\Render;

use Throwable;

/**
 * Render exceptions implement this interface so that they can be easily recognized.
 *
 * <pre>
 * try
 * {
 *     // …
 * }
 * catch (\ICanBoogie\Render\Exception $e)
 * {
 *     // a render exception
 * }
 * catch (\Throwable $e
 * {
 *     // another type of exception
 * }
 * </pre>
 */
interface Exception extends Throwable
{
}
