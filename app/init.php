<?php
session_start();

$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => 'studmysql01.fhict.local', //Enter host here
        'username' => 'dbi389333', //Enter username here
        'password' => 'i389333', //Enter password here
        'db' => 'dbi389333' //Enter db here
    ),
    'db' => array(
        'user_table_name' => 'user',
        'user_confirm_table_name' => 'user_confirm',
        'user_forgot_table_name' => 'user_forgot',
        'user_session_table_name' => 'user_session',
        'groups_table_name' => 'groups',
        'user_uname_field_name' => 'email'
    ),
    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_expiry' => 604800
    ),
    'session' => array(
        'session_name' => 'user',
        'token_name' => 'token'
    ),
    'validation' => array(
        'username_min' => 2,
        'username_max' => 20,
        'name_min' => 2,
        'name_max' => 50,
        'password_min' => 6
    ),
    'confirm' => array(
        'location' => '',
        'from' => '',
        'reply_to' => '',
        'valid_time' => '+1 hour'
    ),
    'forgot' => array(
        'location' => '',
        'from' => '',
        'reply_to' => '',
        'valid_time' => '+1 hour'
    ),
    'captcha' => array(
        'secret_key' => '6LfvjjoUAAAAAI8HjXAsIV4VM86jzPKE4DYh4bV5',
        'public_key' => '6LfvjjoUAAAAANRHJIaB2vVH2Dd8EvAdh2bNACht'
    ),
    'lang' => array(
        'default' => 'en',
        'languages' => 'en', //languages in xml file (format: lang,lang)
        'xml_loaction' => dirname(__DIR__) . '/resources/lang/lang.xml',
        'expiry' => 604800
    ),
    'meta' => array(
        'charset' => 'UTF-8',
        'author' => 'Food Champ',
        'description' => 'Food Champ',
        'keywords' => 'HTML,CSS,XML,JavaScript,PHP',
        'safari-pt-background' => '#e20505', // safari pinned tab bg (silhouet)
        'web-app-title' => 'Food Champ', //apple and android web app title
        'theme-color' => '#e20505', //mobile status bar color
        'IE-tile-color' => '#e20505' //Windows pinned to start background
    ),
    'timezone' => array(
        'default' => 'Europe/Amsterdam'
    ),
    'url' => array(
        'inc_root' => dirname(__DIR__)
    ),
    'app' => array(
        'default_controller' => 'login',
        'default_method' => 'index'
    )
);

spl_autoload_register(function($class) {
    require_once dirname(__DIR__) . '/app/models/' . $class . '.php';
});

require_once Config::get('url/inc_root') . '/app/functions/sanitize.php';

require_once Config::get('url/inc_root') . '/app/core/App.php';
require_once Config::get('url/inc_root') . '/app/core/Controller.php';

date_default_timezone_set(Config::get('timezone/default'));

if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
    $hash = Cookie::get(Config::get('remember/cookie_name'));
    $hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));

    if ($hashCheck->count()) {
        $user = new User($hashCheck->first()->user_id);
        $user->login();
    }
}
