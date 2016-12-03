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

namespace Elcodi\Bundle\EntityTranslatorBundle\Tests\Functional\Services;

use Elcodi\Bundle\CartCouponBundle\Tests\Functional\ElcodiEntityTranslatorFunctionalTest;
use Elcodi\Component\EntityTranslator\Tests\Fixtures\TranslatableProduct;

/**
 * Class TranslatorTest.
 */
class TranslatorTest extends ElcodiEntityTranslatorFunctionalTest
{
    /**
     * Test translate.
     */
    public function testTranslate()
    {
        $translation = $this->create('elcodi:entity_translation');
        $translation->setEntityType('translatable_product');
        $translation->setEntityId(1);
        $translation->setEntityField('name');
        $translation->setLocale('es');
        $translation->setTranslation('nombre del producto');

        $this->save($translation);

        $this
            ->get('elcodi.event_dispatcher.entity_translator')
            ->dispatchTranslatorWarmUp();

        $translatableProduct = new TranslatableProduct();
        $translatableProduct->setId(1);
        $translatableProduct->setName('my default name');

        $translatableProduct = $this
            ->get('elcodi.entity_translator')
            ->translate($translatableProduct, 'es');

        $this->assertEquals(
            'nombre del producto',
            $translatableProduct->getName()
        );
    }

    /**
     * Test save.
     */
    public function testSave()
    {
        $this->reloadSchema();

        $translation = $this->create('elcodi:entity_translation');
        $translation->setEntityType('translatable_product');
        $translation->setEntityId(1);
        $translation->setEntityField('name');
        $translation->setLocale('es');
        $translation->setTranslation('nombre del producto');

        $this->save($translation);

        $this
            ->get('elcodi.event_dispatcher.entity_translator')
            ->dispatchTranslatorWarmUp();

        $translatableProduct = new TranslatableProduct();
        $translatableProduct->setId(1);
        $translatableProduct->setName('my default name');
        $translatableProduct->setDescription('my default description');

        $this
            ->get('elcodi.entity_translator')
            ->save($translatableProduct, [
                'es' => [
                    'name' => 'el nombre',
                ],
                'en' => [
                    'name' => 'the name',
                ],
                'fr' => [
                    'name' => 'le nom',
                ],
            ]);

        $this->assertCount(3, $this
            ->findAll('elcodi:entity_translation')
        );

        $cache = $this->get('doctrine_cache.providers.elcodi_translations');
        $this->assertEquals('el nombre', $cache->fetch('translation_translatable_product_1_name_es'));
        $this->assertEquals('the name', $cache->fetch('translation_translatable_product_1_name_en'));
        $this->assertEquals('le nom', $cache->fetch('translation_translatable_product_1_name_fr'));
    }
}
