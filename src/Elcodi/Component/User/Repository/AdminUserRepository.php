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

namespace Elcodi\Component\User\Repository;

use Doctrine\ORM\EntityRepository;

use Elcodi\Component\User\Entity\Interfaces\AbstractUserInterface;
use Elcodi\Component\User\Repository\Interfaces\UserEmaileableInterface;

/**
 * Class AdminUserRepository.
 */
class AdminUserRepository extends EntityRepository implements UserEmaileableInterface
{
    /**
     * Find one Entity given an email.
     *
     * @param string $email
     *
     * @return AbstractUserInterface|null
     */
    public function findOneByEmail(string $email) : ? AbstractUserInterface
    {
        $this
            ->findOneBy([
                'email' => $email,
            ]);
    }
}
