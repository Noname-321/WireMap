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

if ($_SESSION['login']!=$_POST['login'] && isset($_POST['login']) && $_SESSION['password']!=$_POST['password'] && isset($_POST['password'])) {
$_SESSION['login'] = $_POST['login'];
$_SESSION['password'] = $_POST['password'];
}

$login = $_SESSION['login'];
$password = $_SESSION['password'];

$query="SELECT * FROM LoginandPassword WHERE login='$login' AND password='$password'";
$result=mysqli_query($db, $query);
$result=mysqli_fetch_assoc($result);

if ($result){
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
            <div class="content">
                <div class="elem-content map">
                    <div id="map"></div>
                </div>
                <?php
                    $koor=$_GET['coor'];
                    $query="SELECT * FROM coordinates WHERE coordinat='$koor'";
                    $result=mysqli_query($db, $query);
                    $result=mysqli_fetch_assoc($result);
                ?>
                
                <div class="elem-content">
                    <b>Информация о состоянии опоры:</b><br/>
                    <u>Статус: </u><?php 
                    if ($koor!='') {
                    if ($result['max']==$result['current'])echo '<font color=orange>Достинут предел.</font>';
                    else if ($result['max']<$result['current'])echo '<font color=red>Аварийное состояние.</font>';
                    else echo '<font color=green>Опора в норме.</font>';
                    }
                    else {
                        echo "-";
                    }
                    ?><br/>
                    <u>Местоположение: </u>
                        <?php
                            echo $result['street'];
                        ?><br/>
                    <u>Номер опоры: </u>
                        <?php
                            echo $result['number'];
                        ?><br/>
                        <u>Зарегистрированные операторы: </u>
                        <?php
                            echo $result['operator'];
                        ?><br/>
                        <div class="triangle">
                            <img src="images/треугольник.png" alt="">
                        </div>

                </div>
                <div class="elem-content">
                    <?php
                    $query="SELECT * FROM LoginandPassword WHERE login='$login' AND password='$password'";
                    $result=mysqli_query($db, $query);
                    $result=mysqli_fetch_assoc($result);
                        if ($result['Status']=='admin') {
                    ?>
                    <b>Управление метками:</b><br/>
                    <u><a href="create.php">Создать метку</a></u></br>
                    <?php 
                    if ($koor!='') {
                        ?> 
                            <u><a href="">Редактировать информацию</a></u></br>
                            <u><a href=""><font color=red>Удалить метку</font></a></u>

                        <?php
                    }
                    else {
                       
                    }
                    ?>
                    <div class="triangle">
                        <img src="images/треугольник.png" alt="">
                    </div>
                <?php
                        }
                ?>
                </div>

            </div>
        <?php
    }
    else {
        echo "Не успешно";
        ?>
            <a href="entry.php">Вернуться назад</a>
        <?php
    }

    //карта
    if (isset($_POST['name']) && !empty($_POST['name'])) {
        $coordinat = mysqli_real_escape_string($db, $_POST['name']);
        $query = "INSERT INTO coordinates (coordinat) VALUES ('$coordinat')";
        mysqli_query($db, $query);
    }
?>
<div class="footer">
<div class="header">
                <div class="menu menu-footer">
                    <div class="elem-menu elem-menu-footer"><a href="javascript:void(0);" onclick="window.location.reload();">Главная</a></div>
                    <div class="elem-menu elem-menu-footer"><a href="">Личный кабинет</a></div>
                    <div class="elem-menu elem-menu-footer"><a href="homeProvider.php">Запросы на подключение</a></div>
                    <div class="elem-menu elem-menu-footer"><a href="">Админ панель</a></div>
                 
                </div>
            </div>
</div>
<script>
        ymaps.ready(init);

        function init() {
            // Создаем объект карты
            var myMap = new ymaps.Map("map", {
                center: [56.321817, 43.946518], // Центр карты - начальные координаты
                zoom: 12
            });

            // Создаем метки
            <?php 
                $query = "SELECT * FROM coordinates";
                $result = mysqli_query($db, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    if (isset($row['coordinat'])) {
            ?>
            var coordinat = '<?php echo $row['coordinat']; ?>';
            var myPlacemark = new ymaps.Placemark([<?php echo $row['coordinat']; ?>], {
                balloonContent: coordinat + '<br><a href=\"?coor='+coordinat+'\">Перейти к файлу</a>' // Ссылка на файл
            }, {
                preset: 'islands#greenCircleIcon' // Устанавливаем цвет метки
            });

            // Добавляем метку на карту
            myMap.geoObjects.add(myPlacemark);
            <?php 
                    }
                }
            ?>
        }
    </script>
</body>
</html>