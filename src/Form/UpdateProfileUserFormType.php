<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UpdateProfileUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', TextType::class, [ 'label' => 'Username' ])
                ->add('firstname', TextType::class, [ 'label' => "Firstname" ])
                ->add('lastname', TextType::class, [ 'label' => "Lastname" ])
                ->add('email', EmailType::class)
                ->add('country', TextType::class, [ 'label' => "Country" ])
                ->add('dateOfBirth', BirthdayType::class, [
                        'placeholder' => 
                        [
                            'year' => 'Year', 
                            'month' =>'Month', 
                            'day' => 'Day'
                        ]
                    ])                   
                ->add('picture', FileType::class,
                    [
                        'label' => 'Profile picture', 
                        'required' => false
                    ]);

        if($options['standalone']){
            $builder->add('submit', SubmitType::class,
            ['attr'=>['class'=>'btn btn-success btn-block btn-lg']]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'standalone' => false,
            'validation_groups' => ['update']
        ]);
    }
}
