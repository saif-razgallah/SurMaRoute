<?php

namespace App\Form;

use App\Entity\Profil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType ;


class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('presentez_vous',TextareaType::class)
            ->add('musique')
            ->add('fumeur')
            ->add('animaux')
            ->add('discussion')
            ->add('adresse')
            ->add('code_postal')
            ->add('ville')
            ->add('pays')
            ->add('marque_voiture')
            ->add('modele_voiture')
            ->add('date_circulation')
            ->add('couleur_voiture')
            ->add('immatriculation_voiture')
            ->add('niveau_confort')
            ->add('identifiant_facebook')
            ->add('identifiant_twitter')
            ->add('identifiant_instagram')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profil::class,
        ]);
    }
}
