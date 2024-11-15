<?php

namespace App\Application\Util\Collection;

use App\Application\Util\Model\AbilityScore;
use App\Domain\Common\AbstractCollection;

class AbilityScoreCollection extends AbstractCollection
{
    public static function getClassName(): string
    {
        return AbilityScore::class;
    }
}