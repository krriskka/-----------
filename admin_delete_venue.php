<?php

$servername = "sql7.freemysqlhosting.net"; // Имя сервера БД
$username = "sql7706675"; // Имя пользователя БД
$password = "j3AaYzXKTl"; // Пароль к БД
$dbname = "sql7706675"; // Имя вашей БД

$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8");

 if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Пытаемся удалить данные
$id = $_GET['id']; // Получаем ID из параметра GET
$sql = "DELETE FROM Venues WHERE VenueID = $id"; // SQL запрос на удаление
mysqli_query($conn, $sql); // Выполняем запрос

// Перенаправляем на страницу администратора после удаления
header("location: admin.php");

?>