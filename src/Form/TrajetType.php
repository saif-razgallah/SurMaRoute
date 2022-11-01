<?php

namespace App\Form;

use App\Entity\Trajet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrajetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type_utilisateur')
            ->add('ville_depart')
            ->add('ville_arrivee')
            ->add('date_depart')
            ->add('heure_depart')
            ->add('autoroute')
            ->add('frequence')
            ->add('type_trajet')
            ->add('prix')
            ->add('distance')
            ->add('duree_estimee')
            ->add('nbr_place')
           // ->add('utilisateur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trajet::class,
        ]);
    }
}
