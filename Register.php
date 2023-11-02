<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="Register.css">
    <style>
        .error {
            color: red;}
        #submit-button {
            background-color: green;
            color: white;}
        #submit-button:disabled {
            background-color: #aba8a8;
            color: #ffffff;}
        .username-exists {
            color: red;}
    </style>
    <script>
        function checkFields() {
            const emailInput = document.getElementById("email");
            const usernameInput = document.getElementById("username");
            const passwordInput = document.getElementById("password");
            const dobInput = document.getElementById("dob");
            const termsInput = document.getElementById("terms");
            const submitButton = document.getElementById("submit-button");
            const isFieldsFilled = emailInput.value && usernameInput.value && passwordInput.value && dobInput.value && termsInput.checked;
            submitButton.disabled = !isFieldsFilled;
            if (isFieldsFilled) {
                submitButton.style.backgroundColor = "green";
            } else {
                submitButton.style.backgroundColor = "#aba8a8";
            } }
        function checkAge() {
            const dobInput = document.getElementById("dob");
            const dob = new Date(dobInput.value);
            const now = new Date();
            let age = now.getFullYear() - dob.getFullYear();
            if (now.getMonth() < dob.getMonth() || (now.getMonth() === dob.getMonth() && now.getDate() < dob.getDate())) {
                age--;}
            const errorText = document.getElementById("error-text");
            const submitButton = document.getElementById("submit-button");
            if (age < 18) {
                dobInput.classList.add("error");
                submitButton.disabled = true;
                submitButton.style.backgroundColor = "#aba8a8";
            } else {
                dobInput.classList.remove("error");
                checkFields();}}
    </script>
</head>
<body>
<h2>Registration Form</h2>
<form method="post" action="">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required placeholder="Example@example.com" onchange="checkFields()">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required onchange="checkFields()">
    <p id="username-exists" class="username-exists" style="display: none; font-size: small; margin-top: -1%">Username already exists</p>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required onchange="checkFields()">
    <label for="dob">Date of Birth:</label>
    <input type="date" id="dob" name="dob" required onchange="checkAge()">
    <label for="terms">
        <input type="checkbox" id="terms" name="terms" required onchange="checkFields()">
        I agree to the terms and conditions
    </label>
    <input type="submit" id="submit-button" value="Register" disabled>
    <p style="text-align: center; font-size: small;">Already have an account? <a href="Login.php">Login here</a></p>
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hostName = "localhost";
    $userName = "root";
    $password = "";
    $databaseName = "registered_users";
    $tableName = "users";
    $connection = mysqli_connect($hostName, $userName, $password, $databaseName);
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);}
    if (isset($_POST["email"]) && isset($_POST["username"]) && isset($_POST["password"])) {
        $email = $_POST["email"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $checkUserQuery = "SELECT * FROM $tableName WHERE username = '$username'";
        $checkUserQueryResult = mysqli_query($connection, $checkUserQuery);
        if (mysqli_num_rows($checkUserQueryResult) > 0) {
            echo '<script>document.getElementById("username-exists").style.display = "block";</script>';
        } else {
            $query = "INSERT INTO $tableName (email, username, password) VALUES ('$email', '$username', '$password')";
            $result = mysqli_query($connection, $query);
            if($result) {
                sleep(2);
                header("Location: Login.php");
                exit();
            } else {
                echo "Error: " . $query . "<br>" . $connection->error;
            }}}}
?>
</body>
</html>