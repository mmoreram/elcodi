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

namespace Elcodi\Bundle\CoreBundle\Tests;

use Mmoreram\BaseBundle\Tests\BaseFunctionalTest;

use Elcodi\Bundle\CoreBundle\DependencyInjection\ElcodiContainerAccessor;

/**
 * Class ElcodiFunctionalTest.
 */
abstract class ElcodiFunctionalTest extends BaseFunctionalTest
{
    use ElcodiContainerAccessor;
}