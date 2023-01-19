<?php

namespace App\Controllers;
use App\View;
use App\Models\User;
use App\Models\Currency;

class DashboardController
{
    public function index()
    {
        $users = User::all();
        $view = new View('dashboard/index.html', ['users' => $users]);
        return $view;
    }

    public function logout()
    {
        setcookie("id", "", time() - 3600*24*30*12, "/");
        setcookie("hash", "", time() - 3600*24*30*12, "/",null,null,true);
        
        $users = User::all();
        $view = new View('dashboard/index.html', ['users' => $users]);
        return $view;
    }

    public function login()
    {
        $username = $_POST['login'];
        $password = $_POST['password'];
        $err = [];
        $currencies = [];     

        $user = User::where([ 'login' => $_POST['login'] ]);
        if (!empty($user[0])) {
            $user = $user[0];
        } else {
            $_POST = [];
            $err[] = "Пользователь не зарегистрирован <a href=\"/register\">Зарегистрироваться</a>";  
            $view = new View('dashboard/index.html', ['user' => [], 'errors' => $err]);
            return $view;
        }
        
        if(isset($_COOKIE['id']) and isset($_COOKIE['hash']) )
        {
            if ( ($user['hash'] !== $_COOKIE['hash']) or ($user['id'] !== $_COOKIE['id']) )
            {
               setcookie("id", "", time() - 3600*24*30*12, "/");
               setcookie("hash", "", time() - 3600*24*30*12, "/",null,null,true);
                
               $err[] = 'Введите логин/пароль снова';   
            } else {
                // правильный логин/пароль
                $currencies = Currency::all();
            }

             $view = new View('dashboard/index.html', ['user' => $user, 'errors' => $err, 'currencies' => $currencies]);
             return $view;
        }

        if($user['password'] !== User::hash_passwd($_POST['password']))
        {
       
            $err[] = 'Вы ввели неправильный логин/пароль';     

        } else {
            // правильный логин/пароль 
            $currencies = Currency::all();   
            $hash = User::new_hash();
            $user['hash'] = $hash;
            $id = User::update($user);
            setcookie("id", $user['id'], time()+60*60*24*30, "/");
            setcookie("hash", $user['hash'], time()+60*60*24*30, "/", null, null, true);
            if (!$id) {
                $err[] = 'Ошибка обновления данных';
            }
        }    

        $view = new View('dashboard/index.html', ['user' => $user, 'errors' => $err, 'currencies' => $currencies]);
        return $view;
    }

    public function register()
    {

        $username = $_POST['login'];
        $password = $_POST['password'];
        $err = [];    
        $currencies = [];     

        if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
        {
            $err[] = "Логин может состоять только из букв английского алфавита и цифр";
            $view = new View('dashboard/register.html', ['user' => $user, 'errors' => $err, 'currencies' => $currencies]);
            return $view;
        }

        if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
        {
            $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
            $view = new View('dashboard/register.html', ['user' => $user, 'errors' => $err, 'currencies' => $currencies]);
            return $view;
        }

        $user = User::where([ 'login' => $_POST['login'] ]);
        if($user)
        {
       
            $err[] = "Пользователь с таким логином уже существует в базе данных <a href=\"/login\">Войти</a>";
            $view = new View('dashboard/register.html', ['user' => $user, 'errors' => $err, 'currencies' => $currencies]);
            return $view;

        } else {    
            // регистрация; сохранение пользователя
            $password = User::hash_passwd($_POST['password']);
            $hash = User::new_hash();
            $id = User::create([ 'login' => $_POST['login'], 'password' => $password, 'hash' => $hash ]);
            $user = User::get($id)[0]; 
            setcookie("id", $user['id'], time()+60*60*24*30, "/");
            setcookie("hash", $user['hash'], time()+60*60*24*30, "/", null, null, true);
            $currencies = Currency::all();
            $view = new View('dashboard/index.html', ['user' => $user, 'errors' => $err, 'currencies' => $currencies]);
            return $view;
        }    

        $view = new View('dashboard/register.html', ['user' => $user, 'errors' => $err, 'currencies' => $currencies]);
        return $view;

    }

    public function curl_currencies()
    {
        $currencies = Currency::curl_currencies();
        echo(json_encode($currencies, JSON_UNESCAPED_UNICODE));
    }
}
