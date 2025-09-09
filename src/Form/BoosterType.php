<?php

namespace App\Form;

use App\Entity\Booster;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoosterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('gameName', null, [
                'label' => 'Nom du jeu',
            ])
            ->add('boosterName', null, [
                'label' => 'Nom du booster',
            ])
            ->add('cardCount', null, [
                'label' => 'Nombre de cartes',
            ])
            ->add('imageUrl', null, [
                'label' => 'Image du booster',
            ])
            ->add('backgroundUrl', null, [
                'label' => 'Fond du booster',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booster::class,
        ]);
    }
}
