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
 * A mutable engine provider.
 */
interface MutableEngineProvider extends EngineProvider
{
    /**
     * Adds an engine for an extension.
     */
    public function add_engine(string $extension, Engine $engine): void;
}
