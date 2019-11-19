<?php

//подключение к базе данных
require_once 'db.php';

$login = filter_input(INPUT_POST,'login',FILTER_SANITIZE_STRING);
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

if (empty($login) || empty($email) || empty($password)) {

    //если поля пустые, то оставляем пользователя заполнить их
    header('Location: /php/marlin/register.php');
    
} elseif (!empty($login) && !empty($email) && !empty($password)) {
    $insert = "INSERT INTO `blog`.`register` (`login`, `email`, `password`) VALUES (?,?,?)";
    $statement = $pdo->prepare($insert);
    try {
        $statement->execute([$login,$email,$password]);//var_dump($res);die;
    } catch (PDOException $e) {
        die('Ошибка: ' . $e->getMessage());
    }

    //если поля не пустые, то регистрируем и отправляем на главную
    header('Location: /php/marlin/index.php');
}

?>