<?php

namespace App\Form;

use App\Entity\QuotientFamilial;
use App\Entity\Responsable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResponsableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setMethod("POST")
            ->add('nom', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('numRue', IntegerType::class, [
                'required'   => false,
                'attr' => ['max' => 999]
            ])
            ->add('rue', TextType::class, [
                'required'   => false,
            ])
            ->add('copos', NumberType::class, [
                'required'   => false,
                'attr' => ['pattern' => '/^[0-9]{8}$/', 'maxlength' => 5]
            ])
            ->add('ville', TextType::class, [
                'required'   => false,
            ])
            ->add('tel', TelType::class, [
                'required'   => false,
                'attr' => ['pattern' => '/^[0-9]{8}$/', 'maxlength' => 8]
            ])
            ->add('mail', EmailType::class, [
                'required'   => false,
            ])
            ->add('quotientfamilial', EntityType::class, [
                'class' => QuotientFamilial::class,
                'choice_label' => 'libelle',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Responsable::class,
        ]);
    }
}
