<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Order\Order;
use App\Entity\Order\OrderItem;
use Sylius\Component\Order\StateResolver\StateResolverInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\VarDumper\VarDumper;

final class CheckoutStateResolverListener
{
    /**
     * @var StateResolverInterface
     */
    private $checkoutStateResolver;

    public function __construct(StateResolverInterface $checkoutStateResolver)
    {
        $this->checkoutStateResolver = $checkoutStateResolver;
    }

    public function onCartUpdate(GenericEvent $event): void
    {
        /** @var Order $subject */
        $subject = $event->getSubject();

        $this->checkoutStateResolver->resolve($subject);
        VarDumper::dump($subject);
    }

    public function onCartItemUpdate(GenericEvent $event): void
    {
        /** @var OrderItem $subject */
        $subject = $event->getSubject();

        $this->checkoutStateResolver->resolve($subject->getOrder());

        VarDumper::dump($subject->getOrder());
    }
}
