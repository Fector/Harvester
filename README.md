[![Build Status](https://travis-ci.org/shahob/Harvester.svg?branch=master)](https://travis-ci.org/shahob/Harvester)

## A simple library that provide modify Model by request query

### Installation
Install the package through composer
``` bash
composer require fector/harvest
```
Publish config
```
php artisan vendor:publish
```

Once composer finished add the service provider to the `providers` array in `app/config/app.php`:
```
Fector\Harvest\HarvestServiceProvider::class,
```
Set an alias in `app.php`:
```
'Harvester' => Fector\Harvest\Facades\Harvester::class
```
That's it!

### Configuration
To override the configuration, create a file called `harvest.php` in the config folder of your app.  
The option combines contains a list of request handlers.
Where the key is the query parameter key and the value of the class name that will handle the value.

### Usage

```php
use Fector\Harvest\Facades\Harvester;

/**
 * Display the resource collection
 *
 * @param Request $request
 * @return BooksCollection
 */
public function index(Request $request): BooksCollection
{
    $books = Book::where('status', 1);
    $books = Harvester::recycle($communities)->paginate();
    return new BooksCollection($communities);
}
```
#### Default Combines

##### Sorter
Two ways of sorting:
ascending
```
/api/books?_sort=title
```
and descending with prefix "-"
```
/api/books?_sort=-title
```

##### Collector
You may specify which relationships should be eager loaded with data. Collector load relation if it exists.
```
/api/books?_with=authors
```
or 
```
/api/books?_with=authors,publisher
```

##### Selector
You may specify which fields should be loaded.
```
/api/books?_select=title
```
or 
```
/api/books?_select=title,publisher
```

Plan to add new default Combines:
Limiter, Skipper, Filter.