<?php

namespace App\Form;

use App\Entity\Transpoteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class TranspoteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('num_ch', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'num_ch', // Change placeholder to num_ch
                ],
            ])
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'nom',
                ],
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'prenom',
                ],
            ])
            ->add('numtel', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'numtel',
                ],
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'email',
                ],
            ])
            ->add('daten', DateType::class, [
                'label' => 'Date de publication',
            ]);
       
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transpoteur::class,
        ]);
    }
}
