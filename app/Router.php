<?php

namespace App;

class Router
{

    public $request;
    
    public $routes;

    public $get;

    public function __construct($request)
    {
        $request = $request['REQUEST_URI'];
        $query = explode("?",$request);
        if (!empty($query[1])) {
            $get_params = explode("&",$query[1]);
            if (!empty($get_params)) {
                foreach ($get_params as $param) {
                    $param = explode("=",$param);
                    $this->get[$param[0]] = $param[1];
                }
            }
        }
        $this->request = $query[0];
    }

    public function addRoute($uri, $fn)
    {
        $this->routes[$uri] = $fn;
    }

    public function hasRoute($uri)
    {
        return array_key_exists($uri, $this->routes);       
    }
    
    public function run()
    {   
        header('Content-Type: text/html');

        if($this->hasRoute($this->request)) {
            header("HTTP/1.1 200 OK");
            $this->routes[$this->request]->call($this);
        } else {
            header("HTTP/1.1 404 Not Found");
            echo "page not found";
        }
    }

}
