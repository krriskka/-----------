<?php
session_start();


// Check admin authentication
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    // If not authenticated, redirect to login page
    header("Location: login.html");
    exit();
}

// Database connection parameters
$servername = "sql7.freemysqlhosting.net"; // Имя сервера БД
$username = "sql7709451"; // Имя пользователя БД
$password = "4bisLes7Cr"; // Пароль к БД
$dbname = "sql7709451"; // Имя вашей БД


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
</head>

    <header style="background-image: url('https://via.placeholder.com/1500x600/FF5733/000000/?text=Event+Planner');">
        <h1>Admin Panel</h1>
    </header>
    <nav>
        <a href="main_admin.php">Home</a>
        <a href="about_admin.php">About</a>
        <a href="service_admin.php">Services</a>
        <a href="admin_create.php" class="button_green">Добавить вечеринку</a>
        <a href="admin.php">Страница администратора</a>
        <?php
        if (isset($_POST['click']) && !empty($_POST['click'])) {
            // Перенаправляем на создание записи
            header("location:admin_create.php");
        }
            if(isset($_SESSION['username'])){
                echo '<div class="user-info">';
                echo '<a href="account_admin.php">';
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
                    <h2 class="pull-left">Events</h2>
                    <form method="post"></form>
                </div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Date</th>
                <th>Description</th>
                <th>PosterLink</th>
                <th>Type</th>
                <th>VenueID</th>
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
                        echo "<td>" . $row['EventPoster'] . "</td>";
                        echo "<td>" . $row['EventType'] . "</td>";
                        echo "<td>" . $row['VenueID'] . "</td>";
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
                    <h2 class="pull-left">Users</h2>
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
