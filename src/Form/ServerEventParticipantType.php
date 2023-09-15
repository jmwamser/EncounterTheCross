<?php

namespace App\Form;

use App\Entity\EventParticipant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Intl\Countries;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServerEventParticipantType extends AbstractType
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
                'required' => true,
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

            ->add('serverAttendedTimes', IntegerType::class, [
                'label' => 'How many times have you served at an Encounter prior to this one?',
                'attr' => [
                    'placeholder' => 'How many times have you served at an Encounter prior to this one?',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
                'required' => false,
            ])
            ->add('type', HiddenType::class,[
                'data' => EventParticipant::TYPE_SERVER,
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
                'required' => false,
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
                'required' => false,
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
            ->add('paymentMethod',ChoiceType::class,[
                'label' => 'Payment Method',
                'required' => true,
//                "choices_as_values" => true,
//                'choice_value' => function($choice) {
//                    return $choice;
//                },
                'choices' => array_merge([
                    'Select Payment Method' => null,
                ],
                    array_combine(['Pay at the door', 'Apply for Scholarship'],EventParticipant::PAYMENT_METHODS)
                ),
                'attr' => [
                    'placeholder' => 'Payment Method',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
//            ->add('event')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EventParticipant::class,
        ]);
    }
}
