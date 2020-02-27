<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Note;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints as Contraintes;

class NoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('note', NumberType::class,
                            ["attr" => [ "min" => 1, "max" => 5 ],
                            "constraints" => [
                            new Contraintes\NotBlank(["message" => "Vous devez atribuez une note"]),
                            new Contraintes\LessThanOrEqual(["value" => 5, "message" => "La note doit etre inferieur ou egale à 5"]),
                            new Contraintes\GreaterThan(["value" => 1, "message" => "La note doit etre superieure à 0"])

                            ]])
            ->add('avis')
//            ->add('date_enregistrement')
//            ->add('membre_note_id')
//            ->add('membre_notant_id', EntityType::class, [
//                                                                'class' => User::class,
//                                                                'choice_label' => 'pseudo',
//                                                                'placeholder' => 'Choississez un membre'
//                                                              ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Note::class,
        ]);
    }
}
