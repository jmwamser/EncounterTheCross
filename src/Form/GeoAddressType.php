<?php

namespace App\Form;

use App\Entity\Location;
use Daften\Bundle\AddressingBundle\Form\Type\AddressEmbeddableType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GeoAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address', AddressEmbeddableType::class, [
                'allowed_countries' => [
                    'United States' => 'US',
                ],
                'preferred_countries' => ['US'],
                'default_country' => 'US',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
