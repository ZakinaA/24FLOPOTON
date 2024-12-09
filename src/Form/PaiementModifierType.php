<?php

namespace App\Form;

use App\Entity\Paiement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PaiementModifierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant')
            ->add('datePaiement', null, [
                'widget' => 'single_text',
            ])
            /*->add('paiement', EntityType::class, [
                'class' => Paiement::class,
                'choice_label' => 'id',
            ])*/
            ->add('enregistrer', SubmitType::class, [
                'label' => 'Modifier cours'
            ])
        ;
    }

    public function getParent(){
        return PaiementType::class;
      }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Paiement::class,
        ]);
    }
}
