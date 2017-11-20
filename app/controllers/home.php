<?php

class Home extends Controller
{
    public function index($name = '')
    {
        $this->view('default/head');
        $this->view('home/index', ['name' => $name]);
        $this->view('default/bodyEnd');
    }
}
