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

namespace Elcodi\Component\Cart\Transformer;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Cart\EventDispatcher\OrderEventDispatcher;
use Elcodi\Component\Cart\Factory\OrderFactory;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;

/**
 * Class CartOrderTransformer.
 *
 * This class is intended to create an Order given a Cart.
 * The scope of this class are both implementations
 *
 * Api Methods:
 *
 * * createOrderFromCart(AbstractCart) : AbstractOrder
 *
 * @api
 */
class CartOrderTransformer
{
    /**
     * @var OrderEventDispatcher
     *
     * OrderEventDispatcher
     */
    private $orderEventDispatcher;

    /**
     * @var CartLineOrderLineTransformer
     *
     * CartLine to OrderLine transformer
     */
    private $cartLineOrderLineTransformer;

    /**
     * @var OrderFactory
     *
     * Order factory
     */
    private $orderFactory;

    /**
     * Construct method.
     *
     * @param OrderEventDispatcher         $orderEventDispatcher
     * @param CartLineOrderLineTransformer $cartLineOrderLineTransformer
     * @param OrderFactory                 $orderFactory
     */
    public function __construct(
        OrderEventDispatcher $orderEventDispatcher,
        CartLineOrderLineTransformer $cartLineOrderLineTransformer,
        OrderFactory $orderFactory
    ) {
        $this->orderEventDispatcher = $orderEventDispatcher;
        $this->cartLineOrderLineTransformer = $cartLineOrderLineTransformer;
        $this->orderFactory = $orderFactory;
    }

    /**
     * This method creates a Order given a Cart.
     *
     * If cart has a order, this one is taken as order to be used, otherwise
     * new order will be created from the scratch
     *
     * This method dispatches these events
     *
     * ElcodiPurchaseEvents::ORDER_PRECREATED
     * ElcodiPurchaseEvents::ORDER_ONCREATED
     * ElcodiPurchaseEvents::ORDER_POSTCREATED
     *
     * @param CartInterface $cart Cart to create order from
     *
     * @return OrderInterface
     */
    public function createOrderFromCart(CartInterface $cart) : OrderInterface
    {
        $this
            ->orderEventDispatcher
            ->dispatchOrderPreCreatedEvent(
                $cart
            );

        $order = $cart->getOrder() instanceof OrderInterface
            ? $cart->getOrder()
            : $this->orderFactory->create();

        $cart->setOrder($order);

        $orderLines = $this
            ->cartLineOrderLineTransformer
            ->createOrderLinesByCartLines(
                $order,
                $cart->getCartLines()
            );

        /**
         * @var OrderInterface $order
         */
        $order->setCustomer($cart->getCustomer());
        $order->setCart($cart);
        $order->setQuantity($cart->getTotalItemNumber());
        $order->setPurchasableAmount($cart->getPurchasableAmount());
        $order->setShippingAmount($cart->getShippingAmount());
        $order->setAmount($cart->getAmount());
        $order->setHeight($cart->getHeight());
        $order->setWidth($cart->getWidth());
        $order->setDepth($cart->getDepth());
        $order->setWeight($cart->getWeight());
        $order->setBillingAddress($cart->getBillingAddress());
        $order->setDeliveryAddress($cart->getDeliveryAddress());
        $order->setOrderLines($orderLines);

        $couponAmount = $cart->getCouponAmount();
        if ($couponAmount instanceof MoneyInterface) {
            $order->setCouponAmount($couponAmount);
        }

        $this
            ->orderEventDispatcher
            ->dispatchOrderOnCreatedEvent(
                $cart,
                $order
            );

        return $order;
    }
}
