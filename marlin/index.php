<?php
session_start();
//Подключаем БД чтобы работал запрос
include_once('db.php');

if(!isset($_SESSION['flash'])){
    $_SESSION['flash'] = [];
}else{
    $success = $_SESSION['flash']['success'] ? $_SESSION['flash']['success'] : null;
    $errors = $_SESSION['flash']['errors'] ? $_SESSION['flash']['errors'] : null;
}

//Удаляем сессию после вывода
unset($_SESSION['flash']);

//Запрос к БД по выборке данных
$select_comments = "SELECT * 
           FROM `blog`.`comments` ORDER BY `id` DESC;";

//Подготовим наш запрос
$statement_comments = $pdo->prepare($select_comments);

//Выполняем его
$statement_comments->execute();

//Полученный результат данных с БД в виде массива записываем в переменную для вывода на главной через цикл
$comments = $statement_comments->fetchAll(PDO::FETCH_ASSOC);

//var_dump($_POST);die;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Comments</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="css/app.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="/marlin/index.php">
                    Project
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                            <li class="nav-item">
                                <a class="nav-link" href="login.html">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/marlin/register.php">Register</a>
                            </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header"><h3>Комментарии</h3></div>

                            <div class="card-body">
                            <?php if(isset($success)): ?>
                              <div class="alert alert-success" role="alert">
                                <?php echo $success; ?><!--Комментарий успешно добавлен-->
                              </div>
                            <?php endif ?>
                            <?php if(isset($comments)): ?>
                              <?php foreach($comments as $comment): ?>
                                <div class="media">
                                  <img src="img/no-user.jpg" class="mr-3" alt="..." width="64" height="64">
                                  <div class="media-body">
                                    <h5 class="mt-0"><?php echo $comment['name']; ?></h5> 
                                    <span><small><?php echo date("H:i:s d-m-Y", strtotime($comment['dates'])); ?></small></span>
                                    <p>
                                        <?php echo $comment['comments']."<br>"; ?>
                                    </p>
                                  </div>
                                </div>
                              <?php endforeach ?>
                            <?php else: ?>
                                <span>Комментариев пока что нет</span>
                            <?php endif ?>
                            </div>
                        </div>
                    </div>
                
                    <div class="col-md-12" style="margin-top: 20px;">
                        <div class="card">
                            <div class="card-header"><h3>Оставить комментарий</h3></div>

                            <div class="card-body">
                                <form action="handler.php" method="post">
                                    <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Имя</label>
                                    <input name="name" class="form-control" id="exampleFormControlTextarea1" />
                                  </div>
                                  <?php if(isset($errors['name'])):?>
                                    <span class="text-danger"><?php echo $errors['name'] ?></span>
                                  <?php endif ?>
                                  <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Сообщение</label>
                                    <textarea name="text" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                  </div>
                                  <?php if(isset($errors['text'])):?>
                                    <span class="text-danger"><?php echo $errors['text'] ?></span>
                                  <?php endif ?>
                                  <button type="submit" class="btn btn-success">Отправить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
