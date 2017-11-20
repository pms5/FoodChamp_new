<?php
require_once dirname(__DIR__) . '/app/init.php';
$db = DB::getInstance();
$email = Input::get('email');
$check = $db->get('users', array('email', '=', $email));
if($check->count()) {
    echo "Email already exists";
}
