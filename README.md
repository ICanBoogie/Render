# Render

This library provides an API to render and decorate objects.

The goal of this library is to provide a simply API to render and decorate any kind of object,
providing a renderer or a decorator is defined to do so.





## Support for ICanBoogie's auto-config

The package support ICanBoogie's auto-config and provides the following:

- A synthesizer for the config "renderers".
- A lazy getter for the `ICanBoogie\Core::$renderer` property.
- A callback for the `ICanBoogie\Core::render()` method.





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
