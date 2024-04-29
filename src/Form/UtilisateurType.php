<?php
namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class UtilisateurFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('numerodetelephone', IntegerType::class)
            ->add('email', EmailType::class)
            ->add('motdepasse', PasswordType::class)
            ->add('role', ChoiceType::class, [
                'choices' => [
                    'Utilisateur' => 'Simple_User',
                    'Administrateur' => 'Admin',
                    'Proprietaire' => 'Camp_Owner',
                ]
            ])
            ->add('photo_d', FileType::class, [
                'label' => 'Photo (JPEG, PNG, GIF)',
                'mapped' => false,
                'required' => true, // Rendre le champ obligatoire
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger un fichier image valide',
                    ])
                ]
                    ])
                  ->add('actif', CheckboxType::class, [
    'label' => 'Actif',
    'required' => false, // Ou true si vous voulez le rendre obligatoire
                  ]);
          
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}

