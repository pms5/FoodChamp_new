<?php
require_once dirname(__DIR__) . '/app/init.php';
$captcha = new Captcha();
if(!$captcha->check(Input::get('captcha')) {
    echo true;
} else {
    echo false;
}
