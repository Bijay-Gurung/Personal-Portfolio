<?php
/*form Validate*/
$name=$email=$password="";
$nameErr=$emailErr=$passwordErr="";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(empty($_POST["userName"])){
        $nameErr = "Name is Required";
    }
    else{
        $name = test_input($_POST["userName"]);
        if(!preg_match("/^[a-zA-Z-' ]*$/", $name)){
            $nameErr = "Only letters and whitespace allowed";
        }
    }

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

$name=$email=$password="";

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
$db_name = 'signup';

$conn = new mysqli($db_host,$db_user,$db_pass,$db_name);
if($conn->connect_error){
    die("Connection failed: ".$conn->connect_error);
}
if($_SERVER['REQUEST_METHOD']==='POST'){
    $name = $_POST['userName'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "INSERT INTO signup(name,email,password) values ('$name','$email','$password')";

    if($conn->query($sql)===TRUE){
        $result= "Data stored Successfully";
    }
    else{
        $result = "Error: ".$sql."<br>".$conn->error;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="signup.css" rel="stylesheet">
    <title>Signup</title>
</head>
<body>
    <div class="signup">
        <h1>Signup Form</h1>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label name="Username"><i class="fa-solid fa-user"></i></label>
            <input type="text" id="userName"  name="userName" placeholder="User Name: " value="<?php echo $name; ?>">
            <span class="error">*<?php echo $nameErr; ?></span>
            <br>
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
            <span class="success"><?php echo $result?></span>
        </form>
    </div>
    <script src="https://kit.fontawesome.com/4f9d824da5.js" crossorigin="anonymous"></script>
</body>
</html>