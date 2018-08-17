<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Role;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class UpdateUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', TextType::class, ['label' => 'Username:'])
            ->add('firstname', TextType::class, ['label' => 'Firstname:'])
            ->add('lastname', TextType::class, ['label' => 'Lastname:'])
            ->add('email', EmailType::class, ['label' => 'Email:'])
            ->add('country', TextType::class, ['label' => 'Country:'])
            ->add('dateOfBirth', BirthdayType::class, ['label' => 'Birthday:'])
            ->add('roles', EntityType::class, [
                'class' => Role::class,
                'expanded' => true,
                'multiple' => true,
                'label' => 'The list of roles a user can get:'
            ])
            ->add('characters', TextType::class, ['label' => 'Character:', 'required' => false]);

        if ($options['standalone'])
        {
            $builder->add('Update', SubmitType::class, ['attr' => ['class' => 'btn-success']]);
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
