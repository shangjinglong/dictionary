# Dictionary

The Dictionary package is meant to provide you, the developer, with a set of tools to help you easily and quickly generate your database dictionay. Of course First make sure you want the database connection to be successful and add a comment for each field of each table.

## Requirements

To install this package you will need:

- Laravel 5.1+ or Lumen 5.1+
- PHP 5.5.9+

## Installation

You must then modify your composer.json file and run composer update to include the latest version of the package in your project.

```sh
"require": {
    "shangjinglong/dictionary": "dev-master"
}
```

Or you can run the composer require command from your terminal.

```sh
composer require shangjinglong/dictionary:dev-master
```

### Laravel

Open `config/app.php` and register the required service provider above your application providers.

```php
'providers' => [
    Shangjinglong\Dictionary\DictionaryServiceProvider::class
]
```

## Usage

```php
    namespace App\Http\Controllers;
    use Shangjinglong\Dictionary\Dictionary;

    class DictionaryController extends Controller
    {
        public  static function generate(){
            $dictionary = new Dictionary();
            $html = $dictionary->generate();
            return $html;
        }
    }
```

## Support

Please use [Github](https://github.com/shangjinglong/dictionary) for reporting bugs, and making comments or suggestions.

## License

The MIT License (MIT). Please see [License File](https://github.com/shangjinglong/dictionary/master/LICENSE) for more information.
