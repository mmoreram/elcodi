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

namespace Elcodi\Component\User\Event;

use Symfony\Component\EventDispatcher\Event;

use Elcodi\Component\User\Entity\Interfaces\AbstractUserInterface;

/**
 * Event fired when a customer unsubscribes from newsletter.
 *
 * This event send an email to customer
 */
final class PasswordRememberEvent extends Event
{
    /**
     * @var AbstractUserInterface
     *
     * User
     */
    private $user;

    /**
     * @var string
     *
     * Remember url
     */
    private $rememberUrl;

    /**
     * Construct method.
     *
     * @param AbstractUserInterface $user
     * @param string                $rememberUrl
     */
    public function __construct(
        AbstractUserInterface $user,
        string $rememberUrl
    ) {
        $this->user = $user;
        $this->rememberUrl = $rememberUrl;
    }

    /**
     * Get user.
     *
     * @return AbstractUserInterface
     */
    public function getUser() : AbstractUserInterface
    {
        return $this->user;
    }

    /**
     * Get remember url.
     *
     * @return string
     */
    public function getRememberUrl() : string
    {
        return $this->rememberUrl;
    }
}
