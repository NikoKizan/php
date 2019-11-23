<?php
session_start();
require_once "db.php";

//фильтрация входящих данных от пользователя при авторизации
$email = trim(htmlspecialchars($_POST['email']));
$password = trim(htmlspecialchars($_POST['password']));

//скрываем пароль
$query = "SELECT `password` FROM `blog`.`register` WHERE `email` = ?";

$result = $pdo->prepare($query);
$result->bindParam(1, $email, PDO::PARAM_STR);
$result->execute();

$password_hash_db = $result->fetch();
$password_validate = password_verify($password, $password_hash_db['password']);

//создаем массив для хранения флэш-сообщений
$messages_login = [];

if ((!empty($email) && checkEmail($pdo, $email) == true) && (!empty($password) && $password_validate == true)) {

    $messages_login['success']['enter'] = "Вы успешно авторизовались";

    $_SESSION['message_login'] = $messages_login;
    
    header('location: /php/marlin/profile.php');

} else {

    if (empty($email) || NULL) $messages_login['error']['email_empty'] = "Введите адрес Вашей електронной почты";
    
    elseif (checkEmail($pdo, $email) == false) $messages_login['error']['email_exist'] = "Такой електронной почты не существует!";
    
    elseif (empty($password) || NULL) $messages_login['error']['password_empty'] = "Введите Ваш пароль";

    elseif ($password_validate == false) $messages_login['error']['invalid_password'] = "Пароль указан неверно!";
    
    //var_dump($_SESSION['password_empty']); die;
    
    $_SESSION['message_login'] = $messages_login;
    //var_dump($_SESSION['message_login']);
    //unset($_SESSION['message_login']);die;
    header('location: /php/marlin/login.php');

}

//функция для проверки существует ли введенный email
function checkEmail($pdo, $email) {

    $sql = "SELECT `email`
            FROM `blog`.`register`";

    $stmt = $pdo->query($sql);   
    
    while($row = $stmt->fetch()) {

        if ($row['email'] == $email) {

            return true;

        }

    }

    return false;

}

?>