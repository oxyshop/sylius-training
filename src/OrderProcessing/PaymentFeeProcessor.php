<?php

declare(strict_types=1);

namespace App\OrderProcessing;

use Sylius\Component\Order\Factory\AdjustmentFactoryInterface;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Order\Processor\OrderProcessorInterface;

final class PaymentFeeProcessor implements OrderProcessorInterface
{
    /**
     * @var AdjustmentFactoryInterface
     */
    private $factory;

    public function __construct(AdjustmentFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function process(OrderInterface $order): void
    {
        $adjustment = $this->factory->createWithData('payment', 'Payment fee', 1000);

        $order->addAdjustment($adjustment);
    }

}
