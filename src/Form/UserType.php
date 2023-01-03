<?php

namespace App\Form;


use App\Entity\User;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse mail',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Rôle de l\'utilisateur',
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN'
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
                'multiple' => false,
                'expanded' => true,
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
                // on récupère le user (les données du form)
                $user = $event->getData();
                // et le form, vu qu'on est dans une fonction anonyme
                $form = $event->getForm();

                // est-ce qu'on est en edit ou en ajout ?
                if(is_null($user->getId())) {
                    // ID null -> ajout d'un user

                    // on ajoute le champ password configuré pour l'ajout
                    $form->add('password', RepeatedType::class, [
                        'constraints' => [
                            new NotBlank(),
                            new Regex("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/", "Votre mot de passe ne respecte pas les règles de sécurité.")
                        ],
                        'attr' => [
                            'class' => 'form-control'
                        ],
                        'type' => PasswordType::class,
                        'invalid_message' => 'Les deux mots de passe doivent être identiques !',
                        'first_options'  => [
                            'label' => 'Mot de passe',
                            'help' => 'Au moins 8 caractères, dont une lettre, un chiffre et un caractère spécial.'
                        ],
                        'second_options' => ['label' => 'Répétez votre mot de passe'],
                    ]);

                } else {
                    // ID non null -> modification d'un user existant

                    // on ajoute le champ password configuré pour la modif
                    $form->add('password', RepeatedType::class, [
                        'constraints' => new Regex("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/", "Votre mot de passe ne respecte pas les règles de sécurité."),
                        'type' => PasswordType::class,
                        'invalid_message' => 'Les deux mots de passe doivent être identiques !',
                        'first_options'  => [
                            'label' => 'Mot de passe',
                            'help' => 'Laissez vide si inchangé.'
                        ],
                        'attr' => [
                            'class' => 'form-control'
                        ],
                        'second_options' => ['label' => 'Répétez votre mot de passe'],
                    ]);
                }
            })
        ;

        // datatransformer pour convertir string<->array
        // @link https://symfony.com/doc/current/form/data_transformers.html
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($tagsAsArray) {
                    // transform the array to a string
                    return implode(', ', $tagsAsArray);
                },
                function ($tagsAsString) {
                    // transform the string back to an array
                    return explode(', ', $tagsAsString);
                }
            ))
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ]
        ]);
    }
}
