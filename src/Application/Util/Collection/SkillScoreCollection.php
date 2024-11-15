<?php

namespace App\Application\Util\Collection;

use App\Application\Util\Model\SkillScore;
use App\Domain\Common\AbstractCollection;

/**
 * @extends AbstractCollection<SkillScore>
 */
class SkillScoreCollection extends AbstractCollection
{
    public static function getClassName(): string
    {
        return SkillScore::class;
    }
}
