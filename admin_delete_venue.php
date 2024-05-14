<?php

$servername = "sql11.freemysqlhosting.net";
$username = "sql11705022";
$password = "YImWifSKV7";
$dbname = "sql11705022";
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