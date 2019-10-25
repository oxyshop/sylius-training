<?php

declare(strict_types=1);

namespace App\Entity\Payment;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\PaymentMethod as BasePaymentMethod;
use Sylius\Component\Payment\Model\PaymentMethodTranslationInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_payment_method")
 */
class PaymentMethod extends BasePaymentMethod
{
    /**
     * @var int|null
     * @ORM\Column(type="integer")
     */
    private $fee = 0;

    public function getFee(): ?int
    {
        return $this->fee;
    }

    public function setFee(?int $fee): void
    {
        $this->fee = $fee;
    }

    protected function createTranslation(): PaymentMethodTranslationInterface
    {
        return new PaymentMethodTranslation();
    }
}
