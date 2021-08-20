<?php

namespace App\Form;

use App\Entity\Plato;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class NuevomenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('tipo', EntityType::class, [
            'class' => Plato::class,
            'choice_label' => function(?Plato $plato) {
                return $plato ? $plato->getNombre() : '';
            },
            'multiple' => true,
            'expanded' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Plato::class,

        ]);
    }
}