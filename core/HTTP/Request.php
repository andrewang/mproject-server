<?php
/**
 * Copyright (c) 2016. Benjamin Rannow <rannow@emerise.de>
 * License: MIT
 * Author: Benjamin Rannow <rannow@emerise.de>
 * Project: M-Project
 */

declare(strict_types=1);

namespace Core\HTTP;

class Request
{
    protected $content;

    protected $headers;

    /**
     * @var URL
     */
    protected $url;

    public function __construct()
    {
        $this->url = null;
        $this->headers = array();
    }

    public static function createFromGlobals() : Request
    {
        $request = new self();
        $request->setURL(URL::createFromGlobals());
        $headers = getallheaders();
        $request->setHeaders($headers?$headers:array());
        return $request;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return array
     */
    public function getHeaders() : array
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    /**
     * @param string $key
     * @return string
     */
    public function getHeader(string $key) : string
    {
        $header = '';
        if (isset($this->headers[$key])) {
            $header = $this->headers[$key];
        }
        return $header;
    }

    /**
     * @return URL
     */
    public function getUrl() : URL
    {
        return $this->url;
    }

    /**
     * @param URL $url
     */
    public function setUrl(URL $url)
    {
        $this->url = $url;
    }
}
