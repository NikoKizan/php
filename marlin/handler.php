<?php
session_start();
require_once 'db.php';
$name = filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
$text = filter_input(INPUT_POST,'text',FILTER_SANITIZE_STRING);
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$flash = []; //массив для хранения флэш-сообщен

if (isset($name) && isset($email) && isset($password)) {

    $insert = "INSERT INTO `blog`.`register` (`name`, `email`, `password`) VALUES (?,?,?)";
    $statement = $pdo->prepare($insert);
    $statement->execute([$name,$email,$password]);//var_dump($res);die;

}

//Запрос для вставки данных от гостех

if (!empty($name) && !empty($text)) {

    //создаем sql-запрос в БД на внесение данных от пользователя
    $insert_comments = "INSERT INTO `blog`.`comments` (`name`, `comments`) 
                        VALUES (?,?);";

    //Так как в запросе есть переменная, его нужно сперва подготовить
    $statement_comments = $pdo->prepare($insert_comments);
    
    //выполнение запроса
    $statement_comments->execute([$name, $text]);
    
    //создаем массив для передачи флэш-сообщений
    $flash['success'] = 'Ваш комментарий успешно добавлен';

    $_SESSION['flash'] = $flash;
} else {
    if (!$name) {
        $flash['errors']['name'] = 'Введите ваше имя';
    }
    elseif (!$text) {
        $flash['errors']['text'] = 'Введите ваш комментарий';
    }
    $_SESSION['flash'] = $flash;
}

/*try {
    $statement->execute($data);
} catch (PDOException $e) {
    die('Ошибка: ' . $e->getMessage());
}*/

header('Location: /marlin/index.php');

?>