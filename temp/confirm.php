<?php
require_once 'core/init.php';

$confirm = new Confirm();
$confirm_check = $confirm->check();

if($confirm_check->passed()){

    Session::flash('home', 'Your account has been confirmed, you may log in now');
    Redirect::to('index.php');

} else {
    foreach ($confirm_check->errors() as $error) {
        echo $error, '<br/>';
    }
}
