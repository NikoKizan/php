<?php
//                     Обработчик комментариев и авторизации
session_start();

//подключение к базе данных
require_once 'db.php';

//фильтрация входящих данных от пользователя
$name = filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
$text = filter_input(INPUT_POST,'text',FILTER_SANITIZE_STRING);

//массив для хранения флэш-сообщения
$flash = [];

//Запрос для вставки данных от гостей
if (!empty($name) && !empty($text)) {

    //создаем sql-запрос в БД на внесение данных от пользователя
    $insert_comments = "INSERT INTO `blog`.`comments` (`name`, `comments`)
                        VALUES (?,?);";

    //Так как в запросе есть переменная, его нужно сперва подготовить
    $statement_comments = $pdo->prepare($insert_comments);
    
    //выполнение запроса
    try {
        $statement_comments->execute([$name, $text]);
    } catch (PDOException $e) {
        die('Ошибка: ' . $e->getMessage());
    }
    //создаем массив для передачи флэш-сообщений
    $flash['success'] = 'Ваш комментарий успешно добавлен';

    $_SESSION['flash'] = $flash;

    //переадресация на главную страницу после отправки данных
    header('Location: /php/marlin/index.php');

} else {
    if (!$name) {
        $flash['errors']['name'] = 'Введите ваше имя';
    }
    elseif (!$text) {
        $flash['errors']['text'] = 'Введите ваш комментарий';
    }
    $_SESSION['flash'] = $flash;
    
    //переадресация на главную страницу после отправки данных
    header('Location: /php/marlin/index.php');

}

/*try {
    $statement->execute($data);
} catch (PDOException $e) {
    die('Ошибка: ' . $e->getMessage());
}*/

?>