<?php

namespace App\Form;

use App\Entity\EventParticipant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Intl\Countries;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AttendeeEventParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('person', PersonType::class)
            ->add('line1',null,[
                'label' => 'Address',
                'attr' => [
                    'placeholder' => 'Address',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('line2',null,[
                'label' => 'Address 2',
                'attr' => [
                    'placeholder' => 'Address 2',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('city',null,[
                'label' => 'City',
                'attr' => [
                    'placeholder' => 'City',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('state', StateType::class)
            ->add('zipcode',null,[
                'label' => 'Zip',
                'attr' => [
                    'placeholder' => 'Zip',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('country',HiddenType::class,[
                'data' => Countries::exists('US') ? 'US' : '',
            ])

            ->add('attendeeContactPerson', ContactPersonType::class)

            ->add('church',null,[
                'label' => 'What church do you attend (if any)?',
                'attr' => [
                    'placeholder' => 'What church do you attend (if any)?',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('invitedBy',null,[
                'label' => 'Who invited you? Please provide full name of person.',
                'attr' => [
                    'placeholder' => 'Who invited you? Please provide full name of person.',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('type', HiddenType::class,[
                'data' => EventParticipant::TYPE_ATTENDEE,
            ])

            ->add('questionsOrComments', TextareaType::class,[
                'label' => 'Do you have any questions or comments?',
                'attr' => [
                    'placeholder' => 'Do you have any questions or comments?',
                    'style' => "height: 100px",
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('healthConcerns',TextareaType::class,[
                'label' => 'Do you have any dietary concerns, physical limitations or health concerns?',
                'attr' => [
                    'placeholder' => 'Do you have any dietary concerns, physical limitations or health concerns?',
                    'style' => "height: 100px",
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('launchPoint',null,[
                'label' => 'Launch Point',
                'attr' => [
                    'placeholder' => 'Launch Point',
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
            'data_class' => EventParticipant::class,
        ]);
    }
}
