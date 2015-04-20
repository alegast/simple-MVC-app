<?php

namespace App\Controller;

use System;

class DefaultController extends \System\Controller
{    
    public function index()
    {
        return $this->renderView('index');
    }
    
    public function hello($name)
    {
        return $this->renderView('index', array('name' => $name));
    }
    

}