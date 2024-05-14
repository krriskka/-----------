<?php
session_start(); // Начало сессии для хранения состояния авторизации пользователя

// Подключение к базе данных
$servername = "sql11.freemysqlhosting.net"; // Имя сервера БД
$username = "sql11705022"; // Имя пользователя БД
$password = "YImWifSKV7"; // Пароль к БД
$dbname = "sql11705022"; // Имя вашей БД

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Обработка запроса на авторизацию
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Запрос на получение данных пользователя из базы данных
    $sql = "SELECT * FROM Users WHERE Username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Пользователь найден в базе данных
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['Password1'])) {
            // Пароль совпадает, авторизация успешна
            $_SESSION['username'] = $username; // Сохраняем имя пользователя в сессии
            $_SESSION['UserID'] = $row['UserID']; // Сохраняем userid в сессии

            if ($row['isAdmin'] == 1) {
                // Если пользователь - администратор, устанавливаем сеанс администратора
                $_SESSION['admin'] = true;
                header("Location: admin.php"); // Перенаправляем на страницу администратора
            } else {
                // Если не администратор, устанавливаем обычный сеанс
                $_SESSION['admin'] = false;
                header("Location: main.php?username=$username"); // Перенаправляем на главную страницу с именем пользователя в качестве параметра
            }
            exit();
        } else {
            // Неправильный пароль
            echo "Неправильное имя пользователя или пароль.";
        }
    }
}

// Закрытие соединения
$conn->close();
?>
