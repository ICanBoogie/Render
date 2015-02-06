# Render

[![Release](https://img.shields.io/packagist/v/icanboogie/render.svg)](https://github.com/ICanBoogie/Render/releases)
[![Build Status](https://img.shields.io/travis/ICanBoogie/Render/master.svg)](http://travis-ci.org/ICanBoogie/Render)
[![HHVM](https://img.shields.io/hhvm/icanboogie/render.svg)](http://hhvm.h4cc.de/package/icanboogie/render)
[![Code Quality](https://img.shields.io/scrutinizer/g/ICanBoogie/Render/master.svg)](https://scrutinizer-ci.com/g/ICanBoogie/Render)
[![Code Coverage](https://img.shields.io/coveralls/ICanBoogie/Render/master.svg)](https://coveralls.io/r/ICanBoogie/Render)
[![Packagist](https://img.shields.io/packagist/dt/icanboogie/render.svg)](https://packagist.org/packages/icanboogie/render)

An API to render templates.





## Render engines

Templates can be rendered with a variety of template engines. A shared collection is
provided by the `get_engines` helper. When it is first created the `EngineCollection::alter` event of
class [EngineCollection\AlterEvent][] is fired. Event hooks may use this event to add rendering engines or replace
the engine collection altogether.

**Note:** Currently, the package only provides an engine to render PHP templates, but others may provide more, for
instance the [Patron engine][].

The following example demonstrate how a Patron engine can be added to handle `.patron` extensions:

```php
<?php

use ICanBoogie\Render\EngineCollection;

$app->events->attach(function(EngineCollection\AlterEvent $event, EngineCollection $target) {

	$target['.patron'] = 'Icybee\Patron\ViewEngine';

});
```

The following example demonstrates how to replace the engine collection with a decorator:

```php
<?php

use ICanBoogie\Render\EngineCollection;

$app->events->attach(function(EngineCollection\AlterEvent $event, EngineCollection $target) {

	$event->replace_with(new MyEngineCollection);

});
```





## Template resolver

A template resolver tries to match a template name with an actual template file. A set of path
can be defined for the resolver to search in.

The `BasicTemplateResolver::alter` event of class [BasicTemplateResolver\AlterEvent][] is fired on the 
shared template resolver when it is created. Event hooks may use this event to add templates paths
or replace the template resolver.

The following example demonstrates how to add template paths:

```php
<?php

use ICanBoogie\Render\BasicTemplateResolver;

$app->events->attach(function(BasicTemplateResolver\AlterEvent $event, BasicTemplateResolver $target) {

	$target->add_paths(__DIR__ . '/my/own/path);

};
```

The following example demonstrates how to replace the template resolver with a decorator:

**Note:** The decorator must implement the [TemplateResolver][].

```php
<?php

use ICanBoogie\Render\BasicTemplateResolver;

$app->events->attach(function(BasicTemplateResolver\AlterEvent $event, BasicTemplateResolver $target) {

	$event->replace_with(new MyTemplateResolverDecorator($event->instance));

};
```





### Renderer

[Renderer][] instances are used to render templates with subjects and options. They use an engine collection and
a template resolver to find suitable templates and render them.

A shared renderer is provided by the `get_renderer()` helper. When it is first created the
`Renderer::alter` event of class [Renderer\AlterEvent][] is fired. Event hooks may use this event the alter the
renderer or replace it.

The following example demonstrate how to replace the a renderer:

```php
<?php

use ICanBoogie\Render\Renderer;

$app->events->attach(function(Renderer\AlterEvent $event, Renderer $target) {

	$event->replace_with(new MyRenderer($event->instance->engines, $event->instance->template_resolver));

});
```





## Helpers

The following helpers are defined:

- `get_engines`: Returns a shared engine collection.
- `get_template_resolver`: Returns a shared template resolver.
- `get_renderer`: Returns a shared renderer.





----------





## Requirements

The minimum requirement is PHP 5.4.





## Installation

The recommended way to install this package is through [Composer](http://getcomposer.org/):

```
$ composer require icanboogie/render:dev-master
```





### Cloning the repository

The package is [available on GitHub](https://github.com/ICanBoogie/Render), its repository can be
cloned with the following command line:

	$ git clone https://github.com/ICanBoogie/Render.git





## Documentation

The documentation for the package and its dependencies can be generated with the `make doc`
command. The documentation is generated in the `docs` directory using [ApiGen](http://apigen.org/).
The package directory can later by cleaned with the `make clean` command.

The documentation for the complete framework is also available online: <http://icanboogie.org/docs/> 





## Testing

The test suite is ran with the `make test` command. [Composer](http://getcomposer.org/) is
automatically installed as well as all the dependencies required to run the suite.
The directory can later be cleaned with the `make clean` command.

The package is continuously tested by [Travis CI](http://about.travis-ci.org/).

[![Build Status](https://img.shields.io/travis/ICanBoogie/Render/master.svg)](https://travis-ci.org/ICanBoogie/Render)
[![Code Coverage](https://img.shields.io/coveralls/ICanBoogie/Render/master.svg)](https://coveralls.io/r/ICanBoogie/Render)





## License

This package is licensed under the New BSD License - See the [LICENSE](LICENSE) file for details.





[EngineCollection\AlterEvent]: http://icanboogie.org/docs/namespace-ICanBoogie.Render.EngineCollection.AlterEvent.html
[Patron engine]: https://github.com/Icybee/PatronViewSupport
[Renderer\AlterEvent]: http://icanboogie.org/docs/namespace-ICanBoogie.Render.Renderer.AlterEvent.html
[BasicTemplateResolver\AlterEvent]: http://icanboogie.org/docs/namespace-ICanBoogie.Render.BasicTemplateResolver.AlterEvent.html
[TemplateResolver]: http://icanboogie.org/docs/namespace-ICanBoogie.Render.TemplateResolver.AlterEvent.html
