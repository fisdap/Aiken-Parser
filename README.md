### Fisdap Aiken Parsing Library in PHP

### Introduction
This PHP library will parse a file in Aiken format to an array

### Example
```php
require('./vendor/autoload.php');

$file = './examples/aiken.txt';

$aiken = new \Fisdap\Aiken\Parser\AikenParser($file);
$itemCollection = $aiken->buildTestItemCollection();

var_dump($itemCollection->toArray());
```

### Testing
```sh
$ phpunit
```
- Be Awesome!

### Language
 - PHP

### License

Aiken parsing library by Fisdap is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

Authors
----
- Jason Michels
