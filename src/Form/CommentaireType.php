<?php

namespace App\Form;


use App\Entity\Annonce;
use App\Entity\Commentaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('commentaire', TextareaType::class)


//            ->add('member_id', EntityType::class, array(
//                'class' => User::class,
//                'choice_label' => 'pseudo'
//            ))
           ->add('annonce_id', EntityType::class, array(
               'class' => Annonce::class,
               'choice_label' => 'titre'
           ))
//            ->add('date_enregistrement', DateType::class, [ "widget" => "single_text"] )

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}
