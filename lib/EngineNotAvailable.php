<?php

namespace ICanBoogie\Render;

use LogicException;

/**
 * Exception thrown when there is no engine available to render a template.
 */
final class EngineNotAvailable extends LogicException implements Exception
{
}
