<?php
/**
 * Copyright 2014 The Elefanto Authors. All rights Reserved.
 * Use of this source code is governed by a BSD-style
 * licence that can be found in the LICENCE file.
 */

namespace Elefanto\Std;

use Elefanto\Std\Exception;

class ArrayTools
{
    /**
     * Convert Array map to object
     *
     * <code>
     * $array = array(
     *     'a' => 1,
     *     'b' => 2,
     *     'c' => array(
     *          'd' => 3,
     *     ),
     * ); 
     *
     * $object = mapToObject($array);
     * $object->c->d;
     * </code>
     *
     * @param  array $array
     * @return stdClass
     */
    public static function mapToObject(array $array)
    {
        if (empty($array)) {
            return new \stdClass();
        }

        return json_decode(json_encode($array, true));
    }

    /**
     * Convert an Object to Array
     *
     * @param  object $object
     * @return array
     */
    public static function objectToMap($object)
    {
        if (!is_object($object)) {
            throw new Exception\InvalidArgumentException(
                sprintf(
                    'Invalid type given to %s. Object expected',
                    __METHOD__
                )
            );
        }

        return json_decode(json_encode($object), true);
    }

    /**
     * Convert a simple array list to map (assoc) 
     *
     * For example:
     * <code>
     * $list = array('A', 'B', 'C', 'D');
     * $map = array('A' => 'B', 'C' => 'D');   // output
     *
     * $list = array('A', 'B', 'C');
     * $map = array('A' => 'B', 'C' => null);  // output
     *
     * $assoc = array('A' => 'B', 'C' => 'D');
     * $map = array('B' => 'D');               // output
     * </code>
     *
     * @param  array $list
     * @return array
     */
    public static function listToMap(array $list)
    {
        if (empty($list)) {
            return $list;
        }

        $list  = array_values($list);
        $keys  = $values = array();
        $count = count($list);

        for ($i = 0; $i < $count; $i++) {
            if ($i % 2 == 0) {
                $keys[] = $list[$i];
            } else {
                $values[] = $list[$i];
            }
        }

        if ($count % 2 != 0) {
            $values[] = null;
        }

        return array_combine($keys, $values);
    }

    /**
     * Test whether an array is an array list
     * 
     * For example:
     * <code>
     * $list = ['foo', 'bar'];
     * $list = array(
     *     '1' => 'a',
     *     '2' => 'b',
     *      3  => 'c',
     * );
     * </code>
     * 
     * @param  mixed $value
     * @return bool
     */
    public static function isList($value)
    {
        if (!is_array($value) || empty($value)) {
            return false;
        }

        return count(array_filter(array_keys($value), 'is_int')) === count($value);
    }

    /**
     * Test whether an array is a map.
     * 
     * For example:
     * <code>
     * $map = array(
     *     'city'    => 'London',
     *     'country' => 'England',
     * );
     * $map = array(
     *     'type' => 'assoc',
     *     'key'  => 'value',
     * );
     * </code>
     * 
     * @param  mixed $value
     * @return bool
     */
    public static function isMap($value)
    {
        if (!is_array($value) || empty($value)) {
            return false;
        }

        return count(array_filter(array_keys($value), 'is_string')) === count($value);
    }
}
