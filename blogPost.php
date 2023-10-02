<?php
/* Database connection */
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'blogs';

$db = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$status = $statusMsg = ''; 
if(isset($_POST["submit"])) {
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';
    $image = isset($_POST['images']) ? $_POST['images'] : '';
     
    $status = 'error'; 
    if(!empty($_FILES["images"]["name"])) { 
        // Get file info 
        $fileName = basename($_FILES["images"]["name"]); 
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
         
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg','gif'); 
        if(in_array($fileType, $allowTypes)) { 
            $image = $_FILES['images']['tmp_name']; 
            $imgContent = addslashes(file_get_contents($image)); 
         
            // Prepare and execute the SQL statement using prepared statements
            $insert = $db->query("INSERT INTO blog (title, category, content, images, created, updated_at) VALUES ('$title','$category','$content','$imgContent',NOW(),NOW())");
                        
            if($insert) { 
                $status = 'success'; 
                $statusMsg = "File uploaded successfully."; 
            } else { 
                $statusMsg = "File upload failed, please try again."; 
            }  
            $db->close();
        } else { 
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
        } 
    } else { 
        $statusMsg = 'Please select an image file to upload.'; 
    } 
} 
 
// Display status message 
echo $statusMsg;
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
    <h1>Blog Post</h1>
    <div class="postSection">
        <form method="POST" enctype="multipart/form-data">
            <input type="text" id="title" placeholder="title" name="title" required>
            <select id="categories" name="category" required>
                <?php
                // Retrieve and populate categories from your database
                $db_host = 'localhost';
                $db_user = 'root';
                $db_pass = '';
                $db_name = 'categories';

                $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
                if ($mysqli->connect_errno) {
                    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
                    exit();
                }
                $sql = "SELECT * FROM `categorylists`";
                $result = $mysqli->query($sql);
                
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
            <textarea rows="6" column="50" name="content" required></textarea>
            <input type="file" id="myfile" name="images">
            <button type="submit" name="submit">Add Post</button>
        </form>
    </div>
</section>
<script src="https://kit.fontawesome.com/4f9d824da5.js" crossorigin="anonymous"></script>
</body>
</html>
