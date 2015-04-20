<?php
namespace System;

class Response 
{
    
    public static function renderJsonResponce($data, $statusCode = 200)
    {
        if (function_exists('http_response_code')){
            http_response_code($statusCode);
        }
        header('Content-Type: application/json');
        if (is_string($data)){
            echo $data;
        } elseif (is_array($data)|| is_object($data)){
            echo json_encode($data);
        } else {
            echo json_encode(array('error'=> 'incorrect data'));
        }
        
    }
    
    
    public static function render404Page()
    {
        if (function_exists('http_response_code')){
            http_response_code(404);
        }
        echo 'Requested page not found';
    }
    
    /** render html from view to variable or directly to browser (depending to $toVariable value)
     * 
     * @param string $viewPath
     * @param array $params
     * @param bool $toVariable
     * @return string or response to browser
     */
    public static function renderView($viewPath, $params = array(), $toVariable = false)
    {
        ob_start();
        extract($params);
        include VIEW_PATH . $viewPath . '.php';
        if ($toVariable === true) {
            $buffer = ob_get_contents();
            ob_end_clean();
            return $buffer;
        } else {
            ob_end_flush();
        }
    }
    
}