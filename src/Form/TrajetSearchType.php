<?php

namespace App\Form;

use App\Entity\TrajetSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class TrajetSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('villeDepart',TextType::class,[
                            'required'=>true,
                            //'label'=>true,
                            'attr'=>['placeholder'=>'Lieu de départ','autocomplete'=>"off"]])
            ->add('villeArrivee',TextType::class,[
                            'required'=>true,
                            //'label'=>true,
                            'attr'=>['placeholder'=>"Lieu d'arrivée",'autocomplete'=>"off"]])
            ->add('dateDepart', DateType::class, [
                           'widget' => 'single_text',
                           'html5' => false,
                           'required'=>false,
                           'format' => 'dd-MM-yyyy',
                           'attr' => ['class' => 'js-datepicker',
                                      'placeholder'=>"Date",
                                      'autocomplete'=>"off"],
                            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TrajetSearch::class,
            'method' => 'get',
            'csrf_protection'=> false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
