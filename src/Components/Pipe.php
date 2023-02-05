<?php

namespace Smoren\Sequence\Components;

class Pipe
{
    /**
     * @var array<callable>
     */
    protected array $funcs = [];

    /**
     * @param array<callable> $funcs
     */
    public function __construct(array $funcs)
    {
        $this->funcs = $funcs;
    }

    /**
     * @param mixed $x
     * @return mixed
     */
    public function __invoke($x)
    {
        return array_reduce($this->funcs, fn ($carry, $func) => $func($carry), $x);
    }
}
