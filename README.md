# World's food

### Coding test. Laravel's module 

Code test according to the following:

>Create a module in Laravel which will do search of products/items. It should include a search
>form. After entering the product name it should show the list of matching results.
>Each product/item should have the following parameters:
>- ID (id)
>- Image (image_url)
>- Name (product_name)
>- Category (categories)
>*Tasks:*
>1. Use openfoodfacts API -
>https://world.openfoodfacts.org/cgi/search.pl?action=process&sort_by=unique_scans_n&page_size=20&json=1​ to display products/items on the page (add pagination
here as well)
>2. In front of each entry add a button/link, by click on which data will be saved to DB (or
>updated in case it has been already saved before)
>3. Cover your code with functional/unit tests
>
>*Tech stack:*
>- PHP (last version)
>- Laravel (last version)


<!-- GETTING STARTED -->
## Getting Started
Hope you already have a PHP, Laravel with laravel-modules package and npm.

### Prerequisites

This is an example of how to list things you need to use the software and how to install them.
* PHP >= 7.4
* [Composer](https://getcomposer.org/)
* Laravel >= 8.0 
* nwidart/laravel-modules >= 8.0
* npm


### Installation

* Create dir Modules into Laravel project root(if not exists)
* Copy module Food code into Modules(clone or unpack from an archive) 
* Install Module dependencies:<br>
 ```php artisan module:update Food```
<br> Note: maybe you need to remove guzzle package before, because of conflict
```composer remove guzzlehttp/guzzle```
* Enable module:
    * ```php artisan module:enable Food``` 
    * Edit your composer.json
```json
    },
    "autoload": {
        "psr-4": {
            "App\\": "app/",
+           "Modules\\": "Modules/",
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/"
        }
    },
 ```
   * Run ```composer install```
*  Create Module's tables<br>
   ```php artisan module:migrate Food```  
* Compile front-end<br>
``npm install && npm run dev``
* Edit your main app Router and Module Router if needed.
### Tests (Optional)

* Edit the phpunit.xml file and run Module tests
```xml
    <testsuites>
        <testsuite name="Unit">
            <directory suffix="Test.php">./tests/Unit</directory>
+           <directory suffix="Test.php">./Modules/**/Tests/Unit</directory>
        </testsuite>
        <testsuite name="Feature">
            <directory suffix="Test.php">./tests/Feature</directory>
+           <directory suffix="Test.php">./Modules/**/Tests/Feature</directory>
        </testsuite>
    </testsuites>
```
* Then run<br>
```php artisan test```



