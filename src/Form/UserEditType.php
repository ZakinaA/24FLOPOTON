<?php

namespace App\Form;

use App\Entity\Responsable;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nom d\'utilisateur',
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Rôles',
                'choices' => [
                    //'Utilisateur' => 'ROLE_USER',
                    'Resp. Élève' => 'ROLE_RESPELEVE',
                    'Gestionnaire' => 'ROLE_GESTIONNAIRE',
                    'Administrateur' => 'ROLE_ADMIN',
                ],
                'expanded' => true,
                'multiple' => true,
                'data' => $options['user']->getRoles(),
            ])
            //->add('password', RepeatedType::class, [
            //    'type' => PasswordType::class,
            //    'first_options' => ['label' => 'Mot de passe'],
            //    'second_options' => ['label' => 'Confirmation du mot de passe'],
            //    'invalid_message' => 'Les mots de passe doivent correspondre.',
            //    'required' => false,
            //])
            ->add('responsable', ResponsableType::class, [
                'required' => false,
                'mapped' => false,
                'data' => $options['responsable'],
            ])
            ->add('save', SubmitType::class, ['label' => 'Modifier']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'user' => null,
            'responsable' => null,
        ]);
    }
}
