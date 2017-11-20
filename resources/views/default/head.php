<?php
$lang = new Lang();
$title = $lang->get_text('title');
?>

<!DOCTYPE html>
<html dir="ltr" lang="<?= $lang->get_lang(); ?>">
<head>
    <base href="<?= $_SERVER['REQUEST_URI'] ?>">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="author" content="<?= Config::get('meta/author'); ?>">
    <meta name="description" content="<?= Config::get('meta/description'); ?>">
    <meta name="keywords" content="<?= Config::get('meta/keywords'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name='language' content='<?= Cookie::get('lang'); ?>'>
    <!-- favico -->
    <!-- default -->
    <link rel="shortcut icon" href="img/favico/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favico/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favico/favicon-16x16.png">
    <!-- apple -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/favico/apple-touch-icon.png">
    <!-- safari -->
    <link rel="mask-icon" href="img/favico/safari-pinned-tab.svg" color="<?= Config::get('meta/safari-pt-background'); ?>">
    <!-- android chrome -->
    <link rel="manifest" href="img/favico/manifest.json">
    <meta name="apple-mobile-web-app-title" content="<?= Config::get('meta/web-app-title'); ?>">
    <meta name="application-name" content="<?= Config::get('meta/web-app-title'); ?>">
    <meta name="theme-color" content="<?= Config::get('meta/theme-color'); ?>">
    <!-- IE/Edge -->
    <meta name="msapplication-config" content="img/favico/browserconfig.xml">
    <meta name="msapplication-TileColor" content="<? Config::get('meta/IE-tile-color'); ?>">

    <!-- title -->
    <title><?= $title ?></title>
    <!-- main.css -->
    <link rel="stylesheet" type="text/css" href="css/main.css"/>
