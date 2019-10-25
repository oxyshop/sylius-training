<?php

declare(strict_types=1);

namespace App\Promotion\RuleChecker;

use App\Entity\Order\Order;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItem;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Promotion\Checker\Rule\RuleCheckerInterface;
use Sylius\Component\Promotion\Model\PromotionSubjectInterface;
use Webmozart\Assert\Assert;

final class AmountOfOrdersInTimePeriod implements RuleCheckerInterface
{
    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function isEligible(PromotionSubjectInterface $subject, array $configuration): bool
    {
        /** @var Order|mixed $subject */
        Assert::isInstanceOf($subject, Order::class);

        $customer = $subject->getCustomer();

        if (null === $customer) {
            return false;
        }

        $orders = $this->orderRepository->findByCustomer($customer);

        $i = 0;
        foreach ($orders as $order) {
            if ($order->getState() !== OrderInterface::STATE_CART && $order->getCheckoutCompletedAt() >= (new \DateTime('-30 days'))) {
                $i++;
            }
        }

        return $configuration['limit'] <= $i;
    }

}
