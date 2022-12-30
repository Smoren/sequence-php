<?php

namespace Smoren\Sequence\Functions;

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
    if($size === null) {
        [$start, $size] = [0, $start];
    }

    return new Range($start, $size, $step);
}

/**
 * Maps iterable collection and returns IndexedArray of mapped values.
 *
 * @template TInput
 * @template TOutput
 *
 * @param iterable<TInput> $collection
 * @param callable(TInput $item): TOutput $mapper
 *
 * @return IndexedArray<TOutput>
 */
function map(iterable $collection, callable $mapper): IndexedArray
{
    $result = new IndexedArray();

    foreach($collection as $item) {
        $result[] = $mapper($item);
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

    foreach($collection as $item) {
        if($filter($item)) {
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
 * @param callable(TOutput|null $carry, TInput $item): TOutput $reducer
 * @param TOutput|null $initialValue
 *
 * @return TOutput|null
 */
function reduce(iterable $collection, callable $reducer, $initialValue = null)
{
    $carry = $initialValue;

    foreach($collection as $item) {
        $carry = $reducer($carry, $item);
    }

    return $carry;
}
