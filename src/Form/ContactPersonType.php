<?php

namespace App\Form;

use App\Entity\ContactPerson;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

class ContactPersonType extends AbstractType
{
    private array $relationType = [
        'Spouse',
        'Mother',
        'Father',
        'Other Family Member',
        'Friend',
    ];

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('relationship', ChoiceType::class, [
                'choices' => array_combine($this->relationType, $this->relationType),
//                "choices_as_values" => true,
                'choice_value' => function ($choice) {
                    return $choice;
                },
                'label' => 'Relationship to Contact Person',
                'attr' => [
                    'placeholder' => 'Relationship to Contact Person',
                ],
//                'row_attr' => [
//                    'class' => 'form-floating',
//                ],
                'label_attr' => [
                    'class' => 'radio-inline',
                ],
                'expanded' => true,
                'required' => true,
                'constraints' => [
                    new NotNull(
                        message: 'What the contact persons relation to you?'
                    ),
                ],
            ])
            ->add('details', PersonPhoneType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactPerson::class,
        ]);
    }
}
