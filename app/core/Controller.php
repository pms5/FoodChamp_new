<?php

class Controller
{
    public function view($view, $data = [])
    {
        require_once Config::get('url/inc_root') . '/resources/views/' . $view . '.php';
    }
}
