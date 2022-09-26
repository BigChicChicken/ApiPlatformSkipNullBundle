# ApiPlatformSkipNullBundle

[![Packagist](https://img.shields.io/packagist/v/bigchicchicken/api-platform-skip-null-bundle?style=plastic.svg)](https://packagist.org/packages/bigchicchicken/api-platform-skip-null-bundle)

Bundle to globally define skip_null_values parameter on all entities for [ApiPlatform](https://api-platform.com/).

## Installation:

Install ApiPlatformSkipNullBundle library using [Composer](https://getcomposer.org/):

```bash
composer require bigchicchicken/api-platform-skip-null-bundle
```

Add/Check activation in the file `config/bundles.php`:

```php
// config/bundles.php

return [
    // ...
    ApiPlatformSkipNullBundle\ApiPlatformSkipNullBundle::class => ['all' => true],
];

```

Configuration the bundle:

```yaml
api_platform_skip_null:
    enabled: true|false # (Default: true)
```

## License

This is completely free and released under the [MIT License](https://github.com/BigChicChicken/ApiPlatformSkipNullBundle/blob/main/LICENSE).