<?php

namespace App\Framework\Form;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LevelFormType implements FormTypeInterface
{
    public function getParent(): string
    {
        return FormType::class;
    }

    public function configureOptions(OptionsResolver $resolver) {}

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('class', TextType::class)
            ->add('subClass', TextType::class, ['required' => false])
            ->add('level', NumberType::class)
        ;
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        // TODO: Implement buildView() method.
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        // TODO: Implement finishView() method.
    }

    public function getBlockPrefix(): string
    {
        return 'level';
    }
}
