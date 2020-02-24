<?php

namespace App\Form;

use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\User;
use App\Entity\Photo;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Validator\Constraints\File;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('description_courte')
            ->add('description_longue', TextareaType::class)
            ->add('prix')
            ->add('adresse')
            ->add('cp')
            ->add('pays')
            ->add('ville')
//            ->add('member_id', EntityType::class, [
//                                                                'class' => User::class,
//                                                                'choice_label' => 'pseudo',
//                                                                'placeholder' => 'Choississez un membre'
//                                                              ])


            ->add('categorie_id', EntityType::class, [
                                                                'class' => Categorie::class,
                                                                "choice_label"  => function(Categorie $cat){
                                                                    return $cat->getTitre() . " (" . substr($cat->getMotscles(), 0, 10) . "...)";},
                                                                'placeholder' => 'Choississez une categorie'
                                                                ])
//            ->add('photo_id', FileType::class, [
//                'label' => '1ère Photo',
//                "required"  => false
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
