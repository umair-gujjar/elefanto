<?php
/**
 * Copyright 2014 The Elefanto Authors. All rights Reserved.
 * Use of this source code is governed by a BSD-style
 * licence that can be found in the LICENCE file.
 */

namespace Elefanto\Http\Parser;

use Elefanto\Http\Exception;

class Url
{
    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $rawUrl;

    /**
     * @var string
     */
    private $scheme = 'http';

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $hostname;

    /**
     * @var string
     */
    private $port = 80;

    /**
     * @var string
     */
    private $path = '/';

    /**
     * @var array
     */
    private $query = array();

    /**
     * @var string
     */
    private $fragment;

    /**
     * Constructor
     * 
     * @param  string $url
     * @param  string $label
     * @return void
     */
    public function __construct($url, $label = null)
    {
        $this->setRawUrl($url);

        if (null !== $label) {
            $this->setLabel($label);
        }
    }

    /**
     * Set the label of this Url
     * 
     * @param  string $label
     * @return \Elefanto\Http\Parser\Url
     */
    public function setLabel($label)
    {
        $this->label = (string) $label;
        return $this;
    }

    /**
     * Return the label of this Url
     * 
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set the raw url of this Url
     * 
     * @param  string $url
     * @return \Elefanto\Http\Parser\Url
     */
    public function setRawUrl($url)
    {
        $this->rawUrl = (string) $url;
        $this->parse();
        return $this;
    }

    /**
     * Return the raw url of this Url
     * 
     * @return string
     */
    public function getRawUrl()
    {
        return $this->rawUrl;
    }

    /**
     * Set the scheme of this Url
     * 
     * @param  string $scheme
     * @return \Elefanto\Http\Parser\Url
     */
    public function setScheme($scheme)
    {
        $this->scheme = (string) $scheme;
        return $this;
    }

    /**
     * Return the scheme of this Url
     * 
     * @return string
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * Set the username of this Url
     * 
     * @param  string $username
     * @return \Elefanto\Http\Parser\Url
     */
    public function setUsername($username)
    {
        $this->username = (string) $username;
        return $this;
    }

    /**
     * Return the username of this Url
     * 
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the password of this Url
     * 
     * @param  string $password
     * @return \Elefanto\Http\Parser\Url
     */
    public function setPassword($password)
    {
        $this->password = (string) $password;
        return $this;
    }

    /**
     * Return the password of this Url
     * 
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the hostname of this Url
     * 
     * @param  string $hostname
     * @return \Elefanto\Http\Parser\Url
     */
    public function setHostname($hostname)
    {
        $this->hostname = (string) $hostname;
        return $this;
    }

    /**
     * Return the hostname of this Url
     * 
     * @return string
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * Set the port of this Url
     * 
     * @param  int $port
     * @return \Elefanto\Http\Parser\Url
     */
    public function setPort($port)
    {
        $this->port = (int) $port;
        return $this;
    }

    /**
     * Return the port of this Url
     * 
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set the path of this Url
     * 
     * @param  string $path
     * @return \Elefanto\Http\Parser\Url
     */
    public function setPath($path)
    {
        $this->path = (string) $path;
        return $this;
    }

    /**
     * Return the path of this Url
     * 
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the query of this Url
     * 
     * @param  string|array $query
     * @return \Elefanto\Http\Parser\Url
     * @throw  \Elefanto\Http\Exception\InvalidArgumentException
     */
    public function setQuery($query)
    {
        if (empty($query) && (!is_string($query) || !is_array($query))) {
            throw new Exception\InvalidArgumentException(
                sprintf(
                    "Parameter provided to %s must be an %s or an %s",
                    __METHOD__,
                    'string',
                    'array'
                )
            );
        }

        if (is_string($query)) {
            parse_str($query, $query);
        }

        $this->query = $query;
        return $this;
    }

    /**
     * Return the query of this Url
     * 
     * @param  string $key
     * @return array
     */
    public function getQuery($key = null)
    {
        if (null === $key) {
            return $this->query;
        }

        if (isset($this->query[$key])) {
            return $this->query[$key];
        }

        return null;
    }

    /**
     * Set the fragment of this Url
     * 
     * @param  string $fragment
     * @return \Elefanto\Http\Parser\Url
     */
    public function setFragment($fragment)
    {
        $this->fragment = (string) $fragment;
        return $this;
    }

    /**
     * Return the fragment of this Url
     * 
     * @return string
     */
    public function getFragment()
    {
        return $this->fragment;
    }

    /**
     * Parse url
     * 
     * @return \Elefanto\Http\Parser\Url
     */
    protected function parse()
    {
        $parts   = parse_url($this->getRawUrl());
        $getPart = function ($key, $default) use ($parts) {
            if (isset($parts[$key])) {
                return $parts[$key];
            }
            return $default;
        };

        $this->setScheme($getPart('scheme', $this->getScheme()))
             ->setUsername($getPart('user', $this->getUsername()))
             ->setPassword($getPart('pass', $this->getPassword()))
             ->setHostname($getPart('host', $this->getHostname()))
             ->setPath($getPart('path', $this->getPath()))
             ->setQuery($getPart('query', $this->getQuery()))
             ->setFragment($getPart('fragment', $this->getFragment()));

        return $this;
    }
}
