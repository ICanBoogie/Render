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

use ICanBoogie\OffsetNotDefined;

/**
 * Exception thrown when there is no engine available to render a template.
 */
final class EngineNotAvailable extends OffsetNotDefined implements Exception
{

}
