# Render

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

	$event->replace_with(new MyEngineCollectionDecorator($event->instance));

});
```





## Template resolver

A template resolver tries to match a template name with an actual template file. A set of path
can be defined for the resolver to search in.

The `TemplateResolver::alter` event of class [TemplateResolver\AlterEvent][] is fired on the 
shared template resolver when it is created. Event hooks may use this event to add templates paths
or replace the template resolver.

The following example demonstrates how to add template paths:

```php
<?php

use ICanBoogie\Render\TemplateResolver;

$app->events->attach(function(TemplateResolver\AlterEvent $event, TemplateResolver $target) {

	$target->add_paths(__DIR__ . '/my/own/path);

};
```

The following example demonstrates how to replace the template resolver with a decorator:

**Note:** The decorator must implement the [TemplateResolverInterface][].

```php
<?php

use ICanBoogie\Render\TemplateResolver;

$app->events->attach(function(TemplateResolver\AlterEvent $event, TemplateResolver $target) {

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
automatically installed as well as all dependencies required to run the suite. You can later
clean the directory with the `make clean` command.





## License

This package is licensed under the New BSD License - See the [LICENSE](LICENSE) file for details.





[EngineCollection\AlterEvent]: http://icanboogie.org/docs/namespace-ICanBoogie.Render.EngineCollection.AlterEvent.html
[Patron engine]: https://github.com/Icybee/PatronViewSupport
[Renderer\AlterEvent]: http://icanboogie.org/docs/namespace-ICanBoogie.Render.Renderer.AlterEvent.html
[TemplateResolver\AlterEvent]: http://icanboogie.org/docs/namespace-ICanBoogie.Render.TemplateResolver.AlterEvent.html
[TemplateResolverInterface]: http://icanboogie.org/docs/namespace-ICanBoogie.Render.TemplateResolverInterface.AlterEvent.html
