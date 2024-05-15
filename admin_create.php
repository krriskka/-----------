<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить мероприятие и место проведения</title>
    <link rel="stylesheet" href="assets/css/admin_read.css">
</head>
<body>
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
    <h1>Добавить новое мероприятие</h1>
    <form action="add_event.php" method="post">
        <h2>Данные мероприятия</h2>
        <label for="eventType">Тип мероприятия:</label>
        <input type="text" id="eventType" name="eventType" required><br><br>
        
        <label for="eventName">Название мероприятия:</label>
        <input type="text" id="eventName" name="eventName" required><br><br>
        
        <label for="eventDate">Дата мероприятия:</label>
        <input type="date" id="eventDate" name="eventDate" required><br><br>
        
        <label for="eventDescription">Описание мероприятия:</label>
        <textarea id="eventDescription" name="eventDescription" required></textarea><br><br>
        
        <label for="eventPosterUrl">URL постера мероприятия:</label>
        <input type="url" id="eventPosterUrl" name="eventPosterUrl"><br><br>
        
        <h2>Данные места проведения</h2>
        <label for="venueID">Выберите место проведения:</label>
        <select id="venueID" name="venueID" required>
            <?php
            // Подключение к базе данных
            $servername = "sql7.freemysqlhosting.net";
            $username = "sql7706675";
            $password = "j3AaYzXKTl";
            $dbname = "sql7706675";
            $conn = new mysqli($servername, $username, $password, $dbname);
            mysqli_set_charset($conn, "utf8");
            
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
            // Получение списка мест проведения
            $sql = "SELECT VenueID, VenueName FROM Venues";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["VenueID"] . "'>" . $row["VenueName"] . "</option>";
                }
            } else {
                echo "<option value=''>Нет доступных мест</option>";
            }
            $conn->close();
            ?>
        </select><br><br>
        
        <input type="submit" value="Добавить">
        <a href="admin.php" style="text-decoration:none;color:#333;">Назад</a>
    </form>
</body>
</html>
