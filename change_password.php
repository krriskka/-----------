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
?>

