<?php

declare(strict_types=1);

namespace Smoren\Sequence\Interfaces;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Smoren\Sequence\Exceptions\OutOfRangeException;
use Smoren\Sequence\Exceptions\ReadOnlyException;

/**
 * Iterable sequence.
 *
 * @template T
 * @extends ArrayAccess<int, T>
 * @extends IteratorAggregate<int, T>
 */
interface SequenceInterface extends ArrayAccess, Countable, IteratorAggregate
{
    /**
     * Returns true if sequence is infinite.
     *
     * @return bool
     */
    public function isInfinite(): bool;

    /**
     * Returns sequence value by index.
     *
     * @param int $index
     *
     * @return T
     */
    public function getValueByIndex(int $index);

    /**
     * Returns start value of the sequence.
     *
     * @return T
     */
    public function getStartValue();

    /**
     * Returns next value of the sequence by its previous value.
     *
     * @param T $previousValue
     *
     * @return T
     */
    public function getNextValue($previousValue);

    /**
     * {@inheritDoc}
     *
     * @param int $offset
     *
     * @return bool
     */
    public function offsetExists($offset): bool;

    /**
     * {@inheritDoc}
     *
     * @param int $offset
     *
     * @return T
     *
     * @throws OutOfRangeException
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset);

    /**
     * {@inheritDoc}
     *
     * @param int|null $offset
     * @param T $value
     *
     * @return void
     *
     * @throws ReadOnlyException anyway
     */
    public function offsetSet($offset, $value): void;

    /**
     * {@inheritDoc}
     *
     * @param int $offset
     *
     * @return void
     *
     * @throws ReadOnlyException anyway
     */
    public function offsetUnset($offset): void;

    /**
     * {@inheritDoc}
     */
    public function count(): int;

    /**
     * {@inheritDoc}
     *
     * @return SequenceIteratorInterface<T>
     */
    public function getIterator(): SequenceIteratorInterface;
}
