<?php
$servername = "sql7.freemysqlhosting.net"; // Имя сервера БД
$username = "sql7709451"; // Имя пользователя БД
$password = "4bisLes7Cr"; // Пароль к БД
$dbname = "sql7709451"; // Имя вашей БД

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventType = $_POST['eventType'];
    $eventName = $_POST['eventName'];
    $eventDate = $_POST['eventDate'];
    $eventDescription = $_POST['eventDescription'];
    $eventPosterUrl = $_POST['eventPosterUrl'];
    $venueID = $_POST['venueID'];
    
    // Подключение к базе данных
    $conn = new mysqli($servername, $username, $password, $dbname);
    mysqli_set_charset($conn, "utf8");
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Вставка данных в таблицу Events
    $stmt = $conn->prepare("INSERT INTO Events (EventType, EventName, EventDate, EventDescription, EventPoster, VenueID) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $eventType, $eventName, $eventDate, $eventDescription, $eventPosterUrl, $venueID);
    
    if ($stmt->execute() === TRUE) {
        echo "Новое мероприятие успешно создано";
        header("Location: admin.php?username=$username");
    } else {
        echo "Ошибка: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
}
?>
