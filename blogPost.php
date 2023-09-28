<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="blogPost.css" rel="stylesheet">
    <title>Blog Post</title>
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

<section> 
    <h1>Blog Post</h1><!--Use Dom for this section-->
    <div class="postSection">
        <form method="POST">
            <input type="text" id="title" placeholder="title" name="title">
            <select id="categories">
            <?php
$db_host= 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'categories';

$mysqli = new mysqli($db_host,$db_user,$db_pass,$db_name);
if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
  }
  $sql = "SELECT * FROM `categorylists`";
  
  $result = $mysqli -> query($sql);
  
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          echo "<option>" . $row["Category"] . "</option>";
      }
  } else {
      echo "No results found.";
  }
  $result->free_result();
  
  $mysqli->close();
?>
            </select>
            <textarea rows="6" column="50"></textarea>
            <input type="checkbox" id="publish">
            <label for="publish">Publish</label><br>
            <label for="myfile">Add Thumbnail</label><br>
            <div class="thumbnail">
                <input type="file" id="myfile">
            </div>
            <button type="submit">Add Post</button>
        </form>
    </div>
</section>
    <script src="https://kit.fontawesome.com/4f9d824da5.js" crossorigin="anonymous"></script>
</body>
</html>