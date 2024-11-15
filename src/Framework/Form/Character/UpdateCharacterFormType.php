<?php

namespace App\Framework\Form\Character;

use App\Application\Util\Model\Level;
use App\Application\Util\Model\Weapon;
use App\Framework\Form\Character\SubForm\AbilityScoreFormType;
use App\Framework\Form\Character\SubForm\LevelFormType;
use App\Framework\Form\Character\SubForm\SkillScoreFormType;
use App\Framework\Form\Character\SubForm\WeaponFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UpdateCharacterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('species', TextType::class)
            ->add('species_extra', TextType::class)
            ->add(
                'levels',
                CollectionType::class,
                [
                    'entry_type' => LevelFormType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'entry_options' => [
                        'data_class' => Level::class,
                        'label' => false,
                    ],
                ],
            )
            ->add('armour_class', CollectionType::class, [
                'entry_type' => TextType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('proficiency_bonus', IntegerType::class, [])
            ->add('speed', IntegerType::class, [])
            ->add('passive_perception', IntegerType::class, [])
            ->add('current_hit_points', IntegerType::class, [])
            ->add('max_hit_points', IntegerType::class, [])
            ->add('temporary_hit_points', IntegerType::class, [])
            ->add('weapons', CollectionType::class, [
                'entry_type' => WeaponFormType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'entry_options' => [
                    'label' => false,
                    'data_class' => Weapon::class,
                ],
            ])
            ->add('armours', CollectionType::class, [
                'entry_type' => TextType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('abilities', CollectionType::class, [
                'entry_type' => AbilityScoreFormType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'entry_options' => [
                    'label' => false,
                ],
            ])
            ->add('skills', CollectionType::class, [
                'entry_type' => SkillScoreFormType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'entry_options' => [
                    'label' => false,
                ],
            ])
            ->add('saving_throws', CollectionType::class, [
                'entry_type' => TextType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('hit_dice_type', IntegerType::class, [])
            ->add('current_hit_dice', IntegerType::class, [])
            ->add('max_hit_dice', IntegerType::class, [])
            ->add('submit', SubmitType::class)
        ;
    }
}
