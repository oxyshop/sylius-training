<?php

declare(strict_types=1);

namespace App\Form\Type;

use Sylius\Bundle\CoreBundle\Form\Type\ChannelCollectionType;
use Sylius\Bundle\ShippingBundle\Form\Type\Calculator\FlatRateConfigurationType;
use Sylius\Component\Core\Model\ChannelInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ChannelAwareWeightBasedShippingCalculatorConfigurationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'entry_type' => WeightBasedShippingCalculatorConfiguration::class,
            'entry_options' => function (ChannelInterface $channel): array {
                return [
                    'label' => $channel->getName(),
                    'currency' => $channel->getBaseCurrency()->getCode(),
                ];
            },
        ]);
    }

    public function getParent(): string
    {
        return ChannelCollectionType::class;
    }
}
