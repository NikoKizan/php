<?php

//Функция валидации для очистки данных от HTML и PHP тегов:
function clean($value = ""){
    //функцию trim для удаления пробелов из начала и конца строки
    $value = trim($value);
    //Функция stripslashes нужна для удаления экранированных символов
    $value = stripslashes($value);
    //Функция strip_tags нужна для удаления HTML и PHP тегов, но не работает с PDO
    $value = strip_tags($value);
    //Функция htmlspecialchars преобразует специальные символы в HTML-сущности ('&' преобразуется в '&amp;' и т.д.)
    $value = htmlspecialchars($value);

    return $value;
}

//Функция для проверки длинны строки:
function check_length($value = "", $min, $max){
    $result = (mb_strlen($value) < $min || mb_strlen($value) > $max);
    return !$result;
}

//Функция для валидации ел.почты:
$email_validate = filter_var($email, FILTER_VALIDATE_EMAIL);

?>