<?php

namespace App\Application\Enum;

enum SkillEnum: string
{
    case Acrobatics = 'Acrobatics';
    case Animal_Handling = 'Animal Handling';
    case Arcana = 'Arcana';
    case Athletics = 'Athletics';
    case Deception = 'Deception';
    case History = 'History';
    case Insight = 'Insight';
    case Intimidation = 'Intimidation';
    case Investigation = 'Investigation';
    case Medicine = 'Medicine';
    case Nature = 'Nature';
    case Perception = 'Perception';
    case Performance = 'Performance';
    case Persuasion = 'Persuasion';
    case Religion = 'Religion';
    case Sleight_of_Hand = 'Sleight of Hand';
    case Stealth = 'Stealth';
    case Survival = 'Survival';

    public function getAbilityEnum(): AbilityEnum
    {
        return match ($this) {
            self::Athletics => AbilityEnum::Strength,
            self::Acrobatics,
            self::Sleight_of_Hand,
            self::Stealth => AbilityEnum::Dexterity,
            self::Arcana,
            self::History,
            self::Investigation,
            self::Nature,
            self::Religion => AbilityEnum::Intelligence,
            self::Animal_Handling,
            self::Insight,
            self::Medicine,
            self::Perception,
            self::Survival => AbilityEnum::Wisdom,
            self::Deception,
            self::Intimidation,
            self::Performance,
            self::Persuasion => AbilityEnum::Charisma,
        };
    }
}
