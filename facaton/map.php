<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Яндекс Карта</title>
    <script src="https://api-maps.yandex.ru/2.1/?apikey=1b90df28-2bfc-4832-a2a9-d019caa8318a&lang=ru_RU" type="text/javascript"></script>
    <style>
        #map {
            width: 100%;
            height: 400px;
        }
    </style>
</head>
<body>
    <div id="map"></div>
    <form method="post">
        <input type="text" name="name" placeholder="Введите координаты" required>
        <input type="submit" value="Добавить метку">
    </form>
    <?php
        $host = 'localhost'; 
        $user = 'root'; 
        $password = 'root'; 
        $dbname = 'facaton'; 
        
        $db = mysqli_connect($host, $user, $password, $dbname);
        if (!$db) {
            die("Connection failed: " . mysqli_connect_error());
        }

        if (isset($_POST['name']) && !empty($_POST['name'])) {
            $coordinat = mysqli_real_escape_string($db, $_POST['name']);
            $query = "INSERT INTO coordinates (coordinat) VALUES ('$coordinat')";
            mysqli_query($db, $query);
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
                balloonContent: coordinat + '<br><a href=\"link.html\">Перейти к файлу</a>' // Ссылка на файл
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