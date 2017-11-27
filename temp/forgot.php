<?php
require_once 'core/init.php';

$user = new User();

if($user->isLoggedin()) {
    Session::flash('home', 'Already logged in');
    Redirect::to('index.php');
}

$forgot = new Forgot();
$forgot_check = $forgot->check();
if($forgot_check->passed()){
    //Show user form to change password
    if(Input::exists()) {
        if(Token::check(Input::get('token'))) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'password' => array(
                    'required' => true,
                    'min' => Config::get('validation/password_min')
                ),
                'password_again' => array(
                    'required' => true,
                    'matches' => 'password'
                )
            ));

            if($validation->passed()) {
                $user = new User();

                $salt = Hash::salt(32);
                $user->update(array(
                    'password' => Hash::make(Input::get('password'), $salt),
                    'salt' => $salt
                ),Input::get('id'));

                $forgot->delete(Input::get('id'));

                Session::flash('home', 'Password changed!');
                Redirect::to('index.php');

            } else {
                foreach($validation->errors() as $error) {
                    echo $error, '<br/>';
                }
            }

        }
    }

    ?>

    <form action="" method="post">
        <div class="field">
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
        </div>

        <div class="field">
            <label for="password_again">Password Again</label>
            <input type="password" name="password_again" id="password_again" value="">
        </div>

        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        <input type="submit" value="Change">
    </form>

    <?php

} else {
    foreach($forgot_check->errors() as $error) {
        echo $error, '<br/>';
    }
    //Show user form to ask for email
    if(Input::exists()) {
        if(Token::check(Input::get('token'))) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'email' => array(
                    'required' => true,
                    'check_email' => true
                )
            ));

            if($validation->passed()) {
                if($forgot->setup(Input::get('email'))){
                    echo "success";
                }
            } else {
                foreach($validation->errors() as $error) {
                    echo $error, '<br/>';
                }
            }
        }
    }

    ?>

    <form action="" method="post">
        <div class="field">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="">
        </div>

        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        <input type="submit" value="Change">
    </form>

    <?php
}
