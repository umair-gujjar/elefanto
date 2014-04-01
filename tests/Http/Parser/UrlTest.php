<?php

namespace Http\Parser;

class UrlTest extends PHPUnit_Framework_TestCase
{
    private $url;

    public function setUp()
    {
        $this->url = new Http\Parse\Url("http://example.tld");
    }
}

