<?php

namespace App\Domain\Common\ValueObject;

abstract readonly class AbstractId implements \Stringable, \JsonSerializable
{
    public function jsonSerialize(): string
    {
        return (string) $this;
    }
}
