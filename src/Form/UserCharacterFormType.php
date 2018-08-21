<?php

namespace App\Form;

use App\Entity\UserCharacter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Game;

class UserCharacterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class)
            ->add('level', IntegerType::class)
            ->add('detail', TextareaType::class)
            ->add('game', EntityType::class, 
            [
                'class' => Game::class,
                'choice_label' => 'title',
                'expanded' => false,
                'multiple' => false,
                'label' => 'The list of games'
            ])
            ->add('picture', FileType::class, 
            [
                'label' => 'Choose a character picture...', 
                'required' => false
            ])
        ;

        if($options['standalone']){
            $builder->add(
                'Submit', 
                SubmitType::class,
                ['attr'=>['class'=>'btn-success btn-block btn-lg']]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserCharacter::class,
            'standalone' => false
        ]);
    }
}
