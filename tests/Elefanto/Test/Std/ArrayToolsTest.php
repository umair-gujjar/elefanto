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
            array(array('bar' => 'foo')),
        );
    }

    public function validList()
    {
        return array(
           array(array('foo', 'bar')),
           array(array('bar', 'foo')),
        );
    }

    public function getRecursiveMap()
    {
        return array(
            'property' => 'value',
            'param' => 'val',
            'sub' => array(
                'foo' => 'bar',
                'bar' => 'foo',
            ),
        );
    }

    public function getRecursiveObject()
    {
        $object = new \stdClass();
        $object->property = 'value';
        $object->param = 'value';
        $sub = new \stdClass();
        $sub->foo = 'bar';
        $sub->bar = 'foo';
        $object->sub = $sub;
	return $object;
    }

    public function testEmptyMapToObjectReturnObject()
    {
        $object = ArrayTools::mapToObject(array());
        $this->assertTrue(is_object($object));
    }

    public function testMapToObjectReturnValues()
    {
        $object = ArrayTools::mapToObject($this->getRecursiveMap());
        $this->assertEquals($object->property, 'value');
        $this->assertEquals($object->param, 'val');
        $this->assertEquals($object->sub->foo, 'bar');
        $this->assertEquals($object->sub->bar, 'foo');
    }

    public function testObjectToMapReturnIsArray()
    {
        $array = ArrayTools::objectToMap($this->getRecursiveObject()); 
        $this->assertTrue(is_array($array));
    }

    public function testObjectToMapReturnValues()
    {
        $array = ArrayTools::objectToMap($this->getRecursiveObject());
        $this->assertEquals($array['property'], 'value');
        $this->assertEquals($array['param'], 'value');
        $this->assertEquals($array['sub']['foo'], 'bar');
        $this->assertEquals($array['sub']['bar'], 'foo');
    }

    public function testObjectToMapCanBeSetInvalidArgumentException()
    {
        $this->setExpectedException('Elefanto\Std\Exception\InvalidArgumentException');
        ArrayTools::objectToMap(array());
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
