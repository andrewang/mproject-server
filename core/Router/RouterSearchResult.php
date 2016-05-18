<?php
/**
 * Copyright (c) 2016. Benjamin Rannow <rannow@emerise.de>
 * License: MIT
 * Author: Benjamin Rannow <rannow@emerise.de>
 * Project: M-Project
 */

declare(strict_types=1);

namespace Core\Router;


class RouterSearchResult
{
    const CONFIG_PARAMS = 'params';
    const CONFIG_CONTROLLER = 'controller';
    const CONFIG_METHOD = 'method';
    const CONFIG_TYPES = 'types';

    /**
     * @var bool
     */
    protected $matched = false;

    protected $controller = '';
    protected $method = '';

    protected $params = array();

    protected $types = array();

    public function __construct(array $config)
    {
        if (!empty($config) && isset($config[self::CONFIG_PARAMS])) {
            $this->params = $config[self::CONFIG_PARAMS];
        }

        if (!empty($config) && isset($config[self::CONFIG_CONTROLLER])) {
            $this->matched = true;
            $this->controller = $config[self::CONFIG_CONTROLLER];
        }

        if (!empty($config) && isset($config[self::CONFIG_METHOD])) {
            $this->method = $config[self::CONFIG_METHOD];
        }

        if (!empty($config) && isset($config[self::CONFIG_TYPES])) {
            $this->types = $config[self::CONFIG_TYPES];
        }
    }

    /**
     * @return bool
     */
    public function found() : bool
    {
        return $this->matched;
    }

    /**
     * @return string
     */
    public function getController() : string
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getMethod() : string
    {
        return $this->method;
    }

    /**
     * @return bool
     */
    public function hasTypes() : bool
    {
        return !empty($this->types);
    }

    public function getParamsWithList(array $list) : array
    {
        $params = array();
        foreach ($list as $item) {
            $key = $item->name;
            if (isset($this->types[$key]) && isset($this->params[$key])) {
                $type = $this->types[$key];
                $value = $this->params[$key];
                settype($value, $type);
                $params[] = $value;
            }
        }
        return $params;
    }
}