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

$status = $statusMsg = ''; 
if(isset($_POST["submit"])) {
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';
     
    $status = 'error'; 
    if(!empty($_FILES["image"]["name"])) { 
        // Get file info 
        $fileName = basename($_FILES["image"]["name"]); 
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
         
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg','gif'); 
        if(in_array($fileType, $allowTypes)) { 
            $image = $_FILES['image']['tmp_name']; 
            $imgContent = file_get_contents($image); 
         
            // Prepare and execute the SQL statement using prepared statements
            $stmt = $conn->prepare("INSERT INTO blog (title, category, content, image) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssb", $title, $category, $content, $imgContent);
            
            if($stmt->execute()) { 
                $status = 'success'; 
                $statusMsg = "File uploaded successfully."; 
            } else { 
                $statusMsg = "File upload failed, please try again."; 
            }  
            $stmt->close();
        } else { 
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
        } 
    } else { 
        $statusMsg = 'Please select an image file to upload.'; 
    } 
} 
 
// Display status message 
echo $statusMsg; 

// Close the database connection
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
    <!-- Your sidebar content here -->
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
            <input type="file" id="myfile" name="image">
            <button type="submit" name="submit">Add Post</button>
        </form>
    </div>
</section>
<script src="https://kit.fontawesome.com/4f9d824da5.js" crossorigin="anonymous"></script>
</body>
</html>
