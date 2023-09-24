<?php
/* Form Validate */
$email = $password = "";
$emailErr = $passwordErr = "";
$insertResult = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
        $emailErr = "Email is Required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid Email Format";
        }
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
        if (strlen($password) < 8 || !preg_match("/[a-zA-Z]/", $password) || !preg_match("/\d/", $password)) {
            $passwordErr = "Password must be at least 8 characters long and contain letters and numbers";
        }
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

session_start();

if (isset($_POST['save'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    /* Database connection */
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'signup';

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = mysqli_real_escape_string($conn, $email);

    // Query the database to check if the provided credentials match
    $sql = "SELECT * FROM signup WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            // Password is correct
            $_SESSION["ID"] = $row['ID'];
            $_SESSION["email"] = $row['email'];
            // Redirect to the home page after successful login
            header("location: admin.php");
            exit();
        }
        else {
            // Password is incorrect
            $passwordErr = "Invalid Password";
        }
    } 
    else {
        // Email not found in the database
        $emailErr = "Email not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="login.css" rel="stylesheet">
    <title>Login</title>
</head>
<body>
    <div class="signup">
        <h1>Login Form</h1>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label name="email"><i class="fa-solid fa-envelope"></i></label>
            <input type="email" id="email" name="email" placeholder="email: " value="<?php echo $email; ?>">
            <span class="error">*<?php echo $emailErr; ?></span>
            <br>
            <label name="password"><i class="fa-solid fa-lock"></i></label>
            <input type="password" id="password" name="password" placeholder="password: " value="<?php echo $password; ?>">
            <span class="error">*<?php echo $passwordErr; ?></span>
            <br>
            <input type="submit" id="submitBtn">
            <br>
            <span class="success"><?php echo $insertResult ?></span>
        </form>
    </div>
    <script src="https://kit.fontawesome.com/4f9d824da5.js" crossorigin="anonymous"></script>
</body>
</html>