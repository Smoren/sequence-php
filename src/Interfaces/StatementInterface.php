<?php

namespace Smoren\Sequence\Interfaces;

/**
 * @phpstan-type Predicate = bool|callable(): bool
 * @type Predicate
 */
interface StatementInterface
{
    /**
     * @param Predicate $predicate
     * @return static
     */
    public static function when($predicate): self;

    /**
     * @param Predicate $predicate
     * @return static
     */
    public function then($predicate): self;

    /**
     * @return bool
     */
    public function __invoke(): bool;
}
