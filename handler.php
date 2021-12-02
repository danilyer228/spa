<?php
session_start();
require_once 'functions.php';

switch ($_REQUEST['url']) {
    case '/home':
        if (!array_key_exists('is_authorized', $_SESSION)) {
            include 'pages/login.php';
        } else {
            include 'pages/main.php';
        }
        break;
    case '/register':
        include 'pages/register.php';
        break;
    case '/doLogin':
        if (login($_REQUEST['login'], $_REQUEST['password'])) {
            include 'pages/main.php';
        } else {
            $message = "Login failed";
            include 'pages/login.php';
        }
        break;
    case '/addOperation':
        $db = db();
        $res = $db->query("INSERT INTO operation (user_id, `sum`, status, description)
            VALUES ({$_SESSION['user_id']}, {$_REQUEST['sum']}, '{$_REQUEST['status']}', '{$_REQUEST['description']}')");
        include 'pages/main.php';
        break;
    case '/deleteOperation':
        $db = db();
        $db->query("DELETE FROM operation WHERE id={$_REQUEST['id']}");
        include 'pages/main.php';
        break;
    case '/doRegister':
        if (register($_REQUEST['login'], $_REQUEST['password'])) {
            include 'pages/main.php';
        } else {
            $message = "Register failed";
            include 'pages/register.php';
        }
        break;
    case '/exit':
        session_destroy();
        $_SESSION = [];
        include 'pages/login.php';
        break;

}

