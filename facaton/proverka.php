<?php
$host = 'localhost'; 
$user = 'root'; 
$password = 'root'; 
$dbname = 'facaton'; 

$db = mysqli_connect($host, $user, $password, $dbname);
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}


if ($_POST['name']==true){
    $coordinat=$_POST['name'];
    $query="INSERT INTO coordinates VALUES (NULL, '$coordinat')";
    $result=mysqli_query($db, $query);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="map.php">Назад</a>
</body>
</html>