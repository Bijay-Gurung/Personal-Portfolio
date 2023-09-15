<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
</head>
<body>
    <div class="signup">
        <h1>Signup Form</h1>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label name="Username"></label>
            <input type="text" id="userName"  name="userName" placeholder="User Name: " value="<?php echo $name; ?>">
            <span class="error">*<?php echo $nameErr; ?></span>
            <br>
            <label name="email"></label>
            <input type="email" id="email" name="email" placeholder="email: " value="<?php echo $email; ?>">
            <span class="error">*<?php echo $emailErr; ?></span>
            <br>
            <label name="password"></label>
            <input type="password" id="password" name="password" placeholder="password: " value="<?php echo $password; ?>">
            <span class="error">*<?php echo $passwordErr; ?></span>
            <br>
            <input type="submit" id="submitBtn">
        </form>
    </div>
</body>
</html>

<?php
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
}
?>