<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="assets/css/account.css">
</head>
<body>
    <header>
        <h1>Личный кабинет</h1>
    </header>
    <nav>
        <a href="main_admin.php">Home</a>
        <a href="about_admin.php">About</a>
        <a href="service_admin.php">Services</a>
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
    <section class="user-info-container">
        <div class="info">
            <?php
            if (isset($_SESSION['username'])) {
                $servername = "sql7.freemysqlhosting.net"; // Имя сервера БД
                $dbUsername = "sql7709451"; // Имя пользователя БД
                $dbPassword = "4bisLes7Cr"; // Пароль к БД
                $dbname = "sql7709451"; // Имя вашей БД

                $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $username = $_SESSION['username'];
                $sql = "SELECT * FROM Users WHERE Username='$username'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        if (!empty($row['Photo'])) {
                            echo '<img src="uploads/' . $row['Photo'] . '" alt="User Photo" id="user-photo">';
                        } else {
                            echo '<img src="default-photo.jpg" alt="Default Photo" id="user-photo">';
                        }
                        echo '<input type="file" id="upload-photo" name="user-photo" accept="image/*" hidden>';
                        echo '<div>';
                        echo '<p>Имя пользователя: ' . $row['Username'] . '</p>';
                        echo '<p>Email: ' . $row['Email'] . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo "Дополнительная информация о пользователе не найдена";
                }

                $conn->close();
            }
            ?>
        </div>
    </section>

    <section class="orders">
        <?php include 'user_orders.php'; ?>
    </section>
    <section class="partyes">
        <?php include 'user_partyes.php'; ?>
    </section>
    <section class="bookings">
        <?php include 'user_booking.php'; ?>
    </section>
    
    <section class="change-password">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="old-password">Старый пароль:</label>
            <input type="password" id="old-password" name="old-password" required><br>
            <label for="new-password">Новый пароль:</label>
            <input type="password" id="new-password" name="new-password" required><br>
            <label for="confirm-password">Подтвердите новый пароль:</label>
            <input type="password" id="confirm-password" name="confirm-password" required><br>
            <button type="submit">Изменить пароль</button>
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $servername = "sql7.freemysqlhosting.net"; // Имя сервера БД
            $dbUsername = "sql7709451"; // Имя пользователя БД
            $dbPassword = "4bisLes7Cr"; // Пароль к БД
            $dbname = "sql7709451"; // Имя вашей БД

            $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $old_password = $_POST['old-password'];
            $new_password = $_POST['new-password'];
            $confirm_password = $_POST['confirm-password'];
            $username = $_SESSION['username'];

            $sql = "SELECT Password1 FROM Users WHERE Username='$username'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $hashed_password = $row['Password1'];

                if (password_verify($old_password, $hashed_password)) {
                    if ($new_password === $confirm_password) {
                        $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
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

            $conn->close();
        }
        ?>
    </section>
    <script>
        document.getElementById('user-photo').addEventListener('click', function() {
            document.getElementById('upload-photo').click();
        });

        document.getElementById('upload-photo').addEventListener('change', function() {
            const formData = new FormData();
            formData.append('user-photo', this.files[0]);

            fetch('upload_photo.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log(data);
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
</body>
</html>
