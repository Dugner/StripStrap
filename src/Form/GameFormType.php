<?php

namespace App\Form;

use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Document;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class GameFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label'=>'Enter your title'])
            ->add('description', TextareaType::class, ['label'=>'Enter your game Description'])
            ->add('picture',
                FileType::class,
                array('label'=> 'Choose a game Picture'),
                ['required' => false]
                )
        ;

        if($options['standalone']){
            $builder->add(
                'submit', 
                SubmitType::class,
                ['attr'=>['class'=>'btn-success btn-block']]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
            'standalone' => false
        ]);
    }
}
