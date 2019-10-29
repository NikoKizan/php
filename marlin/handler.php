<?php
session_start();
include_once 'db.php';
require_once 'functions.php';

$name = filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
$text = filter_input(INPUT_POST,'text',FILTER_SANITIZE_STRING);

if(!empty($name) && !empty($text)){

    if(check_length($name, 4, 20) && check_length($text, 2, 1000)){

        //SQL запрос в БД на вставку данных
        $insert = "INSERT INTO blog.comments (`name`, `comments`) 
        VALUES (?,?);";

        //Так как в запросе есть переменная, его нужно сперва подготовить
        $statement = $pdo->prepare($insert);
        
        //Выполняем
        $statement->execute([$name, $text]);
        $_SESSION['flash'] = 'Ваш комментарий добавлен';
        
    }
}

header('Location: /marlin/index.php');

?>