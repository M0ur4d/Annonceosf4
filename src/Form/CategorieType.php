<?php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints as Contraintes;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class,[ "attr"=>['placeholder' => 'Tapez le titre de la categorie'],
                                                         "constraints" => [
                                                                            new Contraintes\NotBlank(["message" => "Vous avez oublié de remplir ce champ"]),
                                                                            new Contraintes\Length(["min" => 2, "max" => 20,
                                                                                                    "minMessage" => "Le titre doit avoir plus de 2 caractères",
                                                                                                    "maxMessage" => "Le titre doit avoir moins de 20 caractères"
                                                                                                    ])
                                                                           ]
                                                       ])


            ->add('motscles', TextareaType::class,[ "label" => "Mots clés"
                                                                ,"attr"=>['placeholder' => 'Séparez les mots clés par des ", "']])
            // si on ne mes pas de balise <button> dans le  twig
            ->add("ajouter", SubmitType::class, ["label" => "Enregistrer"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
