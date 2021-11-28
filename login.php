<?php
include 'check.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <style>
        .container {
            padding: 8px;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.522);
            width: 50%;
            border-radius: 20px;
            height: max-content;
        }

        input[type=text],
        input[type=password] {
            width: 50%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
            text-align: center;
            border-radius: 10px;
        }

        button {
            text-align: center;
            padding: 12px 93px;
            background-color: red;
            color: white;
            border-radius: 10px;
            box-sizing: border-box;
            border: none;
            opacity: 0.6;
            transition: 0.3s;
        }

        button:hover {
            opacity: 1;
        }

        .log {
            text-align: center;
            padding: 30px;
        }

        .text {
            text-align: center;

        }

        p {
            float: right;
        }

        .cookies {
            float: left;
        }

        .image {
            background-repeat: no-repeat;
            position: relative;
            min-height: 100vh;
            background-size: cover;

        }
    </style>
</head>

<body class="image" style="background-image: url('bg 1.jpg');height: 500px;width: 100%;"><br>

    <center>
        <div class="container">
            <div class="text">
                <h1>Welcome Back!</h1>
            </div>
            <form action="" method="POST">
                <input type="text" name="email" placeholder="Email" value="<?php echo $email; ?>" required>
                <input type="password" name="password" placeholder="Password" value="<?php echo $_POST['password']; ?>" required>
                <div class="log">
                    <button name="submit">Login</button><br>
                    <p>Create account <a href="signup.php">here.</a></p>
                    <div class="cookies">
                        <p><input type="checkbox" id="check" name="remember">Remember Me</p>
                    </div><br>
                </div>

        </div>
        </form>
    </center>
</body>

</html>