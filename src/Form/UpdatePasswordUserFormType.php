<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UpdatePasswordUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('oldPassword', PasswordType::class, [
                    'label' => 'Old Password (needed if you want change it)',
                    'mapped' => false
                ])
                ->add('password', RepeatedType::class, 
                [
                    'type' => PasswordType::class, 
                    'invalid_message' => 'The password fields should match.',
                    'first_options' => [ 'label' => 'New Password' ], 
                    'second_options' => [ 'label' => 'Repeated new password' ]
                ]);

        if($options['standalone']) {
            $builder->add('submit', SubmitType::class,
            ['attr'=>['class'=>'btn btn-success btn-block btn-lg']]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'standalone' => false
        ]);
    }
}
