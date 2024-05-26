<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/mainstyle.css">
    <title>Планирование вечеринок и событий</title>
</head>
<body>


    <header style="background-image: url('https://via.placeholder.com/1500x600/FF5733/000000/?text=Event+Planner');">
        <h1>Планирование вечеринок и событий</h1>
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
    <section class="hallo">
       
        <h2>Добро пожаловать на наш сайт!</h2>
        <p>Здесь вы найдете всю необходимую информацию о планировании и проведении вечеринок и различных событий.</p>
        <p>Мы предлагаем широкий спектр услуг, чтобы сделать ваше событие незабываемым.</p>
    </section>
    <section class="services">
        <div class="service">
            <h3>Организация мероприятий</h3>
            <p>Мы поможем вам организовать идеальное мероприятие с учетом ваших пожеланий и бюджета.</p>
        </div>
        <div class="service">
            <h3>Декорации и украшения</h3>
            <p>Наши специалисты создадут волшебную атмосферу с помощью красивых декораций и украшений.</p>
        </div>
        <div class="service">
            <h3>Музыка и развлечения</h3>
            <p>Мы предоставим профессиональных диджеев и артистов, чтобы ваше мероприятие было запоминающимся.</p>
        </div>
    </section>
    <section class="about">
        <h2>О нас</h2>
        <p>Мы - команда профессионалов, специализирующаяся на планировании и проведении вечеринок и событий различного масштаба.</p>
        <p>Наша цель - сделать каждое мероприятие незабываемым и уникальным для наших клиентов.</p>
    </section>
   
    <section class="gallery">
        <h2>Галерея</h2>
        <img src="https://via.placeholder.com/300/FF5733/FFFFFF/?text=Party1" alt="Изображение 1">
        <img src="https://via.placeholder.com/300/FF5733/FFFFFF/?text=Party2" alt="Изображение 2">
        <img src="https://via.placeholder.com/300/FF5733/FFFFFF/?text=Party3" alt="Изображение 3">
    </section>

    <section class="reviews">
        <h2>Отзывы клиентов</h2>
        <div class="review">
            <h3>Иванов Иван</h3>
            <p>Организовали потрясающую вечеринку! Все было на высшем уровне, спасибо большое!</p>
        </div>
        <div class="review">
            <h3>Анна Сергеева</h3>
            <p>Декорации просто волшебные! Наше мероприятие было украшено так красиво, что все гости были в восторге!</p>
        </div>
        <div class="review">
            <h3>Олег Балакин</h3>
            <p>Благодарю за профессиональный подход к музыкальному сопровождению нашей вечеринки! Все песни были идеально подобраны.</p>
        </div>
    </section>

    <section class="contact">
        <h2>Контакты</h2>
        <p>Адрес: ул. Примерная, д. 123, г. Примерный</p>
        <p>Телефон: +7 (123) 456-7890</p>
        <p>Email: info@partyplanners.com</p>
    </section>
        <form action="#" method="post">
            <input type="text" name="name" placeholder="Ваше имя" required><br>
            <input type="email" name="email" placeholder="Ваш Email" required><br>
            <textarea name="message" placeholder="Ваше сообщение" rows="4" required></textarea><br>
            <input type="submit" value="Отправить">
        </form>
    </section>
</body>
</html>
