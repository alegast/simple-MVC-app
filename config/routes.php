<?php

$routes = array();

// examples 
//  1 array argument - route pattern (regular expression allowed)
//  2 array argument - request method (not nessasary, GET - default)
//  3 value argument - ControllerName  /  method name (case sensitive), 
//  (use same order for method params you use in route pattern )
//$routes['/example/']['get'] = 'Example/getAll';
//$routes['/example/']['post'] = 'Example/create';
//$routes['/example/(:num)']['get'] = 'Example/get';
//$routes['/example/(:num)']['put'] = 'Example/update';
//$routes['/example/(:num)']['delete'] = 'Example/delete';

$routes['/index'] = 'Default/index';
$routes['/404'] = 'Default/pageNotFound404';

$routes['/hello/(:any)'] = 'Default/hello';