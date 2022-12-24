<?php

declare(strict_types=1);

namespace Smoren\Sequence\Interfaces;

use Iterator;

/**
 * @template T
 * @extends Iterator<int, T>
 */
interface SequenceIteratorInterface extends Iterator
{
    /**
     * @return T
     */
    #[\ReturnTypeWillChange]
    public function current();

    /**
     * @return void
     */
    public function next(): void;

    /**
     * @return int
     */
    public function key(): int;

    /**
     * @return bool
     */
    public function valid(): bool;

    /**
     * @return void
     */
    public function rewind(): void;
}
