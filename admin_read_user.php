<?php
session_start();


// Проверяем, существует ли параметр id перед выполнением дальнейших действий
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $servername = "sql7.freemysqlhosting.net"; // Имя сервера БД
    $username = "sql7706675"; // Имя пользователя БД
    $password = "j3AaYzXKTl"; // Пароль к БД
    $dbname = "sql7706675"; // Имя вашей БД
    
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    mysqli_set_charset($conn, "utf8");
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "SELECT * FROM Users WHERE UserID = ?";
    
    // Prepare and execute the SQL query
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $_GET["id"]);
        
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            
            // Check if rows were returned
            if (mysqli_num_rows($result) > 0) {
                // Fetch the data
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Output the data
                // Your HTML code here
            } else {
                echo "No records found.";
            }
        } else {
            echo "Error executing the SQL query: " . mysqli_error($conn);
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing the SQL statement: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    exit(); // Exit if id parameter is missing or empty
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Информация о пользоваетеле <?= htmlspecialchars($row["Username"]); ?></title>
<link rel="stylesheet" href="assets/css/admin_read.css">
</head>
<body class="body">

<header style="background-image: url('https://via.placeholder.com/1500x600/FF5733/000000/?text=Event+Planner');">
        <h1>Планирование вечеринок и событий</h1>
    </header>
    <nav>
    <a href="main.php">Главная</a>
    <a href="about.php">О нас</a>
    <a href="service.php">Наши услуги</a>
    <a href="admin.php">Страница администратора</a>
    <?php
if(isset($_SESSION['username'])){
    // Если пользователь авторизован, отображаем его имя и кнопку выхода
    echo '<div class="user-info">';
    echo '<a href="account.php">';
    echo '<button>' .$_SESSION['username'] . '</button>';
    echo '</a>';
    echo '</div>';
    echo '<form action="logout.php" method="post">';
    echo '<button type="submit" name="logout">Выйти</button>';
    echo '</form>';
} else {
    // Если пользователь не авторизован, перенаправляем его на страницу входа
    echo '<a href="login.html">Войти</a>';
}
?>
</nav>
<div>
    <div style="position: relative; left:20px; top:20px; " class="login_container">
        <div class="page-header">
            <h1>Просмотр страницы пользователя</h1>
        </div>
        <div>
            <!-- Отображение информации о товаре -->
            <div class="grey_container">
                <label>Username</label>
                <p class="form-control-static"><?php echo $row["Username"]; ?></p>
            </div>

            <div class="grey_container">
                <label>Email</label>
                <p class="form-control-static"><?php echo $row["Email"]; ?></p>
            </div>

            <div class="grey_container">
                <label>Password1</label>
                <p class="form-control-static"><?php echo $row["Password1"]; ?></p>
            </div>

            <div class="grey_container">
                <label>isAdmin</label>
                <p class="form-control-static"><?php echo $row["isAdmin"]; ?></p>
            </div>

            <p>
                <!-- Другие элементы интерфейса, если необходимо -->
            </p>
        </div>
        <div>
            <!-- Кнопка для возврата на страницу администратора -->
            <a class="button_return" href="admin.php">Вернуться</a>
        </div>
    </div>
</div>
</body>
</html>