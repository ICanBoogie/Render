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
 * Exception thrown when a required engine is not defined.
 */
final class EngineNotDefined extends OffsetNotDefined implements Exception
{

}
