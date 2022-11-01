<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;




class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('date_naissance',DateType::class, [
                                           'widget' => 'single_text',
                                           'html5' => false,
                                           'format' => 'yyyy-MM-dd',
                                           'attr' => ['class' => 'js-datepicker'],
                                            ])
            ->add('sexe',ChoiceType::class, [
                                            'choices' => [
                                                ''=>'',
                                                'Homme' => 'Homme',
                                                'Femme' => 'Femme',]
                                            ])
            ->add('telephone')
            /*->add('photo',FileType::class,array(
                        'label'=>'Choisissez votre photo',
                        'data_class' => null,
                        'required'=> false,
                    ))*/
            ->add('imageFile',FileType::class,[
                'mapped'=>false,
                'required'=> false,
                'label'=>'Choisissez votre photo',
                    ])        
            ->add('email')
            //->add('password')
            //->add('date_inscription')
            //->add('profil')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
