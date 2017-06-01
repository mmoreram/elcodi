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

namespace Elcodi\Bundle\MediaBundle\Tests\Functional;

use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Mmoreram\BaseBundle\Tests\BaseKernel;
use Symfony\Component\HttpKernel\KernelInterface;

use Elcodi\Bundle\CoreBundle\Tests\ElcodiFunctionalTest;
use Elcodi\Bundle\FixturesBoosterBundle\ElcodiFixturesBoosterBundle;
use Elcodi\Bundle\MediaBundle\ElcodiMediaBundle;

/**
 * Class ElcodiMediaFunctionalTest.
 */
abstract class ElcodiMediaFunctionalTest extends ElcodiFunctionalTest
{
    /**
     * Get kernel.
     *
     * @return KernelInterface
     */
    protected static function getKernel() : KernelInterface
    {
        return new BaseKernel([
            new DoctrineFixturesBundle(),
            new ElcodiFixturesBoosterBundle(),
            new ElcodiMediaBundle(),
        ], [
            'imports' => [
                ['resource' => '@BaseBundle/Resources/config/providers.yml'],
                ['resource' => '@BaseBundle/Resources/test/framework.test.yml'],
                ['resource' => '@BaseBundle/Resources/test/doctrine.test.yml'],
                ['resource' => '@ElcodiCoreBundle/Resources/test/filesystem.test.yml'],
            ],
        ], [
            '@ElcodiMediaBundle/Resources/config/routing.yml',
        ]);
    }
}