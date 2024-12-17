<?php

namespace App\Form;

use App\Entity\QuotientFamilial;
use App\Entity\Tarif;
use App\Entity\TypeCours;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TarifEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant')
            ->add('TypeCours', EntityType::class, [
                'class' => TypeCours::class,
                'choice_label' => 'libelle',
            ])
            ->add('QuotientFamilial', EntityType::class, [
                'class' => QuotientFamilial::class,
                'choice_label' => 'libelle',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Modifier cours'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tarif::class,
        ]);
    }
}
