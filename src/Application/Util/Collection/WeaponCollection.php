<?php

namespace App\Application\Util\Collection;

use App\Application\Util\Model\SkillScore;
use App\Application\Util\Model\Weapon;
use App\Domain\Common\AbstractCollection;

class WeaponCollection extends AbstractCollection
{
    public static function getClassName(): string
    {
        return Weapon::class;
    }
}