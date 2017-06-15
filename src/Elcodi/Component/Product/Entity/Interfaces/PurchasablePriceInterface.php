<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 */

declare(strict_types=1);

namespace Elcodi\Component\Product\Entity\Interfaces;

use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;

/**
 * Interface PurchasablePriceInterface.
 *
 * Defines common price members for a Purchasable
 */
interface PurchasablePriceInterface
{
    /**
     * Set price.
     *
     * @param MoneyInterface $amount
     */
    public function setPrice(MoneyInterface $amount);

    /**
     * Get price.
     *
     * @return MoneyInterface Price
     */
    public function getPrice();

    /**
     * Set price.
     *
     * @param MoneyInterface $amount
     */
    public function setReducedPrice(MoneyInterface $amount);

    /**
     * Get price.
     *
     * @return MoneyInterface
     */
    public function getReducedPrice();

    /**
     * Is in offer.
     *
     * @return bool
     */
    public function inOffer();

    /**
     * Get resolved price.
     *
     * @return MoneyInterface Reduced Price
     */
    public function getResolvedPrice();
}
