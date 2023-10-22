<?php

namespace App\Form;

use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotNull;

class PersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName',null,[
                'constraints' => [
                    new NotNull(
                        message: 'You forgot to tell us your First Name.'
                    ),
                ],
                'label' => 'First Name',
                'attr' => [
                    'placeholder' => 'First Name',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
                'required' => true,
            ])
            ->add('lastName',null,[
                'constraints' => [
                    new NotNull(
                        message: 'You forgot to tell us your Last Name.'
                    ),
                ],
                'label' => 'Last Name',
                'attr' => [
                    'placeholder' => 'Last Name',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
                'required' => true,
            ])
            ->add('email',EmailType::class,[
                'constraints' => [
                    new NotNull(
                        message: 'Whats your email address.'
                    ),
                    new Email(),
                ],
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Email',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
                'required' => true,
            ])
            ->add('phone',TelType::class,[
                'constraints' => [
                    new NotNull(
                        message: 'You forgot to enter your phone number.'
                    ),
                ],
                'label' => 'Phone',
                'attr' => [
                    'placeholder' => 'Phone',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Person::class,
        ]);
    }
}
