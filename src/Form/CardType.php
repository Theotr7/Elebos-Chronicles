<?php

namespace App\Form;

use App\Entity\Card;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $abilityChoices = [
            'Feu' => 'fire',
            'Tremblement de terre' => 'earthquake',
            'Glace' => 'ice',
            'Sorcellerie' => 'lightning',
            'Défense' => 'shield',
            'Attaque' => 'swords',
            'Téléportation' => 'teleport',
            'Choc' => 'thunderbolt',
            'Tornade' => 'tornado',
            'Régénération' => 'regeneration',
            'Amélioration' => 'buff',
            'Lumière' => 'light',
        ];

        $builder
            ->add('name', null, [
                'label' => 'Nom de la carte'
            ])
            ->add('hp', null, [
                'label' => 'Points de vie (HP)'
            ])
            ->add('cost', null, [
                'label' => 'Coût'
            ])
            ->add('imageUrl', null, [
                'label' => 'URL de l\'image'
            ])
            ->add('category', null, [
                'label' => 'Catégorie'
            ])
            
            
            ->add('ability1Name', null, [
                'label' => 'Nom de l\'ability 1'
            ])
            ->add('ability1Description', TextareaType::class, [
                'label' => 'Description de l\'ability 1'
            ])
            ->add('ability1Type', ChoiceType::class, [
                'choices' => $abilityChoices,
                'label' => 'Type d\'ability 1'
            ])

            
            ->add('ability2Name', null, [
                'required' => false,
                'label' => 'Nom de l\'ability 2'
            ])
            ->add('ability2Description', TextareaType::class, [
                'required' => false,
                'label' => 'Description de l\'ability 2'
            ])
            ->add('ability2Type', ChoiceType::class, [
                'choices' => $abilityChoices,
                'required' => false,
                'label' => 'Type d\'ability 2'
            ])

            ->add('quote', null, [
                'label' => 'Citation'
            ])
            ->add('rarity', ChoiceType::class, [
                'choices' => [
                    'Commune' => 'commune',
                    'Rare' => 'rare',
                    'Légendaire' => 'legendaire',
                    'Mythique' => 'mythique',
                ],
                'label' => 'Rareté'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Card::class,
        ]);
    }
}
