<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="categories.css" rel="stylesheet">
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
<h1>Categories</h1>

<div class="categories">
    <form method="POST">
        <input type="text" id="category" placeholder="Add new Category" name="category">
        <button onclick="addCategory()" id="add">Add</button>
    </form>
</div>

<div class="listOfCategories">
    <ol>
        <li>Travelling</li>
    </ol>
</div>
</section>
    <script src="https://kit.fontawesome.com/4f9d824da5.js" crossorigin="anonymous"></script>
    <script src="categories.js"></script>
</body>
</html>