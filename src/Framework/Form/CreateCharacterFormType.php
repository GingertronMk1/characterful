<?php

namespace App\Framework\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CreateCharacterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add(
                'levels',
                CollectionType::class,
                [
                    'entry_type' => LevelFormType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                ]
            )
            ->add('armour_class', CollectionType::class, [
                'entry_type' => TextType::class,
            ])
            ->add('proficiency_bonus', NumberType::class, [])
            ->add('speed', NumberType::class, [])
            ->add('passive_perception', NumberType::class, [])
            ->add('current_hit_points', NumberType::class, [])
            ->add('max_hit_points', NumberType::class, [])
            ->add('temporary_hit_points', NumberType::class, [])
            ->add('weapons', CollectionType::class, [
                'entry_type' => TextType::class,
            ])
            ->add('armours', CollectionType::class, [
                'entry_type' => TextType::class,
            ])
            ->add('abilities', CollectionType::class, [
                'entry_type' => AbilityScoreFormType::class,
                'entry_options' => [
                    'label' => false,
                ],
            ])
            ->add('skills', CollectionType::class, [
                'entry_type' => TextType::class,
            ])
            ->add('saving_throws', CollectionType::class, [
                'entry_type' => TextType::class,
            ])
            ->add('hit_dice_type', TextType::class, [])
            ->add('current_hit_dice', NumberType::class, [])
            ->add('max_hit_dice', NumberType::class, [])
            ->add('submit', SubmitType::class)
        ;
    }
}
