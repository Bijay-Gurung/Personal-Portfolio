<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'blogs';

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$sql = "SELECT * FROM `blog`";

$result = $mysqli->query($sql);

if ($result === false) {
    echo "Query error: " . $mysqli->error;
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link href="blog.css" rel="stylesheet">
</head>
<body>
    <header>
    <h3>BijayGurung<span>{}</span>;</h3>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="project.html">Projects</a></li>
                <li><a href="blog.html">Blog</a></li>
                <li><a href="signup.php">Signup</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="https://www.linkedin.com/in/bijay-gurung-521b99263/" alt="Linkedin" target="_blank"><i class="fa-brands fa-linkedin" id="linkedin"></i></a></li>
                <li><a href="https://www.instagram.com/karma_gurung1/" alt="Instagram" target="_blank"><i class="fa-brands fa-instagram" id="instagram"></i></a></li>
                <li><a href="https://github.com/Bijay-Gurung" alt="Github" target="_blank"><i class="fa-brands fa-github" id="github"></i></a></li>
            </ul>
        </nav>
    </header>

    <section>
        <h1>Blogs</h1>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='blog-post'>";
                echo "<h3 class='title'>" . $row["title"] . "</h3>";
                echo "<span class='category'>" . $row["category"] . "/" . "</span>";
                echo "<span class='date'>" . $row["created"] . "</span>";
                echo "<br>";

                // Check if the 'images' column contains image data
                if (!empty($row['images'])) {
                    $imgData = base64_encode($row['images']);
                    echo "<img src='data:image/jpeg;base64," . $imgData . "' alt='Blog Image' height='300px' width='250px'/>";
                } else {
                    echo "No image found.";
                }

                echo "<br>";
                echo "<p class='paragraph'>" . $row["content"] . "</p>";
                echo "</div>";

                echo "<div class='commentBox'>";
                echo "<form method='post' enctype='multipart/form-data'>";
                echo "<h3>Comment</h3>";
                echo "<input type='text' placeholder='Name' name='name' id='name' required>";
                echo "<br>";
                echo "<textarea rows='5' cols='24' placeholder='Add your Comment' name='comments' id='comments' required></textarea>";
                echo "<br>";
                echo "<input type='submit' value='Post' id='submit' name='submit'>";
                echo "</form>";
                echo "</div>";

                echo "<div class='bottomLine'></div>";
            }
        } else {
            echo "Nothing Post.";
        }

        $result->free_result();
        $mysqli->close();
        ?>
    </section>
</body>
</html>
