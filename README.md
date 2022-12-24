# Iterator-based sequences

![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/smoren/sequence)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Smoren/sequence-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Smoren/sequence-php/?branch=master)
[![Coverage Status](https://coveralls.io/repos/github/Smoren/sequence-php/badge.svg?branch=master)](https://coveralls.io/github/Smoren/sequence-php?branch=master)
![Build and test](https://github.com/Smoren/sequence-php/actions/workflows/test_master.yml/badge.svg)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

Python-like sequences with iterators for PHP

### How to install to your project
```
composer require smoren/sequence
```

### Unit testing
```
composer install
composer test-init
composer test
```

### Usage

#### Range-based for (python-like)

```php
use function Smoren\Sequence\Functions\xrange;

foreach(xrange(5) as $i) {
    echo "{$i} ";
}
// out: 0 1 2 3 4

foreach(xrange(1, 5) as $i) {
    echo "{$i} ";
}
// out: 1 2 3 4 5

foreach(xrange(1, 5, 2) as $i) {
    echo "{$i} ";
}
// out: 1 3 5 7 9
```

#### Range

```php
use Smoren\Sequence\Structs\IntRange;
use Smoren\Sequence\Structs\FloatRange;

/* Simple int range */
$range = new IntRange(1, 3, 2); // (from, size, step)
var_dump($range->isInfinite()); // false

foreach($range as $value) {
    echo "{$value} ";
}
// out: 1 3 5

var_dump($range[0]); // 1
var_dump($range[1]); // 3
var_dump($range[2]); // 5

try {
    $range[3];
} catch(OutOfRangeException $e) {
    echo "cannot get value from index out of range\n";
}

var_dump($range[-1]); // 5
var_dump($range[-2]); // 3
var_dump($range[-3]); // 1

try {
    $range[-4];
} catch(OutOfRangeException $e) {
    echo "cannot get value from index out of range\n";
}

/* Infinite int range */
$range = new IntRange(1, null, 2);
var_dump($range->isInfinite()); // true

foreach($range as $i => $value) {
    echo "{$value} ";
    if($i > 100) break;
}
// out: 1 3 5 7 9 11 13...

/* Float range */
$range = new FloatRange(1.1, 3, 2.1);
var_dump($range->isInfinite()); // false

foreach($range as $value) {
    echo "{$value} ";
}
// out: 1.1 3.2 5.3
```

#### Exponential

```php
use Smoren\Sequence\Structs\IntExponential;
use Smoren\Sequence\Structs\FloatExponential;

/* Simple int exponential sequence */
$sequence = new IntExponential(1, 4, 2); // (from, size, step)
var_dump($sequence->isInfinite()); // false

foreach($sequence as $value) {
    echo "{$value} ";
}
// out: 1 2 4 8

var_dump($sequence[0]); // 1
var_dump($sequence[1]); // 2
var_dump($sequence[2]); // 4
var_dump($sequence[3]); // 8

try {
    $sequence[4];
} catch(OutOfRangeException $e) {
    echo "cannot get value from index out of range\n";
}

var_dump($sequence[-1]); // 8
var_dump($sequence[-2]); // 4
var_dump($sequence[-3]); // 2
var_dump($sequence[-4]); // 1

try {
    $sequence[-5];
} catch(OutOfRangeException $e) {
    echo "cannot get value from index out of range\n";
}

/* Infinite int exponential sequence */
$sequence = new IntExponential(1, null, 2);
var_dump($sequence->isInfinite()); // true

foreach($sequence as $i => $value) {
    echo "{$value} ";
    if($i > 100) break;
}
// out: 1 2 4 8 16 32 64...

/* Infinite float exponential sequence */
$sequence = new FloatRange(0.5, null, 2);
var_dump($sequence->isInfinite()); // true

foreach($sequence as $value) {
    echo "{$value} ";
}
// out: 0.5 0.25 0.125...
```

#### IndexedArray

```php
use Smoren\Sequence\Structs\IndexedArray;
use Smoren\Sequence\Exceptions\OutOfRangeException;

$array = new IndexedArray([10, 20, 30]);

$array[0] = 11;
$array[-1] = 33;
$array[1] = 22;
var_dump(count($array)); // 3
print_r($array->toArray()); // [11, 22, 33]

unset($array[1]);
print_r($array->toArray()); // [11, 33]

$array[] = 111;
print_r($array->toArray()); // [11, 33, 111]

try {
    $array[3];
} catch(OutOfRangeException $e) {
    echo "cannot get value from index out of range\n";
}

try {
    $array[3] = 1;
} catch(OutOfRangeException $e) {
    echo "cannot set value from index out of range\n";
}

try {
    unset($array[3]);
} catch(OutOfRangeException $e) {
    echo "cannot unset value from index out of range\n";
}
```
