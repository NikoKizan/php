<?php
//                      Обработчик авторизации

require_once "db.php";

session_start();

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

if (!empty($email) && (!empty($password) && $password_validate)) {

    $messages_login['success']['enter'] = "Вы успешно авторизовались";

    $_SESSION['message_login'] = $messages_login;

    header('location: /php/marlin/profile.php');

} else {

    if (empty($email)) $messages_login['errors']['email_empty'] = "Введите адрес Вашей електронной почты";
    
    elseif (checkEmail($pdo, $email == false)) $messages_login['error']['email_exist'] = "Такой електронной почты не существует!";

    elseif (empty($password)) $messages_login['errors']['password_empty'] = "Введите Ваш пароль";

    elseif ($password_validate == false) $messages_login['errors']['invalid_password'] = "Пароль указан неверно!";
    //var_dump($password_validate);die;
    $_SESSION['message_login'] = $messages_login;

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