<?php

class Login extends Controller
{
    public function index()
    {
        $this->view('default/head');
        $this->view('login/index');
        $this->view('default/bodyEnd');
    }
}
