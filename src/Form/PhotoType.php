<?php

namespace App\Form;

use App\Entity\Photo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('photo1', FileType::class,[
                'label' => '1ere photo',
                'requred' => false,
            ])
            ->add('photo2', FileType::class,[
                'label' => '2eme photo',
                'requred' => false,
            ])
            ->add('photo3', FileType::class,[
                'label' => '3eme photo',
                'requred' => false,
            ])
            ->add('photo4', FileType::class,[
                'label' => '4eme photo',
                'requred' => false,
            ])
            ->add('photo5', FileType::class,[
                'label' => '5eme photo',
                'requred' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Photo::class,
        ]);
    }
}
