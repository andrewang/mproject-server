<?php
/**
 * Copyright (c) 2016. Benjamin Rannow <rannow@emerise.de>
 * License: MIT
 * Author: Benjamin Rannow <rannow@emerise.de>
 * Project: M-Project
 */

declare(strict_types=1);

namespace Core\HTTP;

class URL
{
    protected $scheme;
    protected $host;
    protected $path;
    protected $queries;

    public static function createFromGlobals() : URL
    {
        $url = new self();
        $url->setScheme((@$_SERVER["HTTPS"] == "on") ? "https" : "http");
        $url->setHost($_SERVER["SERVER_NAME"]);
        $pathQuery = parse_url($_SERVER["REQUEST_URI"]);
        if (isset($pathQuery['path'])) {
            $url->setPath($pathQuery['path']);
        }
        if (isset($pathQuery['query'])) {
            $q = array();
            parse_str($pathQuery['query'], $q);
            $url->setQueries($q);
        }
        return $url;
    }

    /**
     * @return string
     */
    public function getScheme() : string
    {
        return $this->scheme;
    }

    /**
     * @param string $scheme
     */
    public function setScheme(string $scheme)
    {
        $this->scheme = $scheme;
    }

    /**
     * @return string
     */
    public function getHost() : string
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost(string $host)
    {
        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getPath() : string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path)
    {
        $this->path = $path;
    }

    /**
     * @return array
     */
    public function getQueries() : array
    {
        return $this->queries;
    }

    /**
     * @param array $queries
     */
    public function setQueries(array $queries)
    {
        $this->queries = $queries;
    }

    public function __toString() : string
    {
        $str = $this->getScheme() . '://' . $this->getHost() . $this->getPath();
        if (!empty($this->getQueries())) {
            $str .= '?'. http_build_query($this->getQueries());
        }

        return $str;
    }
}