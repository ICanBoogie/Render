# Migration

## v0.6 to v6.0

`EngineCollection` has been removed in favor of the new concept of engine providers. The new engine
provider `Mutable` has similar features, in the sense that it can be modified to add more engines.
Other engine providers are available as well such as [EngineProvider\Immutable][] and
[EngineProvider\Container][].

```php
<?php

use ICanBoogie\Render\EngineCollection;
use ICanBoogie\Render\PHPEngine;

$engines = new EngineCollection();
$engines['.php'] = PHPEngine::class;
```

```php
<?php

use ICanBoogie\Render\EngineProvider;
use ICanBoogie\Render\PHPEngine;

$engines = new EngineProvider\Mutable();
$engines->add_engine('.php', new PHPEngine());
```

Simplified `Renderer:render()` signature and introduces [RenderOptions][].

```php
<?php

use ICanBoogie\Render\Renderer;

/* @var Renderer $renderer */
/* @var mixed $content */

$renderer->render($content, [ Renderer::OPTION_PARTIAL => 'articles/list' ]);
$renderer->render([ Renderer::VARIABLE_CONTENT => $content, Renderer::OPTION_PARTIAL => 'articles/list' ]);
```

```php
<?php

use ICanBoogie\Render\Renderer;
use ICanBoogie\Render\RenderOptions;

/* @var Renderer $renderer */
/* @var mixed $content */

$renderer->render($content, new RenderOptions(partial: 'articles/list' ));
```

Helper functions and events have been removed. Better rely on a dependency injection container to
build the services. The dependency to `icanboogie/event` has been removed.


[EngineProvider\Immutable]: lib/EngineProvider/Immutable.php
[EngineProvider\Container]: lib/EngineProvider/Container.php
[RenderOptions]: lib/RenderOptions.php
