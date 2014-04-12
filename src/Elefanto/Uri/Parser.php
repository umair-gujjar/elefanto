<?php
/**
 * Copyright 2014 The Elefanto Authors. All rights Reserved.
 * Use of this source code is governed by a BSD-style
 * licence that can be found in the LICENCE file.
 */

namespace Elefanto\Uri;

use Elefanto\Uri\Exception;

class Parser
{
    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $rawUri;

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
     * @var string
     */
    private $dirname;

    /**
     * @var string
     */
    private $basename;

    /**
     * @var string
     */
    private $filename;

    /**
     * @var string
     */
    private $extension;

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
     * @param  string $uri
     * @param  string $label
     * @return void
     */
    public function __construct($uri, $label = null)
    {
        $this->setRawUri($uri);

        if (null !== $label) {
            $this->setLabel($label);
        }
    }

    /**
     * Set the label of this Uri
     * 
     * @param  string $label
     * @return \Elefanto\Uri\Parser
     */
    public function setLabel($label)
    {
        $this->label = (string) $label;
        return $this;
    }

    /**
     * Return the label of this Uri
     * 
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set the raw uri of this Uri
     * 
     * @param  string $uri
     * @return \Elefanto\Uri\Parser
     */
    public function setRawUri($uri)
    {
        $this->rawUri = (string) $uri;
        $this->parse();
        return $this;
    }

    /**
     * Return the raw uri of this Uri
     * 
     * @return string
     */
    public function getRawUri()
    {
        return $this->rawUri;
    }

    /**
     * Set the scheme of this Uri
     * 
     * @param  string $scheme
     * @return \Elefanto\Uri\Parser
     */
    public function setScheme($scheme)
    {
        $this->scheme = (string) $scheme;
        return $this;
    }

    /**
     * Return the scheme of this Uri
     * 
     * @return string
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * Set the username of this Uri
     * 
     * @param  string $username
     * @return \Elefanto\Uri\Parser
     */
    public function setUsername($username)
    {
        $this->username = (string) $username;
        return $this;
    }

    /**
     * Return the username of this Uri
     * 
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the password of this Uri
     * 
     * @param  string $password
     * @return \Elefanto\Uri\Parser
     */
    public function setPassword($password)
    {
        $this->password = (string) $password;
        return $this;
    }

    /**
     * Return the password of this Uri
     * 
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the hostname of this Uri
     * 
     * @param  string $hostname
     * @return \Elefanto\Uri\Parser
     */
    public function setHostname($hostname)
    {
        $this->hostname = (string) $hostname;
        return $this;
    }

    /**
     * Return the hostname of this Uri
     * 
     * @return string
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * Set the port of this Uri
     * 
     * @param  int $port
     * @return \Elefanto\Uri\Parser
     */
    public function setPort($port)
    {
        $this->port = (int) $port;
        return $this;
    }

    /**
     * Return the port of this Uri
     * 
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set the path of this Uri
     * 
     * @param  string $path
     * @return \Elefanto\Uri\Parser
     */
    public function setPath($path)
    {
        $this->path = (string) $path;
        return $this;
    }

    /**
     * Return the path of this Uri
     * 
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the dirname of this Uri
     * 
     * @param  string $dirname
     * @return \Elefanto\Uri\Parser
     */
    public function setDirname($dirname)
    {
        $this->dirname = (string) $dirname;
        return $this;
    }

    /**
     * Return the dirname of this Uri
     * 
     * @return string
     */
    public function getDirname()
    {
        return $this->dirname;
    }

    /**
     * Set the base name of this Uri
     * 
     * @param  string $basename
     * @return \Elefanto\Uri\Parser
     */
    public function setBasename($basename)
    {
        $this->basename = (string) $basename;
        return $this;
    }

    /**
     * Return the basename of this Uri
     * 
     * @return string
     */
    public function getBasename()
    {
        return $this->basename;
    }

    /**
     * Set the filename of this Uri
     *
     * @param  string $filename
     * @return \Elefanto\Uri\Parser
     */
    public function setFilename($filename)
    {
        $this->filename = (string) $filename;
        return $this;
    }

    /**
     * Return the filename of this Uri
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set the extension of this Uri
     *
     * @param  string $extension
     * @return \Elefanto\Uri\Parser
     */
    public function setExtension($extension)
    {
        $this->extension = (string) $extension;
        return $this;
    }

    /**
     * Return the extension of this Uri
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set the query of this Uri
     * 
     * @param  string|array $query
     * @return \Elefanto\Uri\Parser
     * @throw  \Elefanto\Uri\Exception\InvalidArgumentException
     */
    public function setQuery($query)
    {
        if (!is_string($query) && !is_array($query)) {
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

        $this->query = (array) $query;
        return $this;
    }

    /**
     * Return the query of this Uri
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
     * Set the fragment of this Uri
     * 
     * @param  string $fragment
     * @return \Elefanto\Uri\Parser
     */
    public function setFragment($fragment)
    {
        $this->fragment = (string) $fragment;
        return $this;
    }

    /**
     * Return the fragment of this Uri
     * 
     * @return string
     */
    public function getFragment()
    {
        return $this->fragment;
    }

    /**
     * Returns information about a file path
     * 
     * @param  string $path
     * @return array
     */
    protected function pathinfo($path)
    {
        $keys    = array('dirname', 'basename', 'filename', 'extension');
        $default = array_fill_keys($keys, '');
        $infos   = array_merge($default, pathinfo($path));

        if ($infos[$keys[0]] == '.') {
            $infos[$keys[0]] = $path;
        }

        return $infos;
    }

    /**
     * Parse uri
     *
     * @see    http://tools.ietf.org/html/rfc3986#appendix-B 
     * @return \Elefanto\Uri\Parser
     */
    protected function parse()
    {
        $parts   = parse_url($this->getRawUri());
        $getPart = function ($key, $default) use ($parts) {
            return isset($parts[$key]) ? $parts[$key] : $default;
        };

        $this->setScheme($getPart('scheme', $this->getScheme()))
             ->setUsername($getPart('user', $this->getUsername()))
             ->setPassword($getPart('pass', $this->getPassword()))
             ->setHostname($getPart('host', $this->getHostname()))
             ->setPath($getPart('path', $this->getPath()))
             ->setQuery($getPart('query', $this->getQuery()))
             ->setFragment($getPart('fragment', $this->getFragment()));

        $pathinfo = $this->pathinfo($this->getPath());

        $this->setDirname($pathinfo['dirname'])
             ->setBasename($pathinfo['basename'])
             ->setFilename($pathinfo['filename'])
             ->setExtension($pathinfo['extension']);

        return $this;
    }
}
