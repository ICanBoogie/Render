# Render

[![Packagist](https://img.shields.io/packagist/v/icanboogie/render.svg)](https://packagist.org/packages/icanboogie/render)
[![Code Quality](https://img.shields.io/scrutinizer/g/ICanBoogie/Render.svg)](https://scrutinizer-ci.com/g/ICanBoogie/Render)
[![Code Coverage](https://img.shields.io/coveralls/ICanBoogie/Render.svg)](https://coveralls.io/r/ICanBoogie/Render)
[![Downloads](https://img.shields.io/packagist/dt/icanboogie/render.svg)](https://packagist.org/packages/icanboogie/render)

An API to render templates with a variety of template engines.



#### Installation

```bash
composer require icanboogie/render
```



## Render engines

Templates may be rendered with a variety of template engines.

The following example demonstrates how to create an engine provider with the builtin engine for
PHP templates.

```php
<?php

/* @var ICanBoogie\Render\PHPEngine $engine */
/* @var string $template_pathname */
/* @var mixed $content */
/* @var array<string, mixed> $variables */

$rendered = $engine->render($template_pathname, $content, $variables);
```

**Note:** Currently, the package only provides an engine to render PHP templates, the available
engine can be extended with third parties packages such as [render-engine-markdown][] or
[render-engine-patron][].



## Render engine providers

Render engines are obtained through engine providers. The following providers are builtin:

- [EngineProvider\Container][]: Provides engines from a PSR container.
- [EngineProvider\Immutable][]: Provides engines from an immutable collection.
- [EngineProvider\Mutable][]: Provides engines from a mutable collection.

The following examples demonstrates how to obtain an engine for a `.php` extension from an immutable
provider.

```php
<?php

use ICanBoogie\Render\EngineProvider\Immutable;
use ICanBoogie\Render\PHPEngine;

$engines = new Immutable([ '.php' => new PHPEngine() ]);
echo $engines->engine_for_extension('.php')::class; // ICanBoogie\Render\PHPEngine
```

All engine providers are traversable, this feature can be used to collect the supported extensions:

```php
<?php

/* @var EngineProvider $engines */

$extensions = array_keys(iterator_to_array($engines));

echo implode(', ', $extensions); // .php
```



### The pathname of the template being rendered

Engines should use the `Engine::VAR_TEMPLATE_PATHNAME` variable to define the pathname of the
template being rendered, so that it is easy to track which template is being rendered and from
which location.





## Template resolver

A template resolver tries to match a template name with an actual template file. A set of paths
can be defined for the resolver to search in.





## Renderer

A [Renderer][] instance is used to render a template with a subject and options. An engine
collection and a template resolver are used to find suitable templates for the rendering.



----------



## Continuous Integration

The project is continuously tested by [GitHub actions](https://github.com/ICanBoogie/Inflector/actions).

[![Tests](https://github.com/ICanBoogie/Render/workflows/test/badge.svg?branch=master)](https://github.com/ICanBoogie/Render/actions?query=workflow%3Atest)
[![Static Analysis](https://github.com/ICanBoogie/Render/workflows/static-analysis/badge.svg?branch=master)](https://github.com/ICanBoogie/Render/actions?query=workflow%3Astatic-analysis)
[![Code Style](https://github.com/ICanBoogie/Render/workflows/code-style/badge.svg?branch=master)](https://github.com/ICanBoogie/Render/actions?query=workflow%3Acode-style)



## Code of Conduct

This project adheres to a [Contributor Code of Conduct](CODE_OF_CONDUCT.md). By participating in
this project and its community, you are expected to uphold this code.



## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.



## License

**icanboogie/render** is released under the [BSD-3-Clause](LICENSE).





[EngineCollection\AlterEvent]: lib/EngineCollection/AlterEvent.php
[TemplateResolver\AlterEvent]: lib/TemplateResolver/AlterEvent.php
[Renderer]:                    lib/Renderer/AlterEvent.php
[Renderer\AlterEvent]:         lib/Renderer/AlterEvent.php
[TemplateResolver]:            lib/TemplateResolver.php
[TemplateResolverTrait]:       lib/TemplateResolverTrait.php

[ApplicationTemplateResolver]: https://icanboogie.org/api/bind-render/5.0/class-ICanBoogie.Binding.Render.ApplicationTemplateResolver.html
[ModuleTemplateResolver]:      https://icanboogie.org/api/module/4.0/class-ICanBoogie.Module.ModuleTemplateResolver.html
[documentation]:               https://icanboogie.org/api/render/0.8/
[ICanBoogie]:                  https://github.com/ICanBoogie\ICanBoogie
[render-engine-patron]:        https://github.com/Icybee/PatronViewSupport
[render-engine-markdown]:      https://github.com/ICanBoogie/render-engine-markdown

[EngineProvider\Container]:    lib/EngineProvider/Container.php
[EngineProvider\Immutable]:    lib/EngineProvider/Immutable.php
[EngineProvider\Mutable]:      lib/EngineProvider/Mutable.php
