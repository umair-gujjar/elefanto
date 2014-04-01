<?php
/**
 * Copyright 2014 The Elefanto Authors. All rights Reserved.
 * Use of this source code is governed by a BSD-style
 * licence that can be found in the LICENCE file.
 */

namespace Elefanto\Test\Http\Parser;

use Elefanto\Http\Parse\Url;

class Url extends PHPUnit_Framework_TestCase
{
    private $url;

    public function setUp()
    {
        $this->url = new Url("http://example.tld");
    }
}

