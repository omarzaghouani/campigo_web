<?php

namespace App\Form;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Vehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\FileType; // Import FileType
use App\Entity\Transpoteur;

class VehiculeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('num_v', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control mb-3', // Add custom HTML classes here
                    'placeholder' => 'num_v', // Add placeholder if needed
                ],
            ])
            ->add('type', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3', // Add custom HTML classes here
                    'placeholder' => 'type', // Add placeholder if needed
                ],
            ])
            ->add('capacite', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control mb-3', // Add custom HTML classes here
                    'placeholder' => 'capacite', // Add placeholder if needed
                ],
            ])
            ->add('prixuni', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control mb-3', // Add custom HTML classes here
                    'placeholder' => 'prixuni', // Add placeholder if needed
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
            ->add('photo', FileType::class, [ // Add photo field
                'label' => 'Photo', // Label for the field
                'required' => false, // Allow the field to be empty
                'mapped' => false, // Do not map this field to the entity property
                'attr' => [
                    'class' => 'form-control mb-3', // Add custom HTML classes here
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicule::class,
        ]);
    }
}
