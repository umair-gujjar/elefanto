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

    public function setUp()
    {
        $this->url = new Url($this->uriDataProvider());
    }

    public function tearDown()
    {
        $this->url = null;
    }

    public function testInstanceOf()
    {
        $this->assertInstanceOf('Elefanto\Http\Parser\Url', $this->url);
    }

    public function testUrlCanBeSetAndRetrieveValidLabel()
    {
        $this->url->setLabel('Label Test');
        $this->assertEquals('Label Test', $this->url->getLabel());
    }

    public function testUrlCanBeSetAndRetrieveValidRawUrl()
    {
        $urlTest = "http://domain.tld/path/file.html?q=ok";
        $this->url->setRawUrl($urlTest);
        $this->assertEquals($urlTest, $this->url->getRawUrl());
    }

    public function testUrlCanBeSetAndRetrieveValidScheme()
    {
        $this->url->setScheme('https');
        $this->assertEquals('https', $this->url->getScheme());
    }

    public function testUrlCanBeSetAndRetrieveValidUsername()
    {
        $this->url->setUsername('root');
        $this->assertEquals('root', $this->url->getUsername());
    }

    public function testUrlCanBeSetAndRetrieveValidPassword()
    {
        $this->url->setPassword('toor');
        $this->assertEquals('toor', $this->url->getPassword());
    }

    public function testUrlCanBeSetAndRetrieveValidHostname()
    {
        $this->url->setHostname('foo');
        $this->assertEquals('foo', $this->url->getHostname());
    }

    public function testUrlCanBeSetAndRetrieveValidPort()
    {
        $this->url->setPort(8080);
        $this->assertEquals(8080, $this->url->getPort());
    }

    public function testUrlCanBeSetAndRetrieveValidPath()
    {
        $this->url->setPath('/path/one');
        $this->assertEquals('/path/one', $this->url->getPath());
    }

    public function testUrlCanBeSetAndRetrieveValidQueryString()
    {
        $this->url->setQuery('param=val&param2=val2');

        $this->assertArrayHasKey('param', $this->url->getQuery());
        $this->assertContains('val', $this->url->getQuery());
        $this->assertEquals('val', $this->url->getQuery('param'));

        $this->assertArrayHasKey('param2', $this->url->getQuery());
        $this->assertContains('val2', $this->url->getQuery());
        $this->assertEquals('val2', $this->url->getQuery('param2'));
    }

    public function testUrlCanBeSetAndRetrieveValidQueryArray()
    {
        $this->url->setQuery(array('k' => 'v'));
        $this->assertArrayHasKey('k', $this->url->getQuery());
        $this->assertContains('v', $this->url->getQuery());
    }

    public function testUrlCantBeSetInvalidQueryArgumentException()
    {
        $this->setExpectedException('Elefanto\Http\Exception\InvalidArgumentException');
        $this->url->setQuery('');
    }

    public function testUrlCanBeSetAndRetrieveValidFragment()
    {
       $this->url->setFragment('anchor');
       $this->assertEquals('anchor', $this->url->getFragment()); 
    }

    public function uriDataProvider()
    {
        return "http://username:password@hostname/path?arg=value#anchor";
    }
}

