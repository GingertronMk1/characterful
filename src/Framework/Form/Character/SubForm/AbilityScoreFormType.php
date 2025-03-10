<?php

namespace App\Framework\Form\Character\SubForm;

use App\Application\Enum\AbilityEnum;
use App\Application\Util\Model\AbilityScore;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AbilityScoreFormType implements FormTypeInterface
{
    public function getParent(): string
    {
        return FormType::class;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AbilityScore::class,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ability', EnumType::class, [
                'class' => AbilityEnum::class,
            ])
            ->add('value', IntegerType::class, [])
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
