# Render

[![Release](https://img.shields.io/packagist/v/icanboogie/render.svg)](https://github.com/ICanBoogie/Render/releases)
[![Build Status](https://img.shields.io/travis/ICanBoogie/Render/master.svg)](http://travis-ci.org/ICanBoogie/Render)
[![HHVM](https://img.shields.io/hhvm/icanboogie/render.svg)](http://hhvm.h4cc.de/package/icanboogie/render)
[![Code Quality](https://img.shields.io/scrutinizer/g/ICanBoogie/Render/master.svg)](https://scrutinizer-ci.com/g/ICanBoogie/Render)
[![Code Coverage](https://img.shields.io/coveralls/ICanBoogie/Render/master.svg)](https://coveralls.io/r/ICanBoogie/Render)
[![Packagist](https://img.shields.io/packagist/dt/icanboogie/render.svg)](https://packagist.org/packages/icanboogie/render)

An API to render templates with a variety of template engines.





## Render engines

Templates can be rendered with a variety of template engines. A shared collection is provided by the `get_engines` helper. When it is first created the `EngineCollection::alter` event of class [EngineCollection\AlterEvent][] is fired. Event hooks may use this event to add rendering engines or replace the engine collection altogether.

**Note:** Currently, the package only provides an engine to render PHP templates, but others may provide more, for instance the [Patron engine][].

The following example demonstrate how the **Patron** engine can be added to handle `.patron` extensions:

```php
<?php

use ICanBoogie\Render\EngineCollection;

$app->events->attach(function(EngineCollection\AlterEvent $event, EngineCollection $target) {

	$event->instance['.patron'] = 'Patron\RenderSupport\PatronEngine';

});
```

The following example demonstrates how to replace the engine collection with a decorator:

```php
<?php

use ICanBoogie\Render\EngineCollection;

$app->events->attach(function(EngineCollection\AlterEvent $event, EngineCollection $target) {

	$event->instance = new MyEngineCollection($event->instance);

});
```




### The pathname of the template being rendered

Engines should use the `Engine::VAR_TEMPLATE_PATHNAME` variable to define the pathname of the template being rendered, so that it is easy to track which template is being rendered and from which location.





## Template resolver

A template resolver tries to match a template name with an actual template file. A set of paths can be defined for the resolver to search in.

The `BasicTemplateResolver::alter` event of class [BasicTemplateResolver\AlterEvent][] is fired on the shared template resolver when it is created. Event hooks may use this event to add template paths or replace the template resolver.

The following example demonstrates how to add template paths:

```php
<?php

use ICanBoogie\Render\BasicTemplateResolver;

$app->events->attach(function(BasicTemplateResolver\AlterEvent $event, BasicTemplateResolver $target) {

	$target->add_paths(__DIR__ . '/my/templates/path);

};
```





### Decorating a template resolver

Decorating the basic template resolver allows you to use more complex resolving mechanisms than its simple name/file mapping. The [ModuleTemplateResolver](https://github.com/ICanBoogie/Module/blob/master/lib/ModuleTemplateResolver.php) or the [ApplicationTemplateResolver](https://github.com/ICanBoogie/bind-render/blob/master/lib/ApplicationTemplateResolver.php) decorators are great examples. The [TemplateResolverTrait][] trait may provide support  for implementing such a decorator.

**Note:** The decorator must implement the [TemplateResolver][] interface.

The following example demonstrates how to replace the template resolver with a decorator:

```php
<?php

use ICanBoogie\Render\BasicTemplateResolver;

$app->events->attach(function(BasicTemplateResolver\AlterEvent $event, BasicTemplateResolver $target) {

	$event->instance = new MyTemplateResolverDecorator($event->instance);

};
```





## Renderer

A [Renderer][] instance is used to render a template with a subject and options. An engine collection and a template resolver are used to find suitable templates for the rendering.

A shared [Renderer][] instance is provided by the `get_renderer()` helper. When it is first created the `Renderer::alter` event of class [Renderer\AlterEvent][] is fired. Event hooks may use this event to alter the renderer or replace it.

The following example demonstrates how to replace the renderer:

```php
<?php

use ICanBoogie\Render\Renderer;

$app->events->attach(function(Renderer\AlterEvent $event, Renderer $target) {

	$event->instance = new MyRenderer($event->instance->engines, $event->instance->template_resolver);

});
```





## Helpers

The following helpers are defined:

- `get_engines`: Returns a shared engine collection.
- `get_template_resolver`: Returns a shared template resolver.
- `get_renderer`: Returns a shared renderer.





----------





## Requirements

The package requires PHP 5.4 or later.





## Installation

The recommended way to install this package is through [Composer](http://getcomposer.org/):

```
$ composer require icanboogie/render
```





### Cloning the repository

The package is [available on GitHub](https://github.com/ICanBoogie/Render), its repository can be cloned with the following command line:

	$ git clone https://github.com/ICanBoogie/Render.git





## Documentation

The package is documented as part of the [ICanBoogie][] framework
[documentation](http://icanboogie.org/docs/). You can generate the documentation for the package and its dependencies with the `make doc` command. The documentation is generated in the `build/docs` directory. [ApiGen](http://apigen.org/) is required. The directory can later be cleaned with the `make clean` command.





## Testing

The test suite is ran with the `make test` command. [PHPUnit](https://phpunit.de/) and [Composer](http://getcomposer.org/) need to be globally available to run the suite. The command installs dependencies as required. The `make test-coverage` command runs test suite and also creates an HTML coverage report in "build/coverage". The directory can later be cleaned with the `make clean` command.

The package is continuously tested by [Travis CI](http://about.travis-ci.org/).

[![Build Status](https://img.shields.io/travis/ICanBoogie/Render/master.svg)](https://travis-ci.org/ICanBoogie/Render)
[![Code Coverage](https://img.shields.io/coveralls/ICanBoogie/Render/master.svg)](https://coveralls.io/r/ICanBoogie/Render)





## License

**icanboogie/render** is licensed under the New BSD License - See the [LICENSE](LICENSE) file for details.





[EngineCollection\AlterEvent]: http://icanboogie.org/docs/namespace-ICanBoogie.Render.EngineCollection.AlterEvent.html
[ICanBoogie]: https://github.com/ICanBoogie\ICanBoogie
[Patron engine]: https://github.com/Icybee/PatronViewSupport
[Renderer\AlterEvent]: http://icanboogie.org/docs/namespace-ICanBoogie.Render.Renderer.AlterEvent.html
[BasicTemplateResolver\AlterEvent]: http://icanboogie.org/docs/namespace-ICanBoogie.Render.BasicTemplateResolver.AlterEvent.html
[Renderer]: http://icanboogie.org/docs/namespace-ICanBoogie.Render.Renderer.AlterEvent.html
[TemplateResolver]: http://icanboogie.org/docs/namespace-ICanBoogie.Render.TemplateResolver.AlterEvent.html
[TemplateResolverTrait]: http://icanboogie.org/docs/namespace-ICanBoogie.Render.TemplateResolverTrait.AlterEvent.html
