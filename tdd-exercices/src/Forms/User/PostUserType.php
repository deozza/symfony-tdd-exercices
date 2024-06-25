<?php

namespace App\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;

class PostUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', null, [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(min: 4, max: 50)
                ]
            ])
            ->add('email', null, [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Email()
                ]
            ])
            ->add('password', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(min: 4),
                    new Type('string')
                ]
            ])
        ;
    }
}