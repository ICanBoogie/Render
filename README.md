# Render

An API to render templates.





## Template engines

Templates can be rendered with a variety of template engines. A shared collection is
provided through the `$app->render_engines` lazy getter. When it is first created the
`EngineCollection::alter` event of class [EngineCollection\AlterEvent][] is fired. The package
provides only an engine to render PHP templates, but event hooks may use this event to add others.

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

	$event->instance = new MyEngineCollectionDecorator($event->instance);

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

```
<?php
use ICanBoogie\Render\TemplateResolver;

$app->events->attach(function(TemplateResolver\AlterEvent $event, TemplateResolver $target) {

	$event->instance = new MyTemplateResolverDecorator($event->instance);

};
```




## Support for ICanBoogie's auto-config

The package support ICanBoogie's auto-config and provides the following:

- A lazy getter for the `ICanBoogie\Core::$render_engines` property.
- A lazy getter for the `ICanBoogie\Core::$render_template_resolver` property.





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
[TemplateResolver\AlterEvent]: http://icanboogie.org/docs/namespace-ICanBoogie.Render.TemplateResolver.AlterEvent.html
[TemplateResolverInterface]: http://icanboogie.org/docs/namespace-ICanBoogie.Render.TemplateResolverInterface.AlterEvent.html
