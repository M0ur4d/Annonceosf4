<?php

namespace App\Form;

use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\User;
use App\Entity\Photo;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('description_courte')
            ->add('description_longue')
            ->add('prix')
            ->add('adresse')
            ->add('cp')
            ->add('pays')
//            ->add('date_enregistrement')
            ->add('ville')
            ->add('member_id', EntityType::class, [
                                                                'class' => User::class,
                                                                'choice_label' => 'pseudo',
                                                                'placeholder' => 'Choississez un membre'
                                                              ])


            ->add('categorie_id', EntityType::class, [
                                                                'class' => Categorie::class,
                                                                "choice_label"  => function(Categorie $cat){
                                                                    return $cat->getTitre() . " (" . substr($cat->getMotscles(), 0, 10) . "...)";},
                                                                'placeholder' => 'Choississez une categorie'
                                                                ])
//            ->add('photo_id')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
