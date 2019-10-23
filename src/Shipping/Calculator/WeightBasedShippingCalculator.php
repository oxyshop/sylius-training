<?php

declare(strict_types=1);

namespace App\Shipping\Calculator;

use Sylius\Component\Core\Model\ShipmentInterface as CoreShipmentInterface;
use Sylius\Component\Shipping\Calculator\CalculatorInterface;
use Sylius\Component\Shipping\Model\ShipmentInterface;
use Symfony\Component\VarDumper\VarDumper;
use Webmozart\Assert\Assert;

final class WeightBasedShippingCalculator implements CalculatorInterface
{
    public function calculate(ShipmentInterface $subject, array $configuration): int
    {
        /** @var CoreShipmentInterface|ShipmentInterface $subject */
        Assert::isInstanceOf($subject, CoreShipmentInterface::class);

        $items = $subject->getOrder()->getItems();
        $price = 0;

        foreach ($items as $item) {
            $weight = $item->getVariant()->getWeight();

            if ($weight > ($configuration['threshold'] ?? 0)) {
                $price += $configuration['special_price']  ?? 0;
                continue;
            }

            $price += $configuration['base_price'] ?? 0;
        }

        return $price;
    }

    public function getType(): string
    {
        return 'weight_type_rate';
    }
}
