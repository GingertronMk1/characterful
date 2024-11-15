<?php

namespace App\Application\Util\Collection;

use App\Application\Util\Model\Weapon;
use App\Domain\Common\AbstractCollection;

/**
 * @extends AbstractCollection<Weapon>
 */
class WeaponCollection extends AbstractCollection
{
    public static function getClassName(): string
    {
        return Weapon::class;
    }
}
