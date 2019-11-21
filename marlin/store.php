<?php
//                     Обработчик регистрации
session_start();

//подключение к базе данных
require_once 'db.php';

$login = filter_input(INPUT_POST,'login',FILTER_SANITIZE_STRING);
$email = trim(htmlspecialchars($_POST['email']));
$password = trim(htmlspecialchars($_POST['password']));
$password_confirm = trim(htmlspecialchars($_POST['password_confirmation']));

//скрываем пароль
$password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

//создаем массив для хранения флэш-сообщений
$messages = [];

//валидация регистрации
if ((!empty($login) && strlen($login) <= 50) && (!empty($email) && preg_match_all('/^[a-zA-Z0-9\-\_]+@[a-z\.]+[a-z]{2,5}$/',$email) && checkEmail($pdo, $email) == false) && (!empty($password) && strlen($password) >= 6 && $password_confirm == $password)) {

    $insert = "INSERT INTO `blog`.`register` (`login`, `email`, `password`) VALUES (?,?,?)";

    $statement = $pdo->prepare($insert);

    //связываение параметров
    $statement->bindParam(1, $login);
    $statement->bindParam(2, $email);
    $statement->bindParam(3, $password_hash);

    try {
        $statement->execute();//var_dump($res);die;[$login,$email,$password_hash]
    } catch (PDOException $e) {
        die('Ошибка: ' . $e->getMessage());
    }

    $flash['success']/*['register']*/ = "Поздравляем!!! Вы успешно зарегистрировались:)";

    $_SESSION['flash'] = $flash;

    //если поля не пустые, то регистрируем и отправляем на главную
    header('Location: /php/marlin/index.php');
    
} else {

    if (empty($login)) $messages['error']['login_empty'] = "Введите Ваш логин";

     elseif (strlen($login) > 50) $messages['error']['login_length'] = "Вы ввели слишком длинный логин (макс. 50 символов)";

     elseif (checkLogin($pdo, $login)) $messages['error']['login_exist'] = "Введенный Вами логин уже существует!";

     elseif (empty($email)) $messages['error']['email_empty'] = "Введите адрес Вашей електронной почты";

     elseif (!preg_match_all('/^[a-zA-Z0-9\-\_]+@[a-z\.]+[a-z]{2,5}$/',$email)) $messages['error']['email_format'] = "Ваша електронная почта должна соответсвовать формату (abcdef@gmail.com)";

     elseif (checkEmail($pdo, $email)) $messages['error']['email_exist'] = "Введенная Вами електронная почта уже существует!";

     elseif (empty($password)) $messages['error']['password_empty'] = "Введите Ваш пароль";

     elseif (strlen($password) < 6) $messages['error']['password_length'] = "Ваш пароль должен быть не меньше 6 символов";

     elseif ($password_confirm !== $password) $messages['error']['password_confirm'] = "Ваши пароли не совпадают";

    $_SESSION['message'] = $messages;

    header('Location: /php/marlin/register.php');

}

//функция для проверки существует ли введенный логин
function checkLogin($pdo, $login) {

    $sql = "SELECT `login`
            FROM `blog`.`register`";

    $stmt = $pdo->query($sql);   
    
    while($row = $stmt->fetch()) {

        if ($row['login'] == $login) {

            return true;

        }

    }

    return false;

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