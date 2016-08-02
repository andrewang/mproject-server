<?php
/**
 * Copyright (c) 2016. Benjamin Rannow <rannow@emerise.de>
 * License: MIT
 * Author: Benjamin Rannow <rannow@emerise.de>
 * Project: M-Project
 */

declare(strict_types=1);

namespace Core\Router;


use Core\HTTP\Request;

/**
 * Class Router
 * @package Core\Router
 */
class Router
{
    protected $config;

    /**
     * Router constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        if (isset($config['router'])) {
            $this->config = $config['router'];
        }
    }

    /**
     * find the first matched route from config and creates a SearchResult object
     *
     * return RouterSearchResult with the matched Route + params ... if no route matched return empty Object
     *
     * @param Request $request
     * @return RouterSearchResult
     */
    public function find(Request $request) : RouterSearchResult
    {
        $path = $request->getUrl()->getPath();
        $matchedConfig = $this->computeRoutes($path);
        return new RouterSearchResult($matchedConfig);
    }

    /**
     * iterate thru routes from config and check with given request path
     *
     * return matched config which contains the parsed placeholder as key => value
     *
     * @param string $path
     * @return array
     */
    protected function computeRoutes(string $path) : array
    {
        foreach ($this->config as $route => $config) {
            $params = array();
            if ($this->matchRoute($route, $path, $params)) {
                if (empty($config)) {
                    break;
                }
                $config[RouterSearchResult::CONFIG_PARAMS] = $params;

                return $config;
            }
        }

        return array();
    }

    /**
     * check pattern route with current given request path
     *
     * 1. step find and replace all placeholder in route with regex placeholder
     * 2. use the new generated regex as pattern to check if current request path matched
     * 3. prepare placeholder names and combine with values from matched request path (return as Call by Reference)
     *
     * returned true if url matched otherwise false
     *
     * @param string $route
     * @param string $path
     * @param array &$params
     * @return bool
     */
    protected function matchRoute(string $route, string $path, array &$params, bool $strict=false) : bool
    {
        $re = "/\\{(.*?)\\}/";
        preg_match_all($re, $route, $ids);
        $keys = array();
        if (!empty($ids) && count($ids) == 2) {
            $keys = $ids[1];
        }
        $subPattern = str_replace('/', '\/', preg_replace($re, '(.*?)', $route));
        // make last slash optional
        if(!$strict && substr($subPattern, -1) === '/') {
            $subPattern .= '?';
        }
        $pattern = '/^'.$subPattern.'$/';
        $isMatched = (int)preg_match($pattern, $path, $matches);
        $slized = array_slice($matches, 1);
        if ($isMatched === 1 && count($slized) == count($keys)) {
            $params = array_combine($keys, array_slice($matches, 1));
        }

        return ($isMatched === 1);
    }
}