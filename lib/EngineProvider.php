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

use Traversable;

/**
 * @template-extends Traversable<string, Engine>
 *     Where _key_ is an extension e.g. "php" and _value_ is an Engine.
 */
interface EngineProvider extends Traversable
{
    /**
     * Provides an engine for a given file extension.
     *
     * @param string $extension A file extension e.g. "php".
     */
    public function engine_for_extension(string $extension): ?Engine;
}
