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
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/* Database connection */
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'signup';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();

// When form submitted, check and create user session.
if (isset($_POST['email'])) {
    $email = test_input($_POST['email']);
    $password = test_input($_POST['password']);

    // Retrieve the hashed password from the database based on the provided email
    $query = "SELECT email, password FROM signup WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($storedEmail, $storedPassword);
    $stmt->fetch();
    $stmt->close();

    if (password_verify($password, $storedPassword) && $email === $storedEmail) {
        // Passwords match and email is correct, user is authenticated
        $_SESSION['email'] = $email;
        header("Location: admin.php");
        exit();
    } else {
        // Invalid email or password
        $insertResult = "Invalid email or password, try again!";
    }
} else {
    $emailErr = "";
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
