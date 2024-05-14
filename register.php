<?php
session_start();

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

// Обработка запроса на регистрацию
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Хэширование пароля
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Добавление пользователя в базу данных
    $sql = "INSERT INTO Users (Username, Email, Password1) VALUES ('$username', '$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        // Получаем ID последней вставленной записи (userid)
        $userid = $conn->insert_id;

        // Проверяем, является ли пользователь администратором
        $isAdmin = ($_POST['role'] === 'admin') ? 1 : 0;

        // Обновляем запись пользователя в базе данных с указанием его роли
        $update_sql = "UPDATE Users SET isAdmin=$isAdmin WHERE userid=$userid";
        if ($conn->query($update_sql) === TRUE) {
            // Сохраняем username и userid в сессии
            $_SESSION['username'] = $username;
            $_SESSION['userid'] = $userid;

            // Проверяем роль пользователя и перенаправляем на соответствующую страницу
            if ($isAdmin) {
                // Пользователь - администратор, перенаправляем на страницу для администраторов
                header("Location: admin.php");
            } else {
                // Пользователь - обычный пользователь, перенаправляем на главную страницу
                header("Location: main.php?username=$username");
            }
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Закрытие соединения
$conn->close();
?>
