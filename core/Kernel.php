<?php
/**
 * Copyright (c) 2016. Benjamin Rannow <rannow@emerise.de>
 * License: MIT
 * Author: Benjamin Rannow <rannow@emerise.de>
 * Project: M-Project
 */

declare(strict_types=1);

namespace Core;

use Core\HTTP\Request;
use Core\HTTP\Response;
use Core\Router\Router;
use Core\Router\RouterSearchResult;

/**
 * Class Kernel
 * @package Core
 */
class Kernel
{
    const CONFIG_PATH = '/../config/config.php';
    /** @var array */
    protected $config = array();

    /**
     * load entire config from config/config.php
     * 
     * @return array
     */
    protected function loadConfig() : array 
    {
        $path = __DIR__.self::CONFIG_PATH;
        if (file_exists($path) && empty($this->config)) {
            /** @noinspection PhpIncludeInspection */
            $this->config = include $path;
            return $this->config;
        }
        return $this->config;
    }

    /**
     * MAIN LIFE-CYCLE!
     *
     * connects request path with controller and return the result
     *
     * if no route match return 404
     *
     * throw 404 if controller returns bullshit (no response object)
     *
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function execute(Request $request) : Response
    {
        $config = $this->loadConfig();
        $response = null;
        $router = new Router($config);
        $result = $router->find($request);
        if ($result && $result->found()) {
            /** @var Response $response */
            $response = $this->call($result);
        } else {
            $response = new Response('', 404);
        }
        if (!$response instanceof Response) {
            throw new \Exception('Controller didn\'t return Response Object');
        }

        return $response;
    }

    /**
     * Dynmic class and method call
     *
     * auto casted params in correct type
     *
     * @param RouterSearchResult $result
     * @return Response
     * @throws \Exception
     */
    protected function call(RouterSearchResult $result) : Response
    {
        // load controller class and check if really exist
        $className = $result->getController();
        if (!empty($className) && class_exists($className)) {
            // load method from controller and check if really exist
            $methodName = $result->getMethod();
            $classObj = new $className();
            if ($classObj && !empty($methodName) && method_exists($classObj, $methodName)) {
                $args = array();
                if ($result->hasTypes()) {
                    // create a dummy from the method to get the method arguments
                    $method = new \ReflectionMethod($className, $methodName);
                    // auto cast params and send to method
                    $args = $result->getParamsWithList($method->getParameters());
                }

                return call_user_func_array(array($classObj, $methodName), $args);
            }
        }
        throw new \Exception('No Class nor Method found in <b>'.$className.'</b>');
    }

    /**
     * kill process - my job is done here!
     */
    public function terminate()
    {
        exit();
    }
}