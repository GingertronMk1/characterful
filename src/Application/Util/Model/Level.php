<?php

namespace App\Application\Util\Model;

class Level
{
    public function __construct(
        public int $level,
        public string $class,
        public string $subClass,
    ) {
    }
}
