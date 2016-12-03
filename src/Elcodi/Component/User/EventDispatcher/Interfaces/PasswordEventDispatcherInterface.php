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

namespace Elcodi\Component\User\EventDispatcher\Interfaces;

use Elcodi\Component\User\Entity\Interfaces\AbstractUserInterface;

/**
 * Interface PasswordEventDispatcherInterface.
 */
interface PasswordEventDispatcherInterface
{
    /**
     * Dispatch password remember event.
     *
     * @param AbstractUserInterface $user
     * @param string                $recoverUrl
     */
    public function dispatchOnPasswordRememberEvent(
        AbstractUserInterface $user,
        string $recoverUrl
    );

    /**
     * Dispatch password recover event.
     *
     * @param AbstractUserInterface $user
     */
    public function dispatchOnPasswordRecoverEvent(AbstractUserInterface $user);
}
