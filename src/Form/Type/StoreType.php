<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\Shipping\ShippingMethod;
use Sylius\Bundle\ResourceBundle\Form\EventSubscriber\AddCodeFormSubscriber;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class StoreType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('name', TextType::class);
        $builder->add('email', EmailType::class);
        $builder->add('lat', NumberType::class);
        $builder->add('lon', NumberType::class);
        $builder->addEventSubscriber(new AddCodeFormSubscriber());
        $builder->add('shippingMethod', EntityType::class, [
            'class' => ShippingMethod::class,
            'choice_label' => 'name',
            'choice_value' => 'code',
        ]);
    }
}
