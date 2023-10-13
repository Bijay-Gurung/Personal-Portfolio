<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="comments.css" rel="stylesheet">
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
<h1>Comments</h1>
<?php
//Database connection settings for blog_db
$blog_db_host = 'localhost';
$blog_db_username = 'root';
$blog_db_password = '';
$blog_db_name = 'blogs';

//Database connection setting for comment_db
$comment_db_host = 'localhost';
$comment_db_username = 'root';
$comment_db_password = '';
$comment_db_name = 'commentsection';

//Creating connection to both database
$blog_conn = new mysqli($blog_db_host,$blog_db_username,$blog_db_password,$blog_db_name);

if($blog_conn->connect_error){
    die("Connection failed: " . $blog_conn->connect_error);
}

$comment_conn = new mysqli($comment_db_host,$comment_db_username,$comment_db_password,$comment_db_name);

if($comment_conn->connect_error){
    die("Connection failed: " . $comment_conn->connect_error);
}

//Query to retrieve data from both tables using a JOIN
$query = "SELECT blog.*, comments.*
FROM blogs.blog
LEFT JOIN commentsection.comments ON blogs.blog.commentID = commentsection.comments.ID
UNION
SELECT blog.*, comments.*
FROM blogs.blog
RIGHT JOIN commentsection.comments ON blogs.blog.commentID = commentsection.comments.ID";


$result = $comment_conn->query($query);

if($result === false){
    die("Query failed: ". $comment_conn->error);
}

//Displaying the comment on comment admin panel
if ($result->num_rows > 0) {
    echo "<div class=comments>";
    echo "<table id='comment'>";
    echo "<tr><th>Title</th><th>Name</th><th>Comment</th></tr>";
    while($row = $result->fetch_assoc()){
        echo "<tr><td>" .$row['title'] . "</td><td>" . $row['name'] . "</td><td>" . $row['comments'] . "</td><tr>";
    }
    echo "</div>";
    echo "</table>";
}
else{
    echo "no result found";
}
//Close Database Connections
$blog_conn->close();
$comment_conn->close();
?>
</section>
    <script src="https://kit.fontawesome.com/4f9d824da5.js" crossorigin="anonymous"></script>
</body>
</html>