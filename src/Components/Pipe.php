<?php

namespace Smoren\Sequence\Components;

use Smoren\Sequence\Exceptions\ReadOnlyException;
use function Smoren\Sequence\Functions\reduce;

class Pipe implements \ArrayAccess
{
    protected array $funcs = [];

    public function __invoke($x)
    {
        return reduce($this->funcs, fn ($carry, $func) => $func($carry), $x);
    }

    public function offsetSet($offset, $value): void
    {
        if ($offset !== null) {
            throw new ReadOnlyException();
        }

        if (!is_callable($value)) {
            throw new \InvalidArgumentException();
        }

        $this->funcs[] = $value;
    }

    public function offsetExists($offset)
    {
        throw new ReadOnlyException();
    }

    public function offsetGet($offset)
    {
        throw new ReadOnlyException();
    }

    public function offsetUnset($offset)
    {
        throw new ReadOnlyException();
    }
}
