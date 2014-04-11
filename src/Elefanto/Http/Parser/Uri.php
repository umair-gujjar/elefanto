<?php
/**
 * Copyright 2014 The Elefanto Authors. All rights Reserved.
 * Use of this source code is governed by a BSD-style
 * licence that can be found in the LICENCE file.
 */

namespace Elefanto\Http\Parser;

class Uri
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
    private $params = array();

    /**
     * Construct
     * 
     * @param  string $uri
     * @param  string $label
     * @return void
     */
    public function __construct($uri, $label = null)
    {
        if (null !== $label) {
            $this->setLabel($label);
        }

        $this->setRawUri($uri);
    }

    /**
     * Set the label of this Uri
     * 
     * @param  string $label
     * @return \Elefanto\Http\Parser\Uri
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
     * @return \Elefanto\Http\Parser\Uri
     */
    public function setRawUri($uri)
    {
        $this->rawUri = (string) $uri;
        $this->parse();
        return $this;
    }

    /**
     * Return the raw Uri of this Uri
     * 
     * @return string
     */
    public function getRawUri()
    {
        return $this->rawUri;
    }

    /**
     * Set the dirname of this Uri
     * 
     * @param  string $dirname
     * @return \Elefanto\Http\Parser\Uri
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
     * Set the basename of this Uri
     * 
     * @param  string $basename
     * @return \Elefanto\Http\Parser\Uri
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
     * @return \Elefanto\Http\Parser\Uri
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
     * @return \Elefanto\Http\Parser\Uri
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
     * Set all params of this Uri
     * 
     * @param  array $params
     * @return \Elefanto\Http\Parser\Uri
     */
    public function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * Return all params of this Uri
     * 
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    protected function parse()
    {
        $params = '';
        $path = $uri = $this->getRawUri();

        if (($pos = strpos($uri, '?')) !== false) {
            $path   = substr($uri, 0, $pos);
            $params = substr($uri, $pos + 1);
        }

        if (empty($path)) {
            $path = '/';
        }

        $pathInfo = array_merge(
            array(
                'extension' => '',
                'dirname'   => '',
            ),
            pathinfo($path)
        );

        $this->setDirname($pathInfo['dirname'])
             ->setFilename($pathInfo['filename'])
             ->setExtension($pathInfo['extension'])
             ->setBasename($pathInfo['basename'])
             ->setFilename($pathInfo['filename']);

        parse_str($params, $params);
        $this->setParams($params);
    }
}
