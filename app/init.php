<?php
session_start();

$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => '', //Enter host here
        'username' => '', //Enter username here
        'password' => '', //Enter password here
        'db' => '' //Enter db here
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
        'secret_key' => '',
        'public_key' => ''
    ),
    'lang' => array(
        'default' => 'en',
        'languages' => 'en', //languages in xml file (format: lang,lang)
        'xml_loaction' => dirname(__DIR__) . '/resources/lang/lang.xml',
        'expiry' => 604800
    ),
    'meta' => array(
        'author' => 'Food Champ',
        'description' => 'Food Champ Calorie Tracker',
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
        'default_controller' => 'home',
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
