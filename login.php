<?php
/*form Validate*/
$name=$email=$password="";
$nameErr=$emailErr=$passwordErr="";
$insertResult = "";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(empty($_POST["email"])){
        $emailErr= "Email is Required";
    }
    else{
        $email = test_input($_POST["email"]);
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $emailErr="Invalid Email Format";
        }
    }

    if(empty($_POST["password"])){
        $passwordErr = "password is required";
    }
    else{
        $password = test_input($_POST["password"]);
        if(strlen($password) < 8 || !preg_match("/[a-zA-z]/",$password) || !preg_match("/\d/",$password)){
            $passwordErr = "password must be at least 8 character long and contain letters and numbers";
        }
    }
}
$email=$password="";

function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/*database connection*/
$db_host= 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'login';

$conn = new mysqli($db_host,$db_user,$db_pass,$db_name);
if($conn->connect_error){
    die("Connection failed: ".$conn->connect_error);
}
if($_SERVER['REQUEST_METHOD']==='POST'){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "INSERT INTO login(email,password) values ('$email','$password')";

    if($conn->query($sql)===TRUE){
        $insertResult= "Data stored Successfully";
    }
    else{
        $insertResult = "Error: ".$sql."<br>".$conn->error;
    }
}

$sql = "SELECT * FROM login";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $users = $result->fetch_all(MYSQLI_ASSOC);
    
    foreach ($users as $user) {
        if ($user['email'] == $email && $user['password'] == $password) {
            header("location: admin.php");
            exit(); 
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
    <link href="login.css" rel="stylesheet">
    <title>Signup</title>
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