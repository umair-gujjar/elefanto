<?php
/**
 * Copyright 2014 The Elefanto Authors. All rights Reserved.
 * Use of this source code is governed by a BSD-style
 * licence that can be found in the LICENCE file.
 */

namespace Elefanto\Test\Uri;

use PHPUnit_Framework_TestCase as TestCase;
use Elefanto\Uri\Parser;

class ParserTest extends TestCase
{
    private $uri = null;

    public function setUp()
    {
        $this->uri = new Parser($this->uriDataProvider(), 'Test');
    }

    public function tearDown()
    {
        $this->uri = null;
    }

    public function testInstanceOf()
    {
        $this->assertInstanceOf('Elefanto\Uri\Parser', $this->uri);
    }

    public function testParserCanBeConstruct()
    {
        $uri = new Parser($this->uriDataProvider(), 'Test');
        $this->assertEquals($uri->getRawUri(), $this->uriDataProvider());
        $this->assertEquals($uri->getLabel(), 'Test');
    }

    public function testParserCanBeSetAndRetrieveValidLabel()
    {
        $this->uri->setLabel('Label Test');
        $this->assertEquals('Label Test', $this->uri->getLabel());
    }

    public function testParserCanBeSetAndRetrieveValidRawUri()
    {
        $uriTest = "http://domain.tld/path/file.html?q=ok";
        $this->uri->setRawUri($uriTest);
        $this->assertEquals($uriTest, $this->uri->getRawUri());
    }

    public function testParserCanBeSetAndRetrieveValidScheme()
    {
        $this->uri->setScheme('https');
        $this->assertEquals('https', $this->uri->getScheme());
    }

    public function testParserCanBeSetAndRetrieveValidUsername()
    {
        $this->uri->setUsername('root');
        $this->assertEquals('root', $this->uri->getUsername());
    }

    public function testParserCanBeSetAndRetrieveValidPassword()
    {
        $this->uri->setPassword('toor');
        $this->assertEquals('toor', $this->uri->getPassword());
    }

    public function testParserCanBeSetAndRetrieveValidHostname()
    {
        $this->uri->setHostname('foo');
        $this->assertEquals('foo', $this->uri->getHostname());
    }

    public function testParserCanBeSetAndRetrieveValidPort()
    {
        $this->uri->setPort(8080);
        $this->assertEquals(8080, $this->uri->getPort());
    }

    public function testParserCanBeSetAndRetrieveValidPath()
    {
        $this->uri->setPath('/path/one');
        $this->assertEquals('/path/one', $this->uri->getPath());
    }

    public function testParserCanBeSetAndGetRetrieveValidDirname()
    {
        $this->uri->setDirname('/dir/name');
        $this->assertEquals('/dir/name', $this->uri->getDirname());
    }

    public function testParserCanBeSetAndGetRetrieveValidBasename()
    {
        $this->uri->setBasename('index.html');
        $this->assertEquals('index.html', $this->uri->getBasename());
    }

    public function testParserCanBeSetAndGetRetrieveValidFilename()
    {
        $this->uri->setFilename('index');
        $this->assertEquals('index', $this->uri->getFilename());
    }

    public function testParserCanBeSetAndGetRetrieveValideExtension()
    {
        $this->uri->setExtension('php');
        $this->assertEquals('php', $this->uri->getExtension());
    }

    public function testParserCanBeSetAndRetrieveValidQueryString()
    {
        $this->uri->setQuery('param=val&param2=val2');

        $this->assertArrayHasKey('param', $this->uri->getQuery());
        $this->assertContains('val', $this->uri->getQuery());
        $this->assertEquals('val', $this->uri->getQuery('param'));

        $this->assertArrayHasKey('param2', $this->uri->getQuery());
        $this->assertContains('val2', $this->uri->getQuery());
        $this->assertEquals('val2', $this->uri->getQuery('param2'));
    }

    public function testParserCanBeSetAndRetrieveValidQueryArray()
    {
        $this->uri->setQuery(array('k' => 'v'));
        $this->assertArrayHasKey('k', $this->uri->getQuery());
        $this->assertContains('v', $this->uri->getQuery());
    }

    public function testParserCantBeSetInvalidQueryArgumentException()
    {
        $this->setExpectedException('Elefanto\Uri\Exception\InvalidArgumentException');
        $this->uri->setQuery(2);
    }

    public function testParserCantBeGetRetrieveQueryValue()
    {
        $this->assertNull($this->uri->getQuery('badParam'));
    }

    public function testParserCanBeSetAndGetRetrieveValidFragment()
    {
        $this->uri->setFragment('anchor');
        $this->assertEquals('anchor', $this->uri->getFragment());
    }

    public function testParserCantBeRetrieveValidPathinfo()
    {
        $uri = new Parser('test');
        $this->assertEquals('test', $uri->getDirname());
    }

    public function testParserCanBeRetrievePathValidPathinfo()
    {
        $uri = new Parser($this->uriDataProvider());
        $this->assertEquals('/path/index.php', $uri->getPath());
        $this->assertEquals('/path', $uri->getDirname());
        $this->assertEquals('index.php', $uri->getBasename());
        $this->assertEquals('index', $uri->getFilename());
        $this->assertEquals('php', $uri->getExtension());
    }

    public function uriDataProvider()
    {
        return "http://username:password@hostname.local/path/index.php?arg=value#anchor";
    }
}
