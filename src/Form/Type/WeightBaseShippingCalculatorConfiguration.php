<?php

declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

final class WeightBaseShippingCalculatorConfiguration extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('base_price', IntegerType::class);
        $builder->add('special_price', IntegerType::class);
        $builder->add('threshold', IntegerType::class);
    }
}
