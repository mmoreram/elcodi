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

namespace Elcodi\Bundle\FixturesBoosterBundle;

use Mmoreram\BaseBundle\BaseBundle;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\KernelInterface;

use Elcodi\Bundle\FixturesBoosterBundle\DependencyInjection\ElcodiFixturesBoosterExtension;

/**
 * Class ElcodiFixturesBoosterBundle.
 */
class ElcodiFixturesBoosterBundle extends BaseBundle
{
    /**
     * Returns the bundle's container extension.
     *
     * @return ExtensionInterface The container extension
     */
    public function getContainerExtension()
    {
        return new ElcodiFixturesBoosterExtension();
    }

    /**
     * Create instance of current bundle, and return dependent bundle namespaces.
     *
     * @return array Bundle instances
     */
    public static function getBundleDependencies(KernelInterface $kernel)
    {
        return [
            'Symfony\Bundle\FrameworkBundle\FrameworkBundle',
            'Elcodi\Bundle\CoreBundle\ElcodiCoreBundle',
            'Mmoreram\BaseBundle\BaseBundle',
        ];
    }
}
