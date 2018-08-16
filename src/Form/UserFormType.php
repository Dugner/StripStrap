<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\User;
use App\Entity\Document;

class UserFormType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, ['label'=>'Enter your username'])

            ->add('firstname', TextType::class, ['label'=> "What's your first name?"])

            ->add('lastname', TextType::class, ['label'=>"What's your lastname?"])

            ->add('password', RepeatedType::class, ['type'=>PasswordType::class, 'invalid_message'=>'The password filds should match.', 'first_options' =>array('label' => 'Password'), 'second_options' =>array('label' =>'Repeated Password')])

            ->add('email', EmailType::class)

            ->add('country', TextType::class, ['label'=>"Enter your country"])
            
            ->add('dateOfBirth', BirthdayType::class, array(
                'placeholder' => array(
                    'year' => 'Year', 'month' =>'Month', 'day' => 'Day')
            ))

            ->add('picture', FileType::class, array('label' => 'Choose a profile picture'), ['required'=>false]);
        if($options['standalone']){
            $builder->add('submit', SubmitType::class,
            ['attr'=>['class'=>'btn btn-info btn-block']]);
        }
    }

    public function configureOptions(OptionsResolver $resolver){
        $resolver->setDefaults([
            'data_class' => User::class,
            'standalone'=>false

        ]);
    }

}//class
