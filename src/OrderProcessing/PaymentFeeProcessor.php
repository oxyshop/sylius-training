<?php

declare(strict_types=1);

namespace App\OrderProcessing;

use App\Entity\Order\Order;
use App\Entity\Payment\Payment;
use App\Entity\Payment\PaymentMethod;
use Payum\Core\Model\PaymentInterface;
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
        /** @var Order $order */
        $payments = $order->getPayments();

        /** @var Payment $payment */
        foreach ($payments as $payment) {
            if ($payment->getState() !== \Sylius\Component\Core\Model\PaymentInterface::STATE_CART) {
                continue;
            }

            /** @var PaymentMethod $paymentMethod */
            $paymentMethod = $payment->getMethod();

            $adjustment = $this->factory->createWithData('payment', 'Payment fee', $paymentMethod->getFee() ?? 0);

            $order->addAdjustment($adjustment);
        }
    }

}
