<?php

namespace App\Form;

use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonPhoneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName',null,[
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
                'label' => 'Last Name',
                'attr' => [
                    'placeholder' => 'Last Name',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
                'required' => true,
            ])
            ->add('phone',TelType::class,[
                'label' => 'Phone',
                'attr' => [
                    'placeholder' => 'Phone',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
                'required' => true,
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
