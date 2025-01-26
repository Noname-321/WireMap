<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WireMap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style/homeAdmin.css">
    <script src="https://api-maps.yandex.ru/2.1/?apikey=1b90df28-2bfc-4832-a2a9-d019caa8318a&lang=ru_RU" type="text/javascript"></script>
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



$login = $_SESSION['login'];
$password = $_SESSION['password'];

$query="SELECT * FROM LoginandPassword WHERE login='$login' AND password='$password'";
$result=mysqli_query($db, $query);
$result=mysqli_fetch_assoc($result);
?>

            <div class="header">
                <div class="menu">
                    <div class="elem-menu"><img src="images/<?php echo $result['photo'];?>" alt=""><?php echo $result['login']; ?></div>
                    <div class="elem-menu"><a href="homeAdmin.php">Главная</a></div>
                    <div class="elem-menu"><a href="">Запросы на подключение</a></div>
                    <div class="elem-menu"><a href="">Админ панель</a></div>
                    <div class="elem-menu atom-menu"><img src="images/logo.png" alt=""></div>
                </div>
            </div>
    
</body>
</html>