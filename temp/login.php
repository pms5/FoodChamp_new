<?php
require_once 'core/init.php';

$user = new User();
if($user->isLoggedin()) {
    Session::flash('home', 'Already logged in');
    Redirect::to('index.php');
}

if(Input::exists()) {
    if(Token::check(Input::get('token'))) {

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array('required' => true),
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
            Session::flash('login', $validation->errors());
            Redirect::to($redirect);
        }
    }
}
?>

<form action="?r=login.php" method="post">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" autocomplete="off">
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" autocomplete="off">
    </div>

    <div class="field">
        <label for="remember">
            <input type="checkbox" name="remember" id="remember">Remember me
        </label>
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <input type="submit" value="Log in">
</form>
<a href="user/forgot">Forgot password</a>
