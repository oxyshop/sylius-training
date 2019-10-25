<?php

declare(strict_types=1);

namespace App\Form\Extension;

use Sylius\Bundle\MoneyBundle\Form\Type\MoneyType;
use Sylius\Bundle\PaymentBundle\Form\Type\PaymentMethodType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

final class PaymentMethodTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('fee', MoneyType::class);
    }

    public function getExtendedTypes(): iterable
    {
        yield PaymentMethodType::class;
    }

}
