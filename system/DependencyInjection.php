<?php

namespace System;

class DependencyInjection
{
    private $container;
    
    public function __construct()
    {
        include_once APP_BASE_PATH . '/config/di_config.php';
        $this->config = &$di;        
    }
    
    public function get($item)
    {
        if (!empty($this->container[$item])){
            return $this->container[$item];
        }        
        
        if (!empty($this->config[$item])){
            
            $this->set($item, $this->initDIItemInstance($item));
            return $this->container[$item];
            
        } else {
            throw new \Exception($item . ' configuration is missing in di_config file,'.
                    ' and not set manually');
        }
        
    }
    
    public function set($itemName, $itemInstance)
    {
        $this->container[$itemName] = $itemInstance;
        return $this;
    }
    
    private function initDIItemInstance($itemName)
    {
        $options = $this->config[$itemName];
        
        if (!class_exists($options['class'])){
            throw new \Exception('Class ' . $options['class'] . ' is not exists') ;
        }
        
        $obj = new \ReflectionClass($options['class']);
        return $obj->newInstanceArgs();   
    }
    
}