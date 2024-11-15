<?php

namespace App\Application\Util\Model;

class Level
{
    public function __construct(
        public int $level = 0,
        public string $class = '',
        public string $subClass = '',
    ) {}

    /**
     * @return array<string, int|string>
     */
    public function toArray(): array
    {
        return [
            'level' => $this->level,
            'class' => $this->class,
            'subClass' => $this->subClass,
        ];
    }
}
