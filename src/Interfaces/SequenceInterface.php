<?php

declare(strict_types=1);

namespace Smoren\Sequence\Interfaces;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Smoren\Sequence\Exceptions\OutOfRangeException;
use Smoren\Sequence\Exceptions\ReadOnlyException;

/**
 * @template T
 * @extends ArrayAccess<int, T>
 * @extends IteratorAggregate<int, T>
 */
interface SequenceInterface extends ArrayAccess, Countable, IteratorAggregate
{
    /**
     * @return bool
     */
    public function isInfinite(): bool;

    /**
     * @param int $index
     * @return T
     */
    public function getValueByIndex(int $index);

    /**
     * @return T
     */
    public function getStartValue();

    /**
     * @param T $previousValue
     * @return T
     */
    public function getNextValue($previousValue);

    /**
     * @param int $offset
     * @return bool
     */
    public function offsetExists($offset): bool;

    /**
     * @param int $offset
     * @return T
     * @throws OutOfRangeException
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset);

    /**
     * @param int|null $offset
     * @param T $value
     * @return void
     * @throws ReadOnlyException
     */
    public function offsetSet($offset, $value): void;

    /**
     * @param int $offset
     * @return void
     * @throws ReadOnlyException
     */
    public function offsetUnset($offset): void;

    /**
     * @return int
     */
    public function count(): int;
}
