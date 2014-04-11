<?php
/**
 * Copyright 2014 The Elefanto Authors. All rights Reserved.
 * Use of this source code is governed by a BSD-style
 * licence that can be found in the LICENCE file.
 */

namespace Elefanto\Test\Std;

use PHPUnit_Framework_TestCase as TestCase;
use Elefanto\Std\ArrayTools;

class ArrayToolsTest extends TestCase
{
    public function validMap()
    {
        return array(
            array(array('foo' => 'bar')),
            array(array('bar' => 'foo'))
        );
    }

    public function validList()
    {
        return array(
           array(array('foo', 'bar')),
           array(array('bar', 'foo')),
        );
    }

    public function testEmptyListToMapReturnEmptyArray()
    {
        $this->assertEquals(ArrayTools::listToMap(array()), array());
    }

    public function testListToMapReturnsMap()
    {
        $list = array('foo', 'bar', 'key', 'val');
        $expected = array('foo' => 'bar', 'key' => 'val');
        $this->assertEquals(ArrayTools::listToMap($list), $expected);
    }

    public function testListToMapWithOddValues()
    {
        $list = array('A', 'B', 'C');
        $expected = array('A' => 'B', 'C' => null);
        $this->assertEquals(ArrayTools::listToMap($list), $expected);
    }

    public function testListToMapWithArrayAssocValues()
    {
        $map = array('key' => 'param', 'value' => 'foo');
        $expected = array('param' => 'foo');
        $this->assertEquals(ArrayTools::listToMap($map), $expected);
    }

    /**
     * @dataProvider validMap
     */
    public function testValidMap($test)
    {
        $this->assertTrue(ArrayTools::isMap($test));
    }

    /**
     * @dataProvider validList
     */
    public function testInvalidMap($test)
    {
        $this->assertFalse(ArrayTools::isMap($test));
    }

    /**
     * @dataProvider validList
     */
    public function testValidList($test)
    {
        $this->assertTrue(ArrayTools::isList($test));
    }

    /**
     * @dataProvider validMap
     */
    public function testInvalidList($test)
    {
        $this->assertFalse(ArrayTools::isList($test));
    }

    public function testEmptyArrayReturnsFalse()
    {
        $this->assertFalse(ArrayTools::isList(array()));
        $this->assertFalse(ArrayTools::isMap(array()));
    }

    public function testInvalidArgumentReturnsFalse()
    {
        $this->assertFalse(ArrayTools::isList("test"));
        $this->assertFalse(ArrayTools::isMap("test"));
    }
}
