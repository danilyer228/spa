<?php

require_once 'vendor/autoload.php';

function db() {
    return new PDO('mysql:host=spa-db;dbname=spa', "spa", "spa");
}

function getLastTenOperations($user_id) {
    $db = db();
    $res = $db->query("SELECT * FROM operation WHERE user_id={$user_id} ORDER BY id DESC LIMIT 10");
    if (count($res)) {
        return $res->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return [];
    }
}

function getSummary($user_id) {
    $db = db();
    $res = $db->query("SELECT SUM(`sum`) FROM operation WHERE status='income' AND user_id={$user_id};");
    $income = $res->fetchAll(PDO::FETCH_ASSOC);
    $res = $db->query("SELECT SUM(`sum`) FROM operation WHERE status='outcome' AND user_id={$user_id};");
    $outcome = $res->fetchAll(PDO::FETCH_ASSOC);
    return ['income' => $income[0]['SUM(`sum`)'], 'outcome' => $outcome[0]['SUM(`sum`)']];
}

function register($login, $password) {
    $db = db();
    if(!preg_match("/^[a-zA-Z0-9]+$/",$login))
    {
        $err[] = "Логин может состоять только из букв английского алфавита и цифр";
    }

    if(strlen($login) < 3 or strlen($login) > 30)
    {
        $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
    }

    $query = $db->query("SELECT id FROM users WHERE username='{$login}'");
    if($query->rowCount() > 0)
    {
        $err[] = "Пользователь с таким логином уже существует в базе данных";
    }

    if(count($err) === 0)
    {
        $password = md5(md5(trim($password)));

        $db->query("INSERT INTO users SET username='".$login."', password='".$password."'");
        $_SESSION['user_id'] = $db->lastInsertId();
        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['is_authorized'] = true;
        return true;
    }
    else
    {
        print "<b>При регистрации произошли следующие ошибки:</b><br>";
        foreach($err AS $error)
        {
            print $error."<br>";
        }
        return false;
    }

}

function getUser($id) {
    $db = db();
    return $db->query("SELECT * FROM users WHERE id = " . $id)->fetchAll(PDO::FETCH_ASSOC)[0];
}

function login($login, $password) {
    $db = db();
    $password = md5(md5(trim($password)));
    $query = "SELECT * FROM users WHERE username='$login' AND password='$password'";
    $res = $db->query($query);
    if ($res && $res->rowCount() > 0) {
        $_SESSION['user_id'] = $res->fetchAll(PDO::FETCH_ASSOC)[0]['id'];
        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['is_authorized'] = true;
        return true;
    }
    return false;
}
