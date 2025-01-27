<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WireMap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style/AdminPanel.css">
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
                    <div class="elem-menu"><img src="<?php echo $result['photo'];?>" alt=""><?php echo $result['login']; ?></div>
                    <div class="elem-menu"><a href="homeAdmin.php">Главная</a></div>
                    <div class="elem-menu"><a href="">Запрос на подключение</a></div>
                    <div class="elem-menu"><a href="AdminPanel.php">Админ панель</a></div>
                    <div class="elem-menu atom-menu"><img src="images/logo.png" alt=""></div>
                </div>
            </div>
    <!-- Админ панель -->
<div class="body">
    <h1 class="admPanel">Админ панель</h1>
    <div class="osnov">
        <div class="glav">
                <a href="createuser.php">Создать пользователя</a>
                <hr>
            <form method="post">
                <input type="submit" value="Admin" class="status-form" name="Admin"><br/>
                <input type="submit" value="Provider" class="status-form" name="provider">
            </form>
        </div>
        <div class="users">
            <p class="line">Пользователи</p>
            <table class="form" border="0"  cellpadding=10>
                <tr>
                    <td style="background: #D4E2FF;">Фамилия</td>
                    <td style="background: #D4E2FF;">Имя</td>
                    <td style="background: #D4E2FF;">Логин</td>
                    <td style="background: #D4E2FF;">Пароль</td>
                    
                </tr>
                
                <?php
                     if (!empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['status']) && !empty($_POST['photo'])){
                        $name = $_POST['name'];
                        $surname = $_POST['surname'];
                        $login = $_POST['login'];
                        $password = $_POST['password'];
                        $status = $_POST['status'];
                        $photo = $_POST['photo'];
                        $query = "INSERT INTO loginandpassword (login, password, Status, photo, surname, name) VALUES ('$login', '$password', '$status', '$photo', '$surname', '$name')";
                        mysqli_query($db, $query);
                        ?>
                        <script>
                            alert("Успешно");
                        </script>
                        <?php
                    }

                    $query="SELECT * FROM loginandpassword";
                    $result=mysqli_query($db, $query);
                    for($date=[]; $row=mysqli_fetch_assoc($result); $date[]=$row);
                    foreach ($date as $elem){
                        echo "<tr>";
                        if ($elem['Status']==$_POST['Admin'] || $elem['Status']==$_POST['provider'] ){
                            echo "<td>".$elem['surname']."</td>";
                            echo "<td>".$elem['name']."</td>";
                            echo "<td>".$elem['login']."</td>";
                            echo "<td>".$elem['password']."</td>";
                        }
                        echo "</tr>";
                    }
                ?>
            </table>
            
        </div>
    </div>
</div>


</body>
</html>