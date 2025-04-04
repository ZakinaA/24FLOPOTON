<?php

namespace App\Form;

use App\Entity\Instrument;
use App\Entity\Intervention;
use App\Entity\Professionnel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InterventionType extends AbstractType
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
            ->add('descriptif')
            ->add('prix')
            ->add('quotite')
            ->add('professionnel', EntityType::class, [
                'class' => Professionnel::class,
                'choice_label' => 'nom',
            ])
            ->add('instrument', EntityType::class, [
                'class' => Instrument::class,
                'choice_label' => function ($instrument) {
                    return $instrument->getTypeInstrument()->getLibelle() . ' - ' . $instrument->getNumSerie();},
            ])
            ->add('enregistrer', SubmitType::class, options: array('label' => 'nouvelle intervention'))

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Intervention::class,
        ]);
    }
}
