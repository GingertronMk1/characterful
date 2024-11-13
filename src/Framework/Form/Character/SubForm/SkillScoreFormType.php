<?php

namespace App\Framework\Form\Character\SubForm;

use App\Application\Enum\SkillEnum;
use App\Application\Util\Model\SkillScore;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SkillScoreFormType implements FormTypeInterface
{
    public function getParent(): string
    {
        return FormType::class;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SkillScore::class,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('skill', EnumType::class, [
                'class' => SkillEnum::class,
            ])
            ->add('proficiencies', IntegerType::class, [])
        ;
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        // TODO: Implement buildView() method.
    }

    public function finishView(FormView $view, FormInterface $form, array $options): void
    {
        // TODO: Implement finishView() method.
    }

    public function getBlockPrefix(): string
    {
        return 'level';
    }
}
