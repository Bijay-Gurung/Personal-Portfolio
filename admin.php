<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="admin.css" rel="stylesheet">
    <title>Admin Panel</title>
</head>
<body>
    <aside>
        <nav class="sideNav">
            <h2>Admin Panel</h2>
            <div class="userProfile"></div>
            <span class="name">Bijay Gurung</span> <!-- we have to take the name and email from database. -->
            <br>
            <span class="email">stha4580@gmail.com</span> 
            <ul>
                <li><a href="admin.php" id="dashboard"><i class="fa-solid fa-gauge"></i>Dashboard</a></li>
                <li><a href="blogPost.php" id="blogPost"><i class="fa-solid fa-pen"></i>Blog Post</a></li>
                <li><a href="comments.php" id="comments"><i class="fa-solid fa-comment"></i>Comments</a></li>
                <li><a href="categories.php" id="categories"><i class="fa-solid fa-clipboard"></i>Categories and Tags</a></li>
                <li><a href="#" id="mediaLibrary"><i class="fa-solid fa-folder-open"></i>Media Library</a></li>
                <li><a href="user.php" id="user"><i class="fa-solid fa-user"></i>User</a></li>
                <li><a href="#" id="notifications"><i class="fa-solid fa-bell"></i>Notifications</a></li>
                <li><a href="#" id="setting"><i class="fa-solid fa-gear"></i>Setting</a></li>
            </ul>
        </nav>
</aside>

<section> <!--Use Dom for this section-->
<h1>Dashboard</h1>

    <div class="totalPost">
        <h3>Total Post</h3>
        <p id="numOfPost">0</p><!--Make both h3 and p entire div clickable. link with a tag anchor-->
    </div>

    <div class="totalUser">
        <h3>Total User</h3>
        <p id="numOfUser">1</p>
    </div>

    <div class="totalCategories">
        <h3>Total Categories</h3>
        <p id="numOfCategory">0</p>
    </div>

    <div class="notifications">
        <h3>Total Notifications</h3>
        <p id="numOfNotification">0</p>
    </div>

</section>
    <script src="https://kit.fontawesome.com/4f9d824da5.js" crossorigin="anonymous"></script>

     <script>
        function fetchTotalUsers() {
            <?php
                $db_host = 'localhost';
                $db_user = 'root';
                $db_pass = '';
                $db_name = 'signup';

                $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
                if ($mysqli->connect_errno) {
                    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
                    exit();
                }

                $sql = "SELECT COUNT(*) as total FROM `signup`";
                $result = $mysqli->query($sql);
                $row = $result->fetch_assoc();
                $totalUsers = $row['total'];

                echo "document.getElementById('numOfUser').textContent = " . $totalUsers . ";";
                $mysqli->close();
            ?>
        }

        fetchTotalUsers();

        function fetchTotalCategories() {
            <?php
                $db_host = 'localhost';
                $db_user = 'root';
                $db_pass = '';
                $db_name = 'categories';

                $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
                if ($mysqli->connect_errno) {
                    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
                    exit();
                }

                $sql = "SELECT COUNT(*) as total FROM `categorylists`";
                $result = $mysqli->query($sql);
                $row = $result->fetch_assoc();
                $totalCategory = $row['total'];

                echo "document.getElementById('numOfCategory').textContent = " . $totalCategory . ";";
                $mysqli->close();
            ?>
        }

        fetchTotalCategories();

        function fetchTotalPost(){
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

            $sql = "SELECT COUNT(*) as total FROM `blog`";
            $result = $mysqli->query($sql);
            $row = $result->fetch_assoc();
            $totalCategory = $row['total'];

            echo "document.getElementById('numOfPost').textContent = " . $totalCategory . ";";
            $mysqli->close();
            ?>
        }
        fetchTotalPost();
    </script>
</body>
</html>