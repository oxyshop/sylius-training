<?php

declare(strict_types=1);

namespace App\Checker;

use App\Entity\Customer\Customer;
use App\Entity\Product\ProductReview;

final class TrustedAuthorChecker
{
    public function check(ProductReview $review): bool
    {
        /** @var Customer $author */
        $author = $review->getAuthor();

        if (null === $author->getGroup() || $author->getGroup()->getCode() !== 'retail') {
            return false;
        }

        return  true;
    }
}
