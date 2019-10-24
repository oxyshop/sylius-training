<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Customer\Customer;
use App\Entity\Product\ProductReview;
use Doctrine\Common\Persistence\ObjectManager;
use SM\Factory\FactoryInterface;
use Sylius\Component\Core\ProductReviewTransitions;
use Sylius\Component\Review\Model\Review;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webmozart\Assert\Assert;

final class AutomaticReviewApproval
{
    /** @var FactoryInterface */
    private $factory;
    /** @var ObjectManager */
    private $manager;

    public function __construct(FactoryInterface $factory, ObjectManager $manager)
    {
        $this->factory = $factory;
        $this->manager = $manager;
    }

    public function __invoke(GenericEvent $event): void
    {
        /** @var ProductReview|mixed $review */
        $review = $event->getSubject();

        Assert::isInstanceOf($review, ProductReview::class);

        $stateMachine = $this->factory->get($review, ProductReviewTransitions::GRAPH);

        /** @var Customer $author */
        $author = $review->getAuthor();

        if (null === $author->getGroup() || $author->getGroup()->getCode() !== 'retail') {
            return;
        }

        $stateMachine->apply(ProductReviewTransitions::TRANSITION_ACCEPT);

        $this->manager->flush();
    }
}
