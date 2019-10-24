<?php

declare(strict_types=1);

namespace App\Entity\Shipping;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\ShippingMethod as BaseShippingMethod;
use Sylius\Component\Shipping\Model\ShippingMethodTranslationInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_shipping_method")
 */
class ShippingMethod extends BaseShippingMethod
{
    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="App\Entity\Store", mappedBy="shippingMethod")
     */
    private $stores;

    public function __construct()
    {
        parent::__construct();
        $this->stores = new ArrayCollection();
    }

    protected function createTranslation(): ShippingMethodTranslationInterface
    {
        return new ShippingMethodTranslation();
    }
}
