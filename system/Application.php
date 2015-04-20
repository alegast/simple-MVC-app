<?php

namespace System;

class Application
{
    protected static $_instance;
    private $route;
    private $db;

    /**
     *  create App object and init necessary methods
     */
    private function __construct()
    {
        $this->route = new \System\Route();
        $this->route->matchRoute();
        $this->initDb();
    }

    private function __clone()
    {
        
    }

    public static function getInstance()
    {       
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
    
    /**
     *   Call required method from class (controller) matched to route (url) rule
     */
    public function run()
    {
        
        list($this->calledControllerName, $this->calledMethod, $this->calledMethodParams) = $this->route->getBindedControllerParams();
      
        if (file_exists(APP_BASE_PATH . 'src/Controller/' . $this->calledControllerName . 'Controller.php')) {

            $cName = '\\App\\Controller\\'.$this->calledControllerName."Controller";
            $this->calledController = new $cName($this);

            if (method_exists($this->calledController, $this->calledMethod)) {
                if (!empty($this->calledMethodParams)) {
                    call_user_func_array(array($this->calledController, $this->calledMethod), $this->calledMethodParams);
                } else {
                    $this->calledController->{$this->calledMethod}();
                }
            } else {
                throw new \Exception("Method {$this->calledMethod} doesn't exists in Controller {$this->calledControllerName} ");
            }

        } else {
            throw new \Exception("Controller {$this->calledControllerName} - doesn't exists ");
        }
    }
    

    /**
     *  init Db connetion
     */
    private function initDb()
    {
        // db connection code
    }
    
    /** get Db connection
     * 
     * @return Object
     */
    public function getDb()
    {
        return $this->db;
    }
    
    
}
