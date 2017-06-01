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

namespace Elcodi\Component\Product\StockValidator\Traits;

use Traversable;

use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Product\StockValidator\Interfaces\PurchasableStockValidatorInterface;

/**
 * Trait PurchasableStockValidatorCollectorTrait.
 */
trait PurchasableStockValidatorCollectorTrait
{
    /**
     * @var PurchasableStockValidatorInterface[]
     *
     * Stock validator stack
     */
    private $validators = [];

    /**
     * Add stock validator.
     *
     * @param PurchasableStockValidatorInterface $validator
     */
    public function addPurchasableStockValidator(PurchasableStockValidatorInterface $validator)
    {
        $this->validators[] = $validator;
    }

    /**
     * Update stock for a set of Purchasable instances given a collection of
     * stock updaters loaded.
     *
     * * If all elements are valid, then the whole collection is valid
     * * If one of them is invalid, then the whole collection is invalid
     * * Otherwise, will return the minimum of available stocks
     *
     * @param Traversable $purchasables
     * @param int         $stockToDecrease
     * @param bool        $useStock
     *
     * @return bool
     */
    protected function areValidByLoadedValidators(
        Traversable $purchasables,
        int $stockToDecrease,
        bool $useStock
    ) : bool {
        $maximumStockAvailable = null;

        foreach ($purchasables as $purchasable) {
            $purchasableIsValid = $this->isValidByLoadedValidators(
                $purchasable,
                $stockToDecrease,
                $useStock
            );

            if (false === $purchasableIsValid) {
                return false;
            }

            if (is_int($purchasableIsValid)) {
                $maximumStockAvailable = is_null($maximumStockAvailable)
                    ? $purchasableIsValid
                    : min($maximumStockAvailable, $purchasableIsValid);
            }
        }

        if (is_null($maximumStockAvailable)) {
            return true;
        }

        return $maximumStockAvailable > 0
            ? $maximumStockAvailable
            : false;
    }

    /**
     * Gets purchasable validation.
     *
     * @param PurchasableInterface $purchasable   Purchasable
     * @param int                  $stockRequired Stock required
     * @param bool                 $useStock      Use stock
     *
     * @return bool|int
     */
    protected function isValidByLoadedValidators(
        PurchasableInterface $purchasable,
        int $stockRequired,
        bool $useStock
    ) {
        foreach ($this->validators as $validator) {
            $stockUpdateNamespace = $validator->getPurchasableNamespace();
            if ($purchasable instanceof $stockUpdateNamespace) {
                return $validator->isStockAvailable(
                    $purchasable,
                    $stockRequired,
                    $useStock
                );
            }
        }

        return false;
    }
}