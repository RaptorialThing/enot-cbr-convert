<?php

namespace App;

class View
{
    public function __construct($view, $vars)
    {
        require_once "../resources/" . $view;
    }
}
