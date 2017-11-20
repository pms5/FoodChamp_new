<?php
require_once dirname(__DIR__) . '/app/init.php';
$db = DB::getInstance();
$username = Input::get('username');
$check = $db->get('users', array('username', '=', $username));
if($check->count()) {
    echo "Username already exists";
}
