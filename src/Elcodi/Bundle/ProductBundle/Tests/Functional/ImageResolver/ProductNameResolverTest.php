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

namespace Elcodi\Bundle\ProductBundle\Tests\Functional\ImageResolver;

use Elcodi\Bundle\ProductBundle\Tests\Functional\ElcodiProductFunctionalTest;

/**
 * Class ProductNameResolverTest.
 */
class ProductNameResolverTest extends ElcodiProductFunctionalTest
{
    /**
     * Test resolve image.
     */
    public function testResolveImage()
    {
        $product = $this->find('elcodi:product', 2);
        $this->assertEquals(
            'product.jpg',
            $this
                ->get('elcodi.image_resolver.purchasable')
                ->getValidImage($product)
                ->getName()
        );
    }

    /**
     * Test resolve image.
     */
    public function testResolveImageEmpty()
    {
        $product = $this->find('elcodi:product', 1);
        $this->assertFalse(
            $this
                ->get('elcodi.image_resolver.purchasable')
                ->getValidImage($product)
        );
    }
}
