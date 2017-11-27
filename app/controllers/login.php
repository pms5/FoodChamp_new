<?php

class Login extends Controller
{
    public function index()
    {
        $user = new User();
        if($user->isLoggedin()) {
            Redirect::to('home');
        }

        $errors = "";
        if(Input::exists()) {
            if(Input::get('login') !== '') {
                if(Token::check(Input::get('token'))) {

                    $validate = new Validate();
                    $validation = $validate->check($_POST, array(
                        'email' => array('required' => true),
                        'password' => array('required' => true)
                    ));

                    if($validation->passed()) {
                        $user = new User();

                        $remember = (Input::get('remember') === 'on') ? true : false;
                        $login = $user->login(Input::get('username'), Input::get('password'), $remember);

                        if($login) {
                            //logged in
                            $id = DB::getInstance()->get('users', array('username', '=', Input::get('username')))->first()->id;
                            $forgot = new Forgot();
                            $forgot->delete($id);

                            Session::flash('home', 'Logged in');
                            Redirect::to('index.php');
                        } else {
                            //Not logged in
                            Session::flash('login', 'Error logging in');
                            Redirect::to($redirect);
                        }
                    } else {
                        $errors = $validation->errors();
                    }
                }
            } else if(Input::get('register') !== '') {

            }

        }


        $this->view('default/head');
        $this->view('login/index', ['errors' => $errors]);
        $this->view('default/bodyEnd');
    }
}
