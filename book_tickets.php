<?php
session_start();

// Подключение к базе данных
$servername = "sql7.freemysqlhosting.net"; // Имя сервера БД
$username = "sql7709451"; // Имя пользователя БД
$password = "4bisLes7Cr"; // Пароль к БД
$dbname = "sql7709451"; // Имя вашей БД

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8");

// Проверка подключения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Проверяем, передан ли параметр event_id в URL
if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Запрос к базе данных для получения информации о мероприятии
    $sql = "SELECT e.*, v.VenueName FROM Events e
            JOIN Venues v ON e.VenueID = v.VenueID
            WHERE EventID = $event_id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $event = $result->fetch_assoc();
        $venue_name = $event['VenueName'];
        $event_name = $event['EventName'];
        $event_date = $event['EventDate'];
        $event_description = $event['EventDescription'];
        $event_poster = $event['EventPoster'];
    } else {
        echo "Event not found";
        exit;
    }
} else {
    echo "Event ID not provided";
    exit;
}

// Если форма бронирования отправлена
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $user_id = $_SESSION['UserID']; // Предполагается, что ID пользователя хранится в сессии

    // Запрос для вставки данных о бронировании в базу данных
    $stmt = $conn->prepare("INSERT INTO Bookings (EventID, UserID, Name, Email, BookingDate) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("iiss", $event_id, $user_id, $name, $email);

    if ($stmt->execute()) {
        echo "<p>Thank you, $name! Your tickets for $event_name on $event_date at $venue_name have been booked.</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Tickets</title>
    <link rel="stylesheet" href="assets/css/booking.css">
</head>
<body>
    <h1>Book Tickets for <?php echo htmlspecialchars($event_name); ?></h1>
    <p><?php echo htmlspecialchars($event_description); ?></p>
    <p>Date: <?php echo htmlspecialchars($event_date); ?></p>
    <p>Venue: <?php echo htmlspecialchars($venue_name); ?></p>
    <?php if (!empty($event_poster)) : ?>
        <img src="<?php echo htmlspecialchars($event_poster); ?>" alt="Event Poster">
    <?php endif; ?>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?event_id=' . $event_id; ?>">
        <label for="name">Your Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="email">Your Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <input type="submit" value="Book Tickets">
    </form>
</body>
</html>

<?php
$conn->close();
?>
