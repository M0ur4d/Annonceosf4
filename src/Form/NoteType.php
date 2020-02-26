<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Note;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class NoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('note')
            ->add('avis')
//            ->add('date_enregistrement')
//            ->add('membre_note_id')
            ->add('membre_notant_id', EntityType::class, [
                                                                'class' => User::class,
                                                                'choice_label' => 'pseudo',
                                                                'placeholder' => 'Choississez un membre'
                                                              ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Note::class,
        ]);
    }
}
