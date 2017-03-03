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

namespace Elcodi\Component\Store\Factory;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Store\Entity\Interfaces\StoreInterface;

/**
 * Class StoreFactory.
 */
class StoreFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * This method must return always an empty instance
     *
     * @return StoreInterface Empty entity
     */
    public function create()
    {
        /**
         * @var StoreInterface $store
         */
        $classNamespace = $this->getEntityNamespace();
        $store = new $classNamespace();
        $store->setIsCompany(true);
        $store->enable();
        $store->setCreatedAt($this->now());

        return $store;
    }
}
