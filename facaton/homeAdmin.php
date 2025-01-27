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
                    <div class="elem-menu"><img src="<?php echo $result['photo'];?>" alt=""><?php echo $result['login']; ?></div>
                    <div class="elem-menu"><a href="homeAdmin.php">Главная</a></div>
                    <div class="elem-menu"><a href="">Запросы на подключение</a></div>
                    <?php $query="SELECT * FROM LoginandPassword WHERE login='$login' AND password='$password'";
                    $result=mysqli_query($db, $query);
                    $result=mysqli_fetch_assoc($result);
                    if ($result['Status']=='Admin') {
                    ?>
                    <div class="elem-menu"><a href="AdminPanel.php">Админ панель</a></div>
                <?php 
                    }
                    else {
                        ?>
                            <div class="elem-menu"></div>
                        <?php
                    }
                ?>
                
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
                        if ($result['max']==$result['current']) {
                            $color='islands#orangeCircleIcon';
                        echo '<font color=orange>Достинут предел.</font>';
                        }
                        else if ($result['max']<$result['current']) {
                            $color='islands#redCircleIcon';
                            echo '<font color=red>Аварийное состояние.</font>';
                        }
                        else {
                            $color='islands#greenCircleIcon';
                            echo '<font color=green>Опора в норме.</font>';
                        }
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
                        if ($result['Status']=='Admin') {
                    ?>
                    <b>Управление метками:</b><br/>
                    <u><a href="create.php">Создать метку</a></u></br>
                    <?php 
                            // $coordinat = $_POST['coordinates1'];
                            // $street = $_POST['street1'];
                            // $number = $_POST['number1'];
                            // $operator = $_POST['operator1'];
                            // $max = $_POST['max1'];
                            // $current = $_POST['current1'];
                            // echo $koor;
                            // $query="UPDATE coordinates SET street='$street', number='$number', operator='$operator', max='$max', current='$current'  WHERE coordinat='$koor'";
                            // $result=mysqli_query($db, $query);
                            
                            $coordinat=$_POST['coordinates1'];
                            if ($_POST['street1']!="") {
                                $street=$_POST['street1'];
                                $query="UPDATE coordinates SET street='$street' WHERE coordinat='$coordinat'";
                                $result=mysqli_query($db, $query);
                            }
                            if ($_POST['operator1']!="") {
                                $operator=$_POST['operator1'];
                                $query="UPDATE coordinates SET operator='$operator' WHERE coordinat='$coordinat'";
                                $result=mysqli_query($db, $query);
                            }
                            if ($_POST['number1']!="") {
                                $number=$_POST['number1'];
                                $query="UPDATE coordinates SET number='$number' WHERE coordinat='$coordinat'";
                                $result=mysqli_query($db, $query);
                            }
                            if ($_POST['max1']!="") {
                                $max=$_POST['max1'];
                                $query="UPDATE coordinates SET max='$max' WHERE coordinat='$coordinat'";
                                $result=mysqli_query($db, $query);
                            }
                            if ($_POST['current1']!="") {
                                $current=$_POST['current1'];
                                $query="UPDATE coordinates SET current='$current' WHERE coordinat='$coordinat'";
                                $result=mysqli_query($db, $query);
                            }
                        
                        

                    $del=$_GET['del'];
                    $query="DELETE FROM coordinates WHERE coordinat='$del'";
                    mysqli_query($db, $query);

                    $query="SELECT * FROM coordinates WHERE coordinat='$koor'";
                    $result=mysqli_query($db, $query);
                    $result=mysqli_fetch_assoc($result);
                    if ($koor!='') {  
                                          
                        ?> 
                            <u><a href="editing.php?mas[0]=<?php echo $result['coordinat']; ?>&mas[1]=<?php echo ($result['street']); ?>&mas[2]=<?php echo ($result['number']); ?>&mas[3]=<?php echo ($result['operator']); ?>&mas[4]=<?php echo ($result['max']); ?>&mas[5]=<?php echo ($result['current']); ?>">Редактировать информацию</a></u></br>
                            <u><a href="?del=<?php echo $koor?>"><font color=red>Удалить метку</font></a></u>

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
                        else {
                            ?>
                              <div><img src="images/треугольник.png" alt="" class="img-elem"></div>
                            <?php
                        }
                ?>
                </div>

            </div>
            <div class="footer">
    <div class="header">
                <div class="menu menu-footer">
                    <div class="elem-menu elem-menu-footer"><a href="homeAdmin.php">Главная</a></div>
                    <div class="elem-menu elem-menu-footer"><a href="">Личный кабинет</a></div>
                    <div class="elem-menu elem-menu-footer"><a href="homeProvider.php">Запросы на подключение</a></div>
                    <?php $query="SELECT * FROM LoginandPassword WHERE login='$login' AND password='$password'";
                    $result=mysqli_query($db, $query);
                    $result=mysqli_fetch_assoc($result);
                    if ($result['Status']=='Admin') {
                    ?>
                    <div class="elem-menu elem-menu-footer"><a href="AdminPanel.php">Админ панель</a></div>
                <?php 
                    }
                    else {
                        ?>
                            <div class="elem-menu"></div>
                        <?php
                    }
                ?>
                 
                </div>
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
    if (!empty($_POST['coordinates']) && !empty($_POST['number']) && !empty($_POST['operator']) && !empty($_POST['max']) && !empty($_POST['currnet']) && !empty($_POST['street'])){
        $coordinat = $_POST['coordinates'];
        $street = $_POST['street'];
        $number = $_POST['number'];
        $operator = $_POST['operator'];
        $max = $_POST['max'];
        $current = $_POST['currnet'];
        $query = "INSERT INTO coordinates (coordinat, street, number, operator, max, current) VALUES ('$coordinat', '$street', '$number', '$operator', '$max', '$current')";
        mysqli_query($db, $query);
        ?>
        <script>
            alert("Успешно");
        </script>
        <?php
    }
    
?>
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
                preset: 'islands#blueCircleIcon' // Устанавливаем цвет метки
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