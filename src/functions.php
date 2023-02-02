<?php

namespace Smoren\Sequence\Functions;

use ArrayIterator;
use IteratorIterator;
use MultipleIterator;
use Smoren\Sequence\Structs\IndexedArray;
use Smoren\Sequence\Structs\Range;

/**
 * Creates iterable range.
 *
 * @param int $start start value
 * @param int<0, max>|null $size size of elements
 * @param int $step range step
 *
 * @return Range<int> iterable range
 */
function xrange(int $start, ?int $size = null, int $step = 1): Range
{
    if ($size === null) {
        [$start, $size] = [0, $start];
    }

    return new Range($start, $size, $step);
}

/**
 * Maps iterable collections and returns IndexedArray of mapped values.
 *
 * @template TInput
 * @template TOutput
 *
 * @param callable(TInput $item): TOutput $mapper
 * @param iterable<TInput> $collections
 *
 * @return IndexedArray<TOutput>
 */
function map(callable $mapper, iterable ...$collections): IndexedArray
{
    $result = new IndexedArray();

    if (count($collections) === 0) {
        return $result;
    }

    $it = new MultipleIterator(MultipleIterator::MIT_NEED_ALL | MultipleIterator::MIT_KEYS_NUMERIC);

    foreach ($collections as $collection) {
        if (is_array($collection)) {
            $collection = new ArrayIterator($collection);
        }

        $it->attachIterator(new IteratorIterator($collection));
    }

    foreach ($it as $values) {
        $result[] = $mapper(...$values);
    }

    return $result;
}

/**
 * Filters iterable collection and returns IndexedArray of filtered items.
 *
 * @template T
 *
 * @param iterable<T> $collection
 * @param callable(T $item): T $filter
 *
 * @return IndexedArray<T>
 */
function filter(iterable $collection, callable $filter): IndexedArray
{
    $result = new IndexedArray();

    foreach ($collection as $item) {
        if ($filter($item)) {
            $result[] = $item;
        }
    }

    return $result;
}

/**
 * Reduces iterable collection.
 *
 * @template TInput
 * @template TOutput
 *
 * @param iterable<TInput> $collection
 * @param callable(TOutput $carry, TInput $item): TOutput $reducer
 * @param TOutput $initialValue
 *
 * @return TOutput
 */
function reduce(iterable $collection, callable $reducer, $initialValue = null)
{
    $carry = $initialValue;

    foreach ($collection as $item) {
        $carry = $reducer($carry, $item);
    }

    return $carry;
}
