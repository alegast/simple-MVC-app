<?php
namespace System;

class Controller {
    protected $app;
    
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /** common method, allow request params from GET / POST / PUT request methods 
     * 
     * @return array
     */
    public function getDataFromRequest()
    {
        if(mb_strtolower($_SERVER["REQUEST_METHOD"]) == 'get'){
            $parts = parse_url($_SERVER["REQUEST_URI"]);
            if (!empty($parts['query'])){
                parse_str($parts['query'], $query);
                return $query;
            }
        }
            

        if (!empty($_SERVER["CONTENT_TYPE"]) && $_SERVER["CONTENT_TYPE"] == "application/json"){
            $inputStream = file_get_contents("php://input");
            
            $data = json_decode($inputStream, true);
            if (is_array($data)){
                return $data;
            } elseif (mb_strtolower($_SERVER["REQUEST_METHOD"]) == 'post' && !empty($_POST)){
                return $_POST;
            }
            
        }
        
        return array();     
    }
    
    
    public function pageNotFound404()
    {
        return \System\Response::render404Page();
    }    
    
    
    /** alias for the same response method
     * 
     * @param string $viewPath
     * @param array $params
     * @return string
     */
    protected function renderView($viewPath, $params = array())
    {
        return \System\Response::renderView($viewPath, $params, false);
    }


    /** alias for the same response method
     * 
     * @param string/array/object $data
     * @param int $statusCode
     * @return Response
     */
    public function renderJsonResponse($data, $statusCode)
    {
        return \System\Response::renderJsonResponce($data, $statusCode);
    }
    
    
    
}