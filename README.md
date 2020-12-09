# A package providing pages for the Mein Moers platform.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/lambdadigamma/mm-pages.svg?style=flat-square)](https://packagist.org/packages/lambdadigamma/mm-pages)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/lambdadigamma/mm-pages/run-tests?label=tests)](https://github.com/lambdadigamma/mm-pages/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/lambdadigamma/mm-pages.svg?style=flat-square)](https://packagist.org/packages/lambdadigamma/mm-pages)

A package providing pages for the Mein Moers platform.

## Installation

You can install the package via composer:

```bash
composer require lambdadigamma/mm-pages
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="LambdaDigamma\MMPages\MMPagesServiceProvider" --tag="migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="LambdaDigamma\MMPages\MMPagesServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php

```

## Further Ideas

-   Storing slug rewrites to provide redirects even if slug / page title changes

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Lennart Fischer](https://github.com/LambdaDigamma)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
