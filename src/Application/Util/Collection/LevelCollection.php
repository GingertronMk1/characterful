<?php

namespace App\Application\Util\Collection;

use App\Application\Util\Model\Level;
use App\Domain\Common\AbstractCollection;

/**
 * @extends AbstractCollection<Level>
 */
class LevelCollection extends AbstractCollection
{
    public static function getClassName(): string
    {
        return Level::class;
    }
}
