<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="Login.css">
</head>
<body>
<h2>Login Form</h2>
<form method="post" action="">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username">
    <label for="password">Password:</label>
    <input type="password" id="password" name="password">
    <div class="terms-checkbox">
        <input type="checkbox" id="terms" name="terms" required>
        <label for="terms">I agree to the terms and conditions</label>
    </div>
    <p id="incorrect_data" class="incorrect_data" style="display: none; text-align: center; color: red; font-size: small">Invalid username or password!</p>
    <input type="submit" value="Login">
    <p style="text-align: center; font-size: small;">Don't have an account? <a href="Register.php">Register here</a></p>
</form>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $hostName = "localhost";
    $userName = "root";
    $password = "";
    $databaseName = "registered_users";
    $tableName = "users";
    $connection = mysqli_connect($hostName, $userName, $password, $databaseName);
    if(!$connection){
        die("Connection failed: " . mysqli_connect_error());
    }
    if(isset($_POST["username"]) && isset($_POST["password"])){
        $username = $_POST["username"];
        $password = $_POST["password"];
        $query = "SELECT * FROM $tableName WHERE username = '$username' AND password = '$password'";
        $result = mysqli_query($connection, $query);
        if(mysqli_num_rows($result) > 0){
            header("Location: Home.html");
            exit();
        } else {
            echo '<script>document.getElementById("incorrect_data").style.display = "block";</script>';
        }
    }
}
?>
</body>
</html>