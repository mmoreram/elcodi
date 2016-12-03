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

namespace Elcodi\Bundle\ProductBundle\Tests\Functional\Repository;

use Elcodi\Bundle\ProductBundle\Tests\Functional\ElcodiProductFunctionalTest;
use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;

/**
 * Class CategoryRepositoryTest.
 */
class CategoryRepositoryTest extends ElcodiProductFunctionalTest
{
    /**
     * Test category repository provider.
     */
    public function testRepositoryProvider()
    {
        $this->assertInstanceOf(
            'Doctrine\Common\Persistence\ObjectRepository',
            $this->get('elcodi.repository.category')
        );
    }

    /**
     * Test the repository to check that the get children categories returns
     * only the first level children categories (Not recursive).
     */
    public function testGetChildrenCategoriesNotRecursively()
    {
        /**
         * @var $rootCategory CategoryInterface
         */
        $rootCategory = $this
            ->get('elcodi.repository.category')
            ->findOneBy(['slug' => 'root-category']);

        $childrenCategories = $this
            ->get('elcodi.repository.category')
            ->getChildrenCategories(
                $rootCategory
            );

        $this->assertCount(
            1,
            $childrenCategories,
            'It should only return one category on non recursive mode'
        );
    }

    /**
     * Test the repository to check that the get children categories returns
     * all the children categories (Recursively).
     */
    public function testGetChildrenCategoriesRecursively()
    {
        /**
         * @var $rootCategory CategoryInterface
         */
        $rootCategory = $this
            ->get('elcodi.repository.category')
            ->findOneBy(['slug' => 'root-category']);

        $childrenCategories = $this
            ->get('elcodi.repository.category')
            ->getChildrenCategories(
                $rootCategory,
                true
            );

        $this->assertCount(
            2,
            $childrenCategories,
            'It should only return two categories on recursive mode'
        );
    }
}
