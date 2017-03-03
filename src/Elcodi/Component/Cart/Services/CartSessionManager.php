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

use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;

/**
 * Class CartSessionManager.
 *
 * Manages all cart mapping in session
 *
 * Api Methods:
 *
 * * set(CartInterface)
 * * get()
 *
 * @api
 */
class CartSessionManager
{
    /**
     * @var SessionInterface
     *
     * Session
     */
    private $session;

    /**
     * @var string
     *
     * Session Field Name
     */
    private $sessionFieldName;

    /**
     * @var bool
     *
     * Save cart in session
     */
    private $saveInSession;

    /**
     * Construct method.
     *
     * @param SessionInterface $session          HTTP session
     * @param string           $sessionFieldName Session key representing cart
     * @param bool             $saveInSession    save cart in session
     */
    public function __construct(
        SessionInterface $session,
        $sessionFieldName,
        $saveInSession
    ) {
        $this->session = $session;
        $this->sessionFieldName = $sessionFieldName;
        $this->saveInSession = $saveInSession;
    }

    /**
     * Set Cart in session.
     *
     * @param CartInterface $cart
     */
    public function set(CartInterface $cart)
    {
        if (!$this->saveInSession) {
            return;
        }

        $this
            ->session
            ->set(
                $this->sessionFieldName,
                $cart->getId()
            );
    }

    /**
     * Get current cart id loaded in session.
     *
     * @return null|int
     */
    public function get() : ? int
    {
        return $this
            ->session
            ->get($this->sessionFieldName);
    }
}
