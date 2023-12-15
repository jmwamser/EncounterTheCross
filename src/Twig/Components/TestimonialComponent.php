<?php

namespace App\Twig\Components;

use App\Entity\Testimonial;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent('testimonial')]
final class TestimonialComponent
{
    use GridConfigurationTrait;

    public Testimonial $testimonial;
    public bool $isLayoutFeatured;
    public bool $isLayoutHalfRight;
    public bool $isLayoutGrid;
    public string $background;
    public bool $createWrapper;

    public function mount(array $size, ?string $background): void
    {
        $this->setCardColumns($size);
        $this->background = $background ?? '';
    }

    #[PreMount]
    public function preMount(array $data): array
    {
        // validate data
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'createWrapper' => false,
            'background' => null,
        ]);
        $resolver->setRequired([
            'testimonial',
            'isLayoutFeatured',
            'isLayoutHalfRight',
            'isLayoutGrid',
            'size',
        ]);
        $resolver->setAllowedTypes('testimonial', Testimonial::class);
        $resolver->setAllowedTypes('isLayoutFeatured', 'bool');
        $resolver->setAllowedTypes('isLayoutHalfRight', 'bool');
        $resolver->setAllowedTypes('isLayoutGrid', 'bool');
        $resolver->setAllowedTypes('size', 'array');
        $resolver->setAllowedTypes('createWrapper', 'bool');
        $resolver->setAllowedTypes('background', ['string', 'null']);

        return $resolver->resolve($data);
    }
}
