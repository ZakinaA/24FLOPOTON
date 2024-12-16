<?php

namespace App\Form;

use App\Entity\Contrat;
use App\Entity\Eleve;
use App\Entity\Instrument;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContratType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut', null, [
                'widget' => 'single_text',
            ])
            ->add('dateFin', null, [
                'widget' => 'single_text',
            ])
            ->add('etatDetailleDebut')
            ->add('etatDetailleFin')
            ->add('eleve', EntityType::class, [
                'class' => Eleve::class,
                'choice_label' => 'nom',
            ])
            ->add('instrument', EntityType::class, [
                'class' => Instrument::class,
                'choice_label' => function ($instrument) {
                return $instrument->getTypeInstrument()->getLibelle() . ' - ' . $instrument->getNumSerie();}
            ])
            ->add('enregistrer', SubmitType::class, options: array('label' => 'nouveau contrat'))

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contrat::class,
        ]);
    }
}
