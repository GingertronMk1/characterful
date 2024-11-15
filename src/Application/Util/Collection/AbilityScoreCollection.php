<?php

namespace App\Application\Util\Collection;

use App\Application\Util\Model\AbilityScore;
use App\Domain\Common\AbstractCollection;

/**
 * @extends AbstractCollection<AbilityScore>
 */
class AbilityScoreCollection extends AbstractCollection
{
    public static function getClassName(): string
    {
        return AbilityScore::class;
    }
}
