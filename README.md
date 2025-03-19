# String

Simple functions for string manipulation and analysis.

## Usage

```php
use cjrasmussen\String\Check;
use cjrasmussen\String\Convert;
use cjrasmussen\String\Parse;

$string = Parse::filterChars('I have 5 apples', Parse::FILTER_NUM);
echo $string; // 5

$json = Check::isJson('This is not JSON');
echo $json; // false

echo Convert::booleanToYesNo(false); // No
echo Convert::booleanToYesNo(true); // Yes
```

## Installation

Simply add a dependency on cjrasmussen/string to your composer.json file if you use [Composer](https://getcomposer.org/) to manage the dependencies of your project:

```sh
composer require cjrasmussen/string
```

Although it's recommended to use Composer, you can actually include the file(s) any way you want.


## License

String is [MIT](http://opensource.org/licenses/MIT) licensed.