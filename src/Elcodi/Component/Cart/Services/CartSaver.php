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

namespace Elcodi\Component\Cart\Services;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;

/**
 * Class CartSaver.
 *
 * Api Methods:
 *
 * * saveCart(CartInterface)
 *
 * @api
 */
class CartSaver
{
    /**
     * @var ObjectManager
     *
     * ObjectManager for Cart entity
     */
    private $cartObjectManager;

    /**
     * Built method.
     *
     * @param ObjectManager $cartObjectManager
     */
    public function __construct(ObjectManager $cartObjectManager)
    {
        $this->cartObjectManager = $cartObjectManager;
    }

    /**
     * Flushes all loaded cart and related entities.
     *
     * We only persist it if have lines loaded inside, so empty carts will never
     * be persisted
     *
     * @param CartInterface $cart
     */
    public function saveCart(CartInterface $cart)
    {
        $cartIsEmpty = $cart
            ->getCartLines()
            ->isEmpty();

        /**
         * If the cart is empty and no id is assigned yet, means that the cart
         * is just created empty, so no need to save anywhere
         */
        if (is_null($cart->getId())) {

            if ($cartIsEmpty) {
                return;
            }

            $this
                ->cartObjectManager
                ->persist($cart);
        }

        $this
            ->cartObjectManager
            ->flush();
    }
}
