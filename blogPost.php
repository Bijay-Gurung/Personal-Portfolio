<?php
/* Database connection */
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'blogs';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$insertResult = ""; // Initialize the variable to store the insertion result

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';

    // File Upload
    if (isset($_FILES["image"])) {
        $fileName = basename($_FILES["image"]["name"]);
        $fileType = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $fileType = strtolower($fileType);

        // Check File Size (400KB)
        if ($_FILES["image"]["size"] > 400000) {
            $insertResult = "Upload Failed. File Size is too Large!";
        } elseif (!in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            $insertResult = "Upload Failed. Invalid File Type!";
        } else {
            $imageData = addslashes(file_get_contents($_FILES['image']['tmp_name']));
            $sql = "INSERT INTO blog(title, category, content, image) VALUES ('$title', '$category', '$content', '$imageData')";

            if ($conn->query($sql) === TRUE) {
                $insertResult = "Data stored Successfully";
            } else {
                $insertResult = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    } else {
        // If no file uploaded, insert data without image
        $sql = "INSERT INTO blog(title, category, content) VALUES ('$title', '$category', '$content')";

        if ($conn->query($sql) === TRUE) {
            $insertResult = "Data stored Successfully";
        } else {
            $insertResult = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

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
            <select id="categories" name="category">
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
            <textarea rows="6" column="50" name="content"></textarea>
            <input type="checkbox" id="publish">
            <label for="publish">Publish</label><br>
            <label for="myfile">Add Thumbnail</label><br>
            <div class="thumbnail">
                <input type="file" id="myfile" name="image">
            </div>
            <button type="submit">Add Post</button>
        </form>
    </div>
</section>
    <script src="https://kit.fontawesome.com/4f9d824da5.js" crossorigin="anonymous"></script>
</body>
</html>