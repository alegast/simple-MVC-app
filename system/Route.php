<?php

namespace System;

class Route
{
    private $requestMethod;
    private $routes = array();
    private $requestUrl;
    
    private $controller;
    private $method;
    private $methodParams = array();

    public function __construct() {

        include_once APP_BASE_PATH . '/config/routes.php';
        $this->routes = &$routes;
    }

    public function matchRoute()
    {
        $this->requestMethod = isset($_SERVER['REQUEST_METHOD']) ? strtolower($_SERVER['REQUEST_METHOD']) : 'get';

       
        $this->requestUrl = $this->getRequestUrl();
        
        // for url matching
        if (isset($this->routes[$this->requestUrl])) {

            if (is_string($this->routes[$this->requestUrl])) {
                $this->bindRouteToController($this->routes[$this->requestUrl]);
                return true;
            }

            elseif (is_array($this->routes[$this->requestUrl]) && isset($this->routes[$this->requestUrl][$this->requestMethod])) {
                $this->bindRouteToController($this->routes[$this->requestUrl][$this->requestMethod]);
                return true;
            }
        } 
        
        // for regular expressions in urls
        foreach ($this->routes as $key => $val) {

            if (is_array($val)) {
                if (isset($val[$this->requestMethod])) {
                    $val = $val[$this->requestMethod];
                } else {
                    continue;
                }
            }

            $key = str_replace(array('(:any)','(:num)'),array('([^/]+)','([0-9]+)'), $key);
            if (preg_match('#^' . $key . '$#', $this->requestUrl, $matches)) {
                array_walk($matches, function(&$v) {
                    if ($v != $this->requestUrl){
                        $this->methodParams[] = $v;             
                    }                    
                }, $this->methodParams);

                $this->bindRouteToController($val);
                return true;
            }            
        }

        // for index page
        if (empty($this->requestUrl) || $this->requestUrl == '/'){
            $this->bindRouteToController($this->routes['/index']);
            return true;
        }
        
        // page not found
        $this->bindRouteToController($this->routes['/404']);
        return false;

    }
    
    private function getRequestUrl()
    {        
        $url = str_replace(array("/public/index.php","/index.php", "index.php"), '', $_SERVER['REQUEST_URI']);
        if ($position = strpos($url,'?')){
            return substr($url, 0, $position);
        }
        return $url;
    }
    
    private function bindRouteToController($routeDestination)
    {
        list($this->controller,$this->method) = explode('/', $routeDestination);        
    }
    
    public function getBindedControllerParams()
    {
        return array($this->controller, $this->method, $this->methodParams);        
    }
        
    
    
    
}

