<?php

declare(strict_types=1);

namespace App\Promotion\Action;

use App\Entity\Order\Order;
use App\Entity\Order\OrderItem;
use Sylius\Component\Core\Factory\CartItemFactoryInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Order\Modifier\OrderItemQuantityModifierInterface;
use Sylius\Component\Promotion\Action\PromotionActionCommandInterface;
use Sylius\Component\Promotion\Model\PromotionInterface;
use Sylius\Component\Promotion\Model\PromotionSubjectInterface;
use Webmozart\Assert\Assert;

final class FreeGiftPromotionActionCommand implements PromotionActionCommandInterface
{
    /**
     * @var CartItemFactoryInterface
     */
    private $cartItemFactory;
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var OrderItemQuantityModifierInterface
     */
    private $itemQuantityModifier;

    public function __construct(
        CartItemFactoryInterface $cartItemFactory,
        ProductRepositoryInterface $productRepository,
        OrderItemQuantityModifierInterface $itemQuantityModifier
    ) {
        $this->cartItemFactory = $cartItemFactory;
        $this->productRepository = $productRepository;
        $this->itemQuantityModifier = $itemQuantityModifier;
    }

    public function execute(
        PromotionSubjectInterface $subject,
        array $configuration,
        PromotionInterface $promotion
    ): bool {
        /** @var Order|mixed $subject */
        Assert::isInstanceOf($subject, Order::class);

        $orderItem = $this->cartItemFactory->createForProduct($this->productRepository->findOneBy([]));
        $orderItem->setImmutable(true);
        $orderItem->setUnitPrice(0);
        $this->itemQuantityModifier->modify($orderItem, 1);

        $subject->addItem($orderItem);

        return true;
    }

    public function revert(
        PromotionSubjectInterface $subject,
        array $configuration,
        PromotionInterface $promotion
    ): void {
        /** @var Order $subject */
        $items = $subject->getItems();

        $product = $this->productRepository->findOneBy([]);
        /** @var OrderItem $item */
        foreach ($items as $item) {
            if ($item->getProduct() === $product) {
                $subject->removeItem($item);
            }
        }
    }

}
