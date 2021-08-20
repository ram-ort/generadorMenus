<?php

namespace App\Form;

use App\Entity\Plato;
use App\Entity\Tipoplato;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PlatoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nombre', TextType::class)
        ->add('calorias', NumberType::class)
        ->add('tipo', EntityType::class, [
            'class' => Tipoplato::class,
            'choice_label' => function(?Tipoplato $tipo) {
                return $tipo ? $tipo->getNombre() : '';
            },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Plato::class,
        ]);
    }
}