<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style/homeProvider.css">
</head>
<body>
<?php
    $host = 'localhost'; 
    $user = 'root'; 
    $password = 'root'; 
    $dbname = 'facaton'; 
    
    $db = mysqli_connect($host, $user, $password, $dbname);
    if (!$db) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $login=file_get_contents('login.txt');
    $password=file_get_contents('password.txt');
    $query="SELECT * FROM LoginandPassword WHERE login='$login' AND password='$password'";
    $result=mysqli_query($db, $query);
    $result=mysqli_fetch_assoc($result);
?>
<div class="content">
    <div class="menu">
        <div class="elem-menu"><img src="images/<?php echo $result['photo'];?>" alt=""><?php echo file_get_contents('login.txt') ?></div>
        <div class="elem-menu">
        <form action="homeAdmin.php" method="post">
            <div style=" display: none;"><input type="text" name="login" value="<?php echo file_get_contents('login.txt') ?>">
            <input type="text" name="password" value="<?php echo file_get_contents('password.txt') ?>"></div>
            <input type="submit" value="Главная">
    </form>
    </div>
        <div class="elem-menu"><a href="homeProvider.php">Запросы на подключение</a></div>
        <div class="elem-menu"><a href="">Админ панель</a></div>
        <div class="elem-menu atom-menu">WireMap</div>
    </div>
</div>
</body>
</html>