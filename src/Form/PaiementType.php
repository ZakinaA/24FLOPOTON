<?php

namespace App\Form;

use App\Entity\Inscription;
use App\Entity\Paiement;
use App\Entity\Eleve;
use App\Entity\Cours;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PaiementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant')
            ->add('datePaiement', null, [
                'widget' => 'single_text',
            ])
            ->add('inscription', EntityType::class, [
                'class' => Inscription::class,
                'choice_label' => function ($inscription) {
                    return $inscription->getEleve()->getPrenom() . ' ' . $inscription->getEleve()->getNom() . ' - ' . $inscription->getCours()->getLibelle();
                },
            ])
            ->add('enregistrer', SubmitType::class, array('label' => 'Nouveau paiement'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Paiement::class,
        ]);
    }
}
