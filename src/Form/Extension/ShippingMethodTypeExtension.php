<?php

declare(strict_types=1);

namespace App\Form\Extension;

use App\Entity\Store;
use Sylius\Bundle\ShippingBundle\Form\Type\ShippingMethodType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

final class ShippingMethodTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('stores', EntityType::class, [
            'multiple' => true,
            'class' => Store::class,
            'choice_value' => 'code',
            'choice_label' => 'name',
        ]);
    }

    public function getExtendedTypes(): iterable
    {
        yield ShippingMethodType::class;
    }
}
