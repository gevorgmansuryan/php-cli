# PHP Interactive CLI support

[![Latest Stable Version](https://poser.pugx.org/gevman/cli/v/stable?format=flat-square)](https://packagist.org/packages/gevman/cli)
[![Latest Unstable Version](https://poser.pugx.org/gevman/cli/v/unstable?format=flat-square)](https://packagist.org/packages/gevman/cliv)
[![License](https://poser.pugx.org/gevman/cli/license?format=flat-square)](https://packagist.org/packages/gevman/cli)


## Installation (using composer)

```bash
composer require gevman/cli
```

## Class `Gevman\Cli\Cli`

#### `bool` confirm(`string` $prompt \[, `bool` $default = true\])
##### Interactive confirm - returns user selected value (Y=true, N=false)
- `$prompt` - prompt message
- `$default` - default value

#### `void` input(&$input \[, `string` $message = ''\] \[, `bool` $required = false\])
##### Interactive prompt for user input
- `$prompt` - prompt message
- `$default` - default value

#### `Gevman\Cli\CliOutput` output(`string` $str \[, `mixed` $_ = null\])
##### Outputs message
- `$str` - message or pattern for sprintf
- `$_` - parameters for sprintf

## Class `Gevman\Cli\CliOutput`

#### `Gevman\Cli\CliOutput` success()
##### Marks output green

#### `Gevman\Cli\CliOutput` warning()
##### Marks output Yellow

#### `Gevman\Cli\CliOutput` error()
##### Marks output Red

#### `Gevman\Cli\CliOutput` note()
##### Marks output Blue

#### `Gevman\Cli\CliOutput` endl()
##### Line break

#### `Gevman\Cli\CliOutput` cl()
##### Clear current line

#### `void` progressBar(`mixed` $all \[, `string` $additionalInfo = ''\])
##### Displays interactive progressbar (message should be current key)
- `$all` - count of all
- `$additionalInfo` - displays additional Info for each step



```php
require '/path/to/autoload.php';

use Gevman\Cli\Cli;

//basic example
Cli::output('%s - %s', 'hello', 'world')->note()->endl()->output('yesimum')->error()->endl()->endl();

//pregressbar example
$all = 100000;
for ($step = 0; $step < 100000; $step++) {
    Cli::output($step + 1)->progressBar($all, $step);
}
```
