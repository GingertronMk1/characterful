<?php

namespace App\Domain\Common\ValueObject;

use JsonSerializable;
use Stringable;

abstract readonly class AbstractId implements Stringable, JsonSerializable
{
    public function jsonSerialize(): string
    {
        return (string) $this;
    }

}