<?php

namespace App\Domain\Util;

use App\Domain\Common\ValueObject\DateTime;

interface ClockInterface
{
    public function now(?string $modifier = null): DateTime;
}
