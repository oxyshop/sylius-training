<?php

declare(strict_types=1);

namespace App\Promotion\RuleChecker;

use App\Entity\Order\Order;
use App\Repository\OrderRepository;
use Sylius\Component\Promotion\Checker\Rule\RuleCheckerInterface;
use Sylius\Component\Promotion\Model\PromotionSubjectInterface;
use Webmozart\Assert\Assert;

final class AmountOfOrdersInTimePeriod implements RuleCheckerInterface
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
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

        return $configuration['limit'] <= $this->orderRepository->countPlacedByCustomerFromPeriod($customer, new \DateTime('-30 days'));
    }

}
