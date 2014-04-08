# Vlad

[![Build Status](https://travis-ci.org/gajus/vlad.png?branch=master)](https://travis-ci.org/gajus/vlad)
[![Coverage Status](https://coveralls.io/repos/gajus/vlad/badge.png)](https://coveralls.io/r/gajus/vlad)

Input validation library.

## Succint Test Declaration

Test is composed of assertions about input.

```php
$test = new \Gajus\Vlad\Test();

$test
    // string $selector_name[, boolean $condition = false]
    ->assert('user[first_name]')
    // string $validator_name[, array $validator_options = null[, array $condition_options = null]]
    ->is('NotEmpty')
    ->is('String')
    ->is('LengthMin', ['length' => 5])
    ->is('LengthMax', ['length' => 20]);

$test
    ->assert('user[last_name]')
    ->is('NotEmpty')
    ->is('String')
    ->is('LengthMin', ['length' => 5])
    ->is('LengthMax', ['length' => 20]);

if ($assessment = $test->assess($_POST)) {
    foreach ($assessment as $error) {
        // 
    }
}
```

## Extendable Validation Rules

Vlad has [inbuilt validators](https://github.com/gajus/vlad#inbuilt-validation-rules). It is easy to write custom validators. You can [request new validators](https://github.com/gajus/vlad/issues) to be added to the core package. Validators benefit from the translator interface. Vlad does not encourage inline boolean validation expressions.

### Inbuilt Validation Rules

* [String](src/Validator/String.php)
* [Regex](src/Validator/Regex.php)
* [RangeMinInclusive](src/Validator/RangeMinInclusive.php)
* [RangeMinExclusive](src/Validator/RangeMinExclusive.php)
* [RangeMaxInclusive](src/Validator/RangeMaxInclusive.php)
* [RangeMaxExclusive](src/Validator/RangeMaxExclusive.php)
* [NotEmpty](src/Validator/NotEmpty.php)
* [LengthMin](src/Validator/LengthMin.php)
* [LengthMax](src/Validator/LengthMax.php)
* [In](src/Validator/In.php)
* [Email](src/Validator/Email.php)

### Writing Custom Validator

```php
<?php
namespace Foo\Bar;

// Defining custom validators requires to extend \Gajus\Vlad\Validator.
// The custom Validator must be namespaced.

class HexColor extends \Gajus\Vlad\Validator {
    static protected
        // Each option must be predefined with default value.
        $default_options = [
            'trim' => false
        ],
        $message = '{input.name} is not a hexadecimal number.';
    
    public function assess ($value) {
        $options = $this->getOptions();

        if ($options['trim']) {
            $value = ltrim($value, '#');
        }

        return ctype_xdigit($value) && (strlen($value) == 6 || strlen($value) == 3);
    }
}
```

## Multilingual

Translator allows to overwrite default error messages, input specific error messages and give input names.

## Documentation



## Todo

* HEX colour validator.
* Add URL validator. This should consider that URL does not necessarily include protocol and that those that do include, e.g. ftp:// might not necessarily be expected URLs.
* Improve email validator. Zend validator includes useful additions (MX check, host name validator, etc) https://github.com/zendframework/zf2/blob/master/library/Zend/Validator/EmailAddress.php.

## Alternatives

* https://github.com/zendframework/zf2/tree/master/library/Zend/Validator
* https://github.com/Respect/Validation
* https://github.com/Wixel/GUMP
* https://github.com/vlucas/valitron
* https://github.com/Dachande663/PHP-Validation
* https://github.com/ASoares/PHP-Form-Validation
* https://github.com/fuelphp/validation
* https://github.com/smgt/inspector