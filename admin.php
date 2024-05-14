<?php
session_start();


// Check admin authentication
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    // If not authenticated, redirect to login page
    header("Location: login.html");
    exit();
}

// Database connection parameters
$servername = "sql11.freemysqlhosting.net";
$username = "sql11705022";
$password = "YImWifSKV7";
$dbname = "sql11705022";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update event information
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateEvent'])) {
    $eventId = $_POST['eventId'];
    $eventDate = $_POST['eventDate'];
    $eventDescription = $_POST['eventDescription'];

    $sql = "UPDATE Events SET EventDate='$eventDate', EventDescription='$eventDescription' WHERE EventID='$eventId'";

    if ($conn->query($sql) === TRUE) {
        echo "Event information updated successfully";
    } else {
        echo "Error updating event information: " . $conn->error;
    }
}

// Add new event
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addEvent'])) {
    $eventName = $_POST['eventName'];
    $eventDate = $_POST['eventDate'];
    $eventDescription = $_POST['eventDescription'];

    $sql = "INSERT INTO Events (EventName, EventDate, EventDescription) VALUES ('$eventName', '$eventDate', '$eventDescription')";

    if ($conn->query($sql) === TRUE) {
        echo "New event added successfully";
    } else {
        echo "Error adding new event: " . $conn->error;
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
<style>
    body {
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f0f0f0;
    color: #333;
}
header {
    background-color: #ff7f50;
    color: #fff;
    padding: 30px 20px;
    text-align: center;
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
}
header h1 {
    font-size: 36px;
    margin: 0;
    letter-spacing: 2px;
    text-transform: uppercase;
    font-family: 'Montserrat', sans-serif;
}

nav .user-info {
    display: inline-block;
    margin-right: 10px;
    line-height: 40px; /* Установим высоту строки равной высоте кнопки */
}

/* Стили для кнопки выхода */
nav form {
    display: inline-block;
    margin-top: 6px; /* Добавим немного отступа сверху, чтобы скорректировать выравнивание */
}

/* Стили для кнопок */
nav button {
    background: none;
    border: none;
    cursor: pointer;
    font-size: inherit;
    color: inherit;
    padding: 0;
    vertical-align: middle; /* Выравнивание кнопок по вертикали */
    transition: color 0.3s ease; /* Анимация изменения цвета текста */
}

/* Стили для навигационного меню */
nav {
    background-color: rgba(255, 204, 128, 0.8);
    color: #333;
    padding: 10px;
    text-align: center;
}

nav a {
    color: #333;
    text-decoration: none;
    margin: 0 10px;
    transition: color 0.3s ease; /* Анимация изменения цвета ссылок */
}

nav a:hover, nav button:hover {
    color: #ff6f00; /* Цвет элемента при наведении */
}

section {
    padding: 40px 20px;
    margin-top: 40px;
    background-color: #fff;
    border-radius: 20px;
    box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
}
h2 {
    font-size: 24px;
    margin-bottom: 20px;
    text-align: center;
}
p {
    font-size: 18px;
    margin-bottom: 20px;
    line-height: 1.6;
}
ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}
form {
    margin-top: 20px;
}
label {
    display: block;
    margin-bottom: 10px;
}
input[type="text"],
input[type="email"],
input[type="date"],
input[type="number"],
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}
button[type="submit"] {
    background-color: #ff7f50;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}
button[type="submit"]:hover {
    background-color: #ff6f00;
}
.table_container {
    max-width: 80%;
    margin: 20px auto;
    background-color: #fff;
    color: #333;
    padding: 10px;
    border-radius: 25px;
    box-shadow: 20px 20px 50px rgba(0,0,0,0.1);
    font-size:18px;
  }
  table.table-bordered.table-striped th,
table.table-bordered.table-striped td {
    text-align: center; /* Выравнивание текста по центру */
    vertical-align: middle; /* Выравнивание по вертикали посередине */
    height: 100%; /* Установка высоты элемента на 100% */
    padding: 20px; /* Поля вокруг текста */
}

</style>
</head>

    <header style="background-image: url('https://via.placeholder.com/1500x600/FF5733/000000/?text=Event+Planner');">
        <h1>Admin Panel</h1>
    </header>
    <nav>
        <a href="main.php">Home</a>
        <a href="about.php">About</a>
        <a href="service.php">Services</a>
        <?php
            if(isset($_SESSION['username'])){
                echo '<div class="user-info">';
                echo '<a href="account.php">';
                echo '<button>' .$_SESSION['username'] . '</button>';
                echo '</a>';
                echo '</div>';
                echo '<form action="logout.php" method="post">';
                echo '<button type="submit" name="logout">Logout</button>';
                echo '</form>';
            } else {
                echo '<a href="login.html">Login</a>';
            }
        ?>
    </nav>

    <div class="wrapper">
    <div class="table_container">
        <div class="row">

            <div class="color_font">
                <div class="page-header clearfix">
                    <h2 class="pull-left">Venues</h2>
                    <form method="post"></form>
                </div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Capacity</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
                // Reopen connection
                $conn = new mysqli($servername, $username, $password, $dbname);
                mysqli_set_charset($conn, "utf8");
                $sql = "SELECT * FROM Venues ORDER BY VenueID ASC";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['VenueID'] . "</td>";
                        echo "<td>" . $row['VenueName'] . "</td>";
                        echo "<td>" . $row['VenueAddress'] . "</td>";
                        echo "<td>" . $row['VenueCapacity'] . "</td>";
                        echo "<td>" . $row['VenuePrice'] . "</td>";
                        echo "<td>";
                        echo "<a href='admin_read_venues.php?id=" . $row['VenueID'] . "' class='btn btn-outline-dark btn-sm'><i class='bi bi-eye-fill'></i></a>";
                        echo "<a href='admin_update_venues.php?id=" . $row['VenueID'] . "' class='btn btn-outline-dark btn-sm'><i class='bi bi-pen-fill'></i></a>";
                        echo "<a href='admin_delete_venue.php?id=" . $row['VenueID'] . "' class='btn btn-outline-dark btn-sm'><i class='bi bi-trash3-fill'></i></a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    mysqli_free_result($result);
                } else {
                    echo "<tr><td colspan='5'>No events found</td></tr>";
                }

                // Close connection
                $conn->close();
            ?>
        </tbody>
    </table>
    </div>
    </div>
    </div>
    </div>

    <div class="wrapper">
    <div class="table_container">
        <div class="row">

            <div class="color_font">
                <div class="page-header clearfix">
                    <h2 class="pull-left">Venues</h2>
                    <form method="post"></form>
                </div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Date</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
                // Reopen connection
                $conn = new mysqli($servername, $username, $password, $dbname);
                mysqli_set_charset($conn, "utf8");
                $sql = "SELECT * FROM Events ORDER BY EventID ASC";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['EventID'] . "</td>";
                        echo "<td>" . $row['EventName'] . "</td>";
                        echo "<td>" . $row['EventDate'] . "</td>";
                        echo "<td>" . $row['EventDescription'] . "</td>";
                        echo "<td>";
                        echo "<a href='admin_read_event.php?id=" . $row['EventID'] . "' class='btn btn-outline-dark btn-sm'><i class='bi bi-eye-fill'></i></a>";
                        echo "<a href='admin_update_event.php?id=" . $row['EventID'] . "' class='btn btn-outline-dark btn-sm'><i class='bi bi-pen-fill'></i></a>";
                        echo "<a href='admin_delete_event.php?id=" . $row['EventID'] . "' class='btn btn-outline-dark btn-sm'><i class='bi bi-trash3-fill'></i></a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    mysqli_free_result($result);
                } else {
                    echo "<tr><td colspan='5'>No events found</td></tr>";
                }

                // Close connection
                $conn->close();
            ?>
        </tbody>
    </table>
    </div>
    </div>
    </div>
    </div>
<div class="wrapper">
    <div class="table_container">
        <div class="row">

            <div class="color_font">
                <div class="page-header clearfix">
                    <h2 class="pull-left">Venues</h2>
                    <form method="post"></form>
                </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Password1</th>
                <th>isAdmin</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
                // Reopen connection
                $conn = new mysqli($servername, $username, $password, $dbname);
                mysqli_set_charset($conn, "utf8");
                $sql = "SELECT * FROM Users ORDER BY UserID ASC";
                $result = mysqli_query($conn, $sql);

                mysqli_set_charset($conn, "utf8");
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['UserID'] . "</td>";
                        echo "<td>" . $row['Username'] . "</td>";
                        echo "<td>" . $row['Email'] . "</td>";
                        echo "<td>" . $row['Password1'] . "</td>";
                        echo "<td>" . $row['isAdmin'] . "</td>";
                        echo "<td>";
                        echo "<a href='admin_read_user.php?id=" . $row['UserID'] . "' class='btn btn-outline-dark btn-sm'><i class='bi bi-eye-fill'></i></a>";
                        echo "<a href='admin_update_user.php?id=" . $row['UserID'] . "' class='btn btn-outline-dark btn-sm'><i class='bi bi-pen-fill'></i></a>";
                        echo "<a href='admin_delete_user.php?id=" . $row['UserID'] . "' class='btn btn-outline-dark btn-sm'><i class='bi bi-trash3-fill'></i></a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    mysqli_free_result($result);
                } else {
                    echo "<tr><td colspan='5'>No events found</td></tr>";
                }

                // Close connection
                $conn->close();
            ?>
        </tbody>
    </table>
    </div>
    </div>
    </div>
    </div>
</body>
</html>
