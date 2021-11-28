<?php

include 'config.php';
session_start();


error_reporting(0);

if (isset($_SESSION['email'])) {
    header("Location: index.php");
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM clients WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['email'] = $row['email'];
        header("Location: index.php");
    } else {
        echo "<script>alert('email or Password is Wrong.')</script>";
    }
}
//remember me cookies
if (!empty($_POST["remember"])) {
    setcookie("email", $_POST["email"], time() + 43200);
    setcookie("password", $_POST["password"], time() + 43200);
} else {
    setcookie("email", "");
    setcookie("password", "");
}
?>