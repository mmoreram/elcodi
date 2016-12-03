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

namespace Elcodi\Bundle\RuleBundle\Tests\Functional\Services;

use Elcodi\Bundle\RuleBundle\Tests\Functional\ElcodiRuleFunctionalTest;
use Elcodi\Component\Rule\Entity\Rule;

/**
 * Class RuleManagerTest.
 */
class RuleManagerTest extends ElcodiRuleFunctionalTest
{
    /**
     * Test if it can evaluate simple rules.
     */
    public function testEvaluateSimpleRule()
    {
        $rule = new Rule();
        $rule->setExpression('cart.getTotalItemNumber() < 10');

        $cart = $this->createMock('Elcodi\Component\Cart\Entity\Interfaces\CartInterface');
        $cart->expects($this->any())->method('getTotalItemNumber')->willReturn(5);

        $context = [
            'cart' => $cart,
        ];

        $this->assertTrue($this
            ->get('elcodi.manager.rule')
            ->evaluate($rule, $context)
        );
    }

    /**
     * Evaluate compound rules.
     *
     * @dataProvider providerEvaluateCompoundRule
     *
     * @param int  $amount
     * @param int  $quantity
     * @param bool $expected
     */
    public function testEvaluateCompoundRule($amount, $quantity, $expected)
    {
        $rule = new Rule();
        $rule->setExpression('rule("cart_valuable_items")');

        $cart = $this->createMock('Elcodi\Component\Cart\Entity\Interfaces\CartInterface');
        $cart->expects($this->any())->method('getAmount')->willReturn($amount);
        $cart->expects($this->any())->method('getTotalItemNumber')->willReturn($quantity);

        $context = [
            'cart' => $cart,
        ];

        $this->assertEquals(
            $expected,
            $this
                ->get('elcodi.manager.rule')
                ->evaluate($rule, $context)
        );
    }

    /**
     * Tests for "cart.getAmount() > 1000 and cart.getTotalItemNumber() < 10".
     *
     * @return array
     */
    public function providerEvaluateCompoundRule()
    {
        return [
           [100, 20, false],
           [1100, 20, false],
           [100,  5, false],
           [1100,  5, true],
       ];
    }
}
