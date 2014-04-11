<?php
/**
 * Copyright 2014 The Elefanto Authors. All rights Reserved.
 * Use of this source code is governed by a BSD-style
 * licence that can be found in the LICENCE file.
 */

namespace Elefanto\Std;

class ArrayTools
{
    /**
     * Convert a simple array list to map (assoc) 
     *
     * For example:
     * <code>
     * $list = array('A', 'B', 'C', 'D');
     * $map = array('A' => 'B', 'C' => 'D');
     *
     * $list = array('A', 'B', 'C');
     * $map = array('A' => 'B', 'C' => null);
     * </code>
     *
     * @param  array $list
     * @return array
     */
    public static function listToMap(array $list)
    {
        $keys = $values = array();
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
        if (!is_array($value)) {
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
        if (!is_array($value)) {
            return false;
        }

        return count(array_filter(array_keys($value), 'is_string')) === count($value);
    }
}
