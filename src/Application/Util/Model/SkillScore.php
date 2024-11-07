<?php

namespace App\Application\Util\Model;

use App\Application\Enum\SkillEnum;

final class SkillScore
{
    public function __construct(
        public SkillEnum $skill,
        public int $proficiencies = 0,
    ) {}

    /**
     * @param array<array<string, int|string>> $arr
     *
     * @return self[]
     */
    public static function fromArray(array $arr): array
    {
        $returnVal = [];

        foreach ($arr as $value) {
            $returnVal[] = new self(SkillEnum::from($value['skill']), (int) $value['proficiencies']);
        }

        return $returnVal;
    }

    /**
     * @return array<self>
     */
    public static function getBase(): array
    {
        $returnVal = [];

        foreach (SkillEnum::cases() as $value) {
            $returnVal[] = new self($value);
        }

        return $returnVal;
    }

    /**
     * @return array<string, int|string>
     */
    public function toArray(): array
    {
        return [
            'skill' => $this->skill->value,
            'proficiencies' => $this->proficiencies,
        ];
    }
}
