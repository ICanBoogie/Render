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

Helper functions and events have been removed. Better rely on a dependency injection container to
build the services. The dependency to `icanboogie/event` has been removed.


[EngineProvider\Immutable]: lib/EngineProvider/Immutable.php
[EngineProvider\Container]: lib/EngineProvider/Container.php
