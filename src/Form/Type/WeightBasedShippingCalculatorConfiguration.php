<?php

declare(strict_types=1);

namespace App\Form\Type;

use Sylius\Bundle\MoneyBundle\Form\Type\MoneyType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class WeightBasedShippingCalculatorConfiguration extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('base_price', MoneyType::class, [
            'currency' => $options['currency'],
        ]);
        $builder->add('special_price', MoneyType::class, [
            'currency' => $options['currency'],
        ]);
        $builder->add('threshold', IntegerType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('currency');
    }
}
