<?php

namespace App\Form;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Transport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use App\Entity\Transpoteur;
use App\Entity\Vehicule;

class TransportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('num_t', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control mb-3', // Ajoutez les classes HTML personnalisées ici
                    'placeholder' => 'num_t', // Ajoutez le placeholder si nécessaire
                ],
            ])
            ->add('transpoteur', EntityType::class, [
                'class' => Transpoteur::class, // Remplacez Transporteur::class par le nom de votre entité Transporteur
                'choice_label' => 'num_ch', // Remplacez 'nom' par le nom de la propriété à afficher dans la liste des options
                'attr' => [
                    'class' => 'form-control mb-3', // Ajoutez des classes HTML personnalisées ici
                    'placeholder' => 'Sélectionnez un transporteur', // Ajoutez un libellé de placeholder
                ],
            ])
            ->add('Vehicule', EntityType::class, [
                'class' => Vehicule::class, // Remplacez Transporteur::class par le nom de votre entité Transporteur
                'choice_label' => 'num_v', // Remplacez 'nom' par le nom de la propriété à afficher dans la liste des options
                'attr' => [
                    'class' => 'form-control mb-3', // Ajoutez des classes HTML personnalisées ici
                    'placeholder' => 'Sélectionnez un Vehicule', // Ajoutez un libellé de placeholder
                ],
            ])
            ->add('dd', DateType::class, [
                'label' => 'Date de publication',
            ])
            ->add('da', DateType::class, [
                'label' => 'Date de publication',
            ])
            
            ->add('cout', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control mb-3', // Ajoutez les classes HTML personnalisées ici
                    'placeholder' => 'cout', // Ajoutez le placeholder si nécessaire
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transport::class,
        ]);
    }
}
