<?php

declare(strict_types=1);

namespace App\ChannelContext;

use App\Entity\Customer\Customer;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Channel\Context\ChannelNotFoundException;
use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Sylius\Component\Customer\Context\CustomerContextInterface;

final class CustomerBasedChannelContext implements ChannelContextInterface
{
    /** @var CustomerContextInterface */
    private $context;
    /** @var ChannelRepositoryInterface */
    private $channelRepository;

    public function __construct(CustomerContextInterface $context, ChannelRepositoryInterface $channelRepository)
    {
        $this->context = $context;
        $this->channelRepository = $channelRepository;
    }

    public function getChannel(): ChannelInterface
    {
        /** @var null|Customer $customer */
        $customer = $this->context->getCustomer();
        $channels = $this->channelRepository->findAll();

        if (null !== $customer && null !== $customer->getGroup() && 'PREMIUM_GROUP' === $customer->getGroup()->getCode()) {
            return  $channels[1];
        }
        return  $channels[0];
    }
}
