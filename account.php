<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="assets/css/account.css">
    <!-- Добавьте ваши стили -->
</head>
<body>
    <header>
        <h1>Личный кабинет</h1>
    </header>
    <nav>
    <a href="main.php">Главная</a>
    <a href="about.php">О нас</a>
    <a href="service.php">Наши услуги</a>
    <?php
if(isset($_SESSION['username'])){
    // Если пользователь авторизован, отображаем его имя и кнопку выхода
    echo '<div class="user-info">';
    echo '<a href="account.php">';
    echo '<button>' . $_SESSION['username'] . '</button>';
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
    <section class="user-info">
        <?php
    if(isset($_SESSION['username'])){
    // Выводим информацию о пользователе
    echo '<p>Имя пользователя: ' . $_SESSION['username'] . '</p>';
    // Подключаемся к базе данных для получения другой информации о пользователе
    $servername = "sql7.freemysqlhosting.net"; // Имя сервера БД
    $username = "sql7706675"; // Имя пользователя БД
    $password = "j3AaYzXKTl"; // Пароль к БД
    $dbname = "sql7706675"; // Имя вашей БД
    

    // Создаем подключение
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Проверяем подключение
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Подготавливаем SQL запрос для получения дополнительной информации о пользователе
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM Users WHERE Username='$username'";
    $result = $conn->query($sql);

    // Проверяем, есть ли результат
    if ($result->num_rows > 0) {
        // Выводим дополнительную информацию о пользователе
        while($row = $result->fetch_assoc()) {
            echo '<p>Email: ' . $row['Email'] . '</p>';
            // Добавьте другие поля из базы данных, если нужно
        }
    } else {
        echo "Дополнительная информация о пользователе не найдена";
    }

    // Закрываем соединение
    $conn->close();
} else {
    echo '<p>Вы не авторизованы</p>';
}
?>
    </section>

    <section class="orders">
        <!-- PHP-код для отображения заказанных услуг -->
        <?php include 'user_orders.php'; ?>
    </section>
    <section class="partyes">
        <!-- PHP-код для отображения заказанных услуг -->
        <?php include 'user_partyes.php'; ?>
    </section>
    <section class="bookings">
        <!-- PHP-код для отображения заказанных услуг -->
        <?php include 'user_booking.php'; ?>
    </section>
    
    <section class="change-password">
    <!-- Форма для изменения пароля -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="old-password">Старый пароль:</label>
        <input type="password" id="old-password" name="old-password" required><br>
        <label for="new-password">Новый пароль:</label>
        <input type="password" id="new-password" name="new-password" required><br>
        <label for="confirm-password">Подтвердите новый пароль:</label>
        <input type="password" id="confirm-password" name="confirm-password" required><br>
        <button type="submit">Изменить пароль</button>
    </form>
    <?php
    // Проверяем, была ли отправлена форма
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      
        // Подключение к базе данных
        $servername = "sql7.freemysqlhosting.net"; // Имя сервера БД
        $username = "sql7706675"; // Имя пользователя БД
        $password = "j3AaYzXKTl"; // Пароль к БД
        $dbname = "sql7706675"; // Имя вашей БД
        
// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_password = $_POST['old-password'];
    $new_password = $_POST['new-password'];
    $confirm_password = $_POST['confirm-password'];
    $username = $_SESSION['username'];

    // Проверка, совпадает ли старый пароль с паролем в базе данных
    $sql = "SELECT Password1 FROM Users WHERE Username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['Password1'];

        if (password_verify($old_password, $hashed_password)) {
            // Старый пароль верен, проверяем совпадение нового пароля и его подтверждения
            if ($new_password === $confirm_password) {
                // Хэшируем новый пароль
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                // Обновляем пароль в базе данных
                $update_sql = "UPDATE Users SET Password1='$hashed_new_password' WHERE Username='$username'";
                if ($conn->query($update_sql) === TRUE) {
                    echo "Пароль успешно изменен";
                } else {
                    echo "Ошибка при изменении пароля: " . $conn->error;
                }
            } else {
                echo "Новый пароль и его подтверждение не совпадают";
            }
        } else {
            echo "Старый пароль введен неверно";
        }
    } else {
        echo "Пользователь не найден";
    }
}

// Закрытие соединения
$conn->close();
       
    }
    ?>
</section>

    <!-- Добавьте другие разделы вашего личного кабинета, например, историю заказов, кнопку для выхода и т. д. -->
</body>
</html>
