<?php

declare(strict_types=1);

namespace App\Repository;

use Sylius\Bundle\CoreBundle\Doctrine\ORM\OrderRepository as BaseOrderRepositoryAlias;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\OrderInterface;

final class OrderRepository extends BaseOrderRepositoryAlias
{
    public function countPlacedByCustomerFromPeriod(CustomerInterface $customer, \DateTime $period): int
    {
        return (int) $this->createQueryBuilder('o')
            ->select('COUNT(o.id)')
            ->andWhere('o.customer = :customer')
            ->andWhere('o.state NOT IN (:states)')
            ->andWhere('o.checkoutCompletedAt > :period')
            ->setParameter('customer', $customer)
            ->setParameter('states', [OrderInterface::STATE_CART, OrderInterface::STATE_CANCELLED])
            ->setParameter('period', $period)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
}
