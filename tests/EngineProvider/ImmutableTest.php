<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Test\ICanBoogie\Render\EngineProvider;

use ICanBoogie\Render\Engine;
use ICanBoogie\Render\EngineProvider\Immutable;
use LogicException;
use PHPUnit\Framework\TestCase;

class ImmutableTest extends TestCase
{
    public function test_engine_for_extension(): void
    {
        $stu = new Immutable([
            '.phtml' => $engine = new class () implements Engine{
                public function render(
                    string $template_pathname,
                    mixed $content,
                    array $variables
                ): string {
                    throw new LogicException();
                }
            }
        ]);

        $this->assertNull($stu->engine_for_extension(".php"));
        $this->assertSame($engine, $stu->engine_for_extension(".phtml"));
    }
}
