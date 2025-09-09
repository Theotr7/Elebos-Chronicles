<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CollectionFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $maxCostLimit = $options['max_cost_limit'];

        $builder
            ->add('rarity', ChoiceType::class, [
                'label' => 'Rareté',
                'required' => false,
                'choices' => [
                    'Commune' => 'commune',
                    'Rare' => 'rare',
                    'Légendaire' => 'legendaire',
                    'Mythique' => 'mythique',
                ],
                'placeholder' => '-- Toutes --',
            ])
            ->add('cost', IntegerType::class, [
                'label' => 'Coût',
                'required' => false,
                'attr' => [
                    'min' => 0,
                    'max' => $maxCostLimit,
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'method' => 'GET',
            'max_cost_limit' => null,
        ]);
    }
}
