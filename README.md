# Filament Optimize FileUpload

[![Latest Version on Packagist](https://img.shields.io/packagist/v/agencetwogether/filament-optimize-fileupload.svg?style=flat-square)](https://packagist.org/packages/agencetwogether/filament-optimize-fileupload)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/agencetwogether/filament-optimize-fileupload/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/agencetwogether/filament-optimize-fileupload/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/agencetwogether/filament-optimize-fileupload/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/agencetwogether/filament-optimize-fileupload/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/agencetwogether/filament-optimize-fileupload.svg?style=flat-square)](https://packagist.org/packages/agencetwogether/filament-optimize-fileupload)



Save your image with compression and in another format in FileUpload component

## Installation

You can install the package via composer:

```bash
composer require agencetwogether/filament-optimize-fileupload
```

## Usage

After installation, just call `->optimize('webp', '50')` in one of your `FileUpload` component in your form to automatically save your image with your conversion

```php
FileUpload::make('image')
    ->image()
    ->optimize('webp')
```
You can choose any image format and eventually customizing the quality with second parameter.


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Agence Twogether](https://github.com/agencetwogether)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
