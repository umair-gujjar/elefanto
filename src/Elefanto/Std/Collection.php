<?php
/* Copyright 2014 The Elefanto Authors. All rights Reserved.
 * Use of this source code is governed by a BSD-style
 * licence that can be found in the LICENCE file.
 */

namespace Elefanto\Std;

class Collection
{
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
