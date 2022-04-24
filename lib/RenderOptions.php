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

final class RenderOptions
{
    /**
     * @param array<string, mixed> $locals
     */
    public function __construct(
        public readonly ?string $template = null,
        public readonly ?string $partial = null,
        public readonly ?string $layout = null,
        public readonly array $locals = [],
    ) {
    }
}
