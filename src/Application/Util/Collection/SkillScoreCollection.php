<?php

namespace App\Application\Util\Collection;

use App\Application\Util\Model\Level;
use App\Application\Util\Model\SkillScore;
use App\Domain\Common\AbstractCollection;

class SkillScoreCollection extends AbstractCollection
{
    public static function getClassName(): string
    {
        return SkillScore::class;
    }
}