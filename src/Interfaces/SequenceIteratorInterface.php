<?php

declare(strict_types=1);

namespace Smoren\Sequence\Interfaces;

use Iterator;

/**
 * Iterator for sequences.
 *
 * @template T
 * @extends Iterator<int, T>
 */
interface SequenceIteratorInterface extends Iterator
{
    /**
     * {@inheritDoc}
     *
     * @return T
     */
    #[\ReturnTypeWillChange]
    public function current();

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    public function next(): void;

    /**
     * {@inheritDoc}
     *
     * @return int
     */
    public function key(): int;

    /**
     * {@inheritDoc}
     *
     * @return bool
     */
    public function valid(): bool;

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    public function rewind(): void;
}
