<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Product\ProductReview;
use Sylius\Component\Mailer\Sender\SenderInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webmozart\Assert\Assert;

final class ReviewAcceptedSender
{
    /**
     * @var SenderInterface
     */
    private $sender;

    public function __construct(SenderInterface $sender)
    {
        $this->sender = $sender;
    }

    public function __invoke(GenericEvent $event): void
    {
        /** @var ProductReview|mixed $review */
        $review = $event->getSubject();

        Assert::isInstanceOf($review, ProductReview::class);

        $this->sender->send(
            'app_review_accepted',
            [$review->getAuthor()->getEmail()],
            ['review' => $review]
        );
    }
}
