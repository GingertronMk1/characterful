<?php

namespace App\Application\Util\Collection;

use App\Application\Util\Model\Level;
use App\Domain\Common\AbstractCollection;

class LevelCollection extends AbstractCollection
{
    public static function getClassName(): string
    {
        return Level::class;
    }
}