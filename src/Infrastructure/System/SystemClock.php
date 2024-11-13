<?php

namespace App\Infrastructure\System;

use App\Domain\Common\ValueObject\DateTime;
use App\Domain\Util\ClockInterface;

class SystemClock implements ClockInterface
{
    public function now(?string $modifier = null): DateTime
    {
        $dateTime = new \DateTimeImmutable();
        if (null !== $modifier) {
            $dateTime = $dateTime->modify($modifier);
        }

        return DateTime::fromDateTimeInterface($dateTime);
    }
}
