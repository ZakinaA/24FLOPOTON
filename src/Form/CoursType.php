<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\TypeInstrument;
use App\Entity\Jour;
use App\Entity\Professeur;
use App\Entity\TypeCours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')
            ->add('ageMini')
            ->add('heureDebut', null, [
                'widget' => 'single_text',
            ])
            ->add('heureFin', null, [
                'widget' => 'single_text',
            ])
            ->add('typeInstrument', EntityType::class, [
                'class' => TypeInstrument::class,
                'choice_label' => 'libelle',
            ])
            ->add('jour', EntityType::class, [
                'class' => Jour::class,
                'choice_label' => 'libelle',
            ])
            ->add('professeur', EntityType::class, [
                'class' => Professeur::class,
                'choice_label' => 'nom',
            ])
            ->add('typeCours', EntityType::class, [
                'class' => TypeCours::class,
                'choice_label' => 'libelle',
            ])
            ->add('enregistrer', SubmitType::class, array('label' => 'Nouvel cours'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}
