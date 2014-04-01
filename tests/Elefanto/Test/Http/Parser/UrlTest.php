<?php
/**
 * Copyright 2014 The Elefanto Authors. All rights Reserved.
 * Use of this source code is governed by a BSD-style
 * licence that can be found in the LICENCE file.
 */

namespace Elefanto\Test\Http\Parser;

use Elefanto\Http\Parser\Url;

class UrlTest extends \PHPUnit_Framework_TestCase
{
    private $url = null;

    /**
     * Setup the test environment
     */
    public function setUp()
    {
        $this->url = new Url("http://username:password@hostname/path?arg=value#anchor");
    }

    /**
     * TearDown the test environment
     */
    public function tearDown()
    {
        $this->url = null;
    }

    public function testInstanceOf()
    {
        $this->assertInstanceOf('Elefanto\Http\Parser\Url', $this->url);
    }
}

