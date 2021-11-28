<?php

session_start();

if (!isset($_SESSION['agent'])) {
    header("Location: index.php");
}
include 'config.php';

$sql = "SELECT * FROM clients";
$result = mysqli_query($conn, $sql);
$total_clients = mysqli_num_rows($result);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reports | Customer Management System</title>
    <style>
        body {
            background-color: white;
        }

        .sidebar {
            margin: 3px;
            padding: 0;
            width: 200px;
            position: fixed;
            height: 100%;
            overflow: auto;
            border: 2px solid;
            border-radius: 8px;
            background-color: blue;



        }

        .sidebar a {
            display: block;
            color: white;
            padding: 16px;
            text-decoration: none;


        }

        .sidebar a.active {
            color: red;
        }

        div.content {
            margin-left: 200px;
            padding: 1px 16px;
            height: 1000px;
        }

        .sidebar a:hover:not(.active) {
            color: red;
        }

        @media screen and (max-width: 700px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .sidebar a {
                float: left;

            }

            div.content {
                margin-left: 0;
            }
        }

        @media screen and (max-width: 400px) {
            .sidebar a {
                text-align: center;
                float: none;
            }
        }

        .header {
            padding: 2px;
            text-align: left;
            color: black;
            margin-left: 0;

        }

        .header h1 {
            font-size: 20px;
        }

        * {
            box-sizing: border-box;
        }


        .column {
            float: left;
            width: 50%;
            padding: 0 10px;
        }

        .row {
            margin: 0 -5px;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        @media screen and (max-width: 600px) {
            .column {
                width: 100%;
                display: block;
                margin-bottom: 20px;
            }
        }

        .card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            padding: 16px;
            text-align: center;
            background-color: #f1f1f1;
            border-radius: 10px;
        }

        .footer {
            text-align: center;
            margin-top: 400px;
        }

        .container {
            width: 400px;
            min-height: 400px;
            background-color: rgba(255, 255, 255, 0.713);
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, .3);
            padding: 40px 30px;
            width: 100%;
        }

        .container .login-text {
            color: #111;
            font-weight: 500;
            font-size: 1.1rem;
            text-align: center;
            margin-bottom: 20px;
            display: block;
            text-transform: capitalize;
        }

        .container .login-email .input-group {
            width: 100%;
            height: 50px;
            margin-bottom: 25px;
        }

        .container .login-email .input-group input {
            width: 100%;
            height: 100%;
            border: 2px solid #e7e7e7;
            padding: 15px 20px;
            font-size: 1rem;
            border-radius: 30px;
            background: transparent;
            outline: none;
            transition: .3s;
        }

        .container .login-email .input-group input:focus,
        .container .login-email .input-group input:valid {
            border-color: #a29bfe;
        }

        .container .login-email .input-group .btn {
            display: block;
            width: 30%;
            padding: 15px 20px;
            text-align: center;
            border: none;
            background: #a29bfe;
            outline: none;
            border-radius: 30px;
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.63);
            cursor: pointer;
            transition: .3s;
        }

        .container .login-email .input-group .btn:hover {
            transform: translateY(-5px);
            background: #6c5ce7;
        }

        @media (max-width: 430px) {
            .container {
                width: 300px;
            }
        }
    </style>


</head>

<body>

    <div class="sidebar">
        <center><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGwAAABsCAYAAACPZlfNAAAE4klEQVR4nO2d4W3rOgyFzwgZQSN0g3qEbFBvcLtBtcG9G0QbNBtEG7QbOBskG/j9sA34pXUi26RIK/yAAxRI0/KQkSzLkgIYhmEYhmEYhmEYhlEcDsArgA8ABwCnXg2A9kbN6PVD/57X/m8YTDgAbwA+AVzwsyhLdUFXxDdYAVfjAPzB762GS03/Px27u4IYWlKuIk3ps4/FmOANeVvTnFZnhRuxh85C/Va4PVMONoFDN3KTLsRcnfCE17gP0I72cuvSeygeB+AL8gmn0hcKbm17bLtV3WttFV2adPAX8onl1gdZtoQ5QD6ZuXQgypkIOzxXsTZdtB3KGlzM1df6FOblGVvWZluaFWtDRfsH+SRpk1+TUE72kE+OVlXL08qDQ5k3xVS6QNmMyDOPCFOlZuToIZ+MrcgvyjAhDtYVzpF413iCfBIGXQFEAEd0n2Tf/xz716TjG3SanWUitIwKA9JGYVX/u9LxthB6ct0sDJayUG5B3A7yhWsWxL2KmiDoNarNwzwkW9cLoY8XQR/ZWlmdwUzOT6WknyzXsqOQuVCgpyOjJwDdBVvq0+jM13zehUwFTlM9QcBXiy6nbDRCpipOUz2VgK8WjIMPJ2ToymXoF6RmRByHmVrITOQwM0FkiD9FNYeZEkeHtxTlUWpW3nOYmcAzxJ+iC7URJ2TkWQrWgvg6VgkaCZRGHiDVJbYgHgl7QSOR0sgDIkP8qfKURoKgEfL+/Q6ST88DpZEoaKRF2TfOgyKlmShsJlCamSAI+GIrWCNspkW5k7+DSJfBSZtp0Z2bwYWGc0FaSkPSRgbVlKZ6agW+ii1Yi3KWCDxNwVqUsQiHtWBnBWZu9Ynly9y0XLPG+l7gZZKowNCUDujOP3zEK3RvNowJHpKJCgw90gXdMuhPdEcwfPQ/n7CN9f8xsRZJBAWGSte/1GKk4BUYKl0+sRZJVAoMla4qsRZJOAWGSpdLrEUymvZYlSaWlWGST2NLV0gvQzq1AmNjRfzccflIx9H7pOMfq76T98U4YVMR3bJm6rnEd3SzDJLeHKGn/3HObOSKrmXsuAyN2PX/K/e1+sxpKudmCI88hbplKFwun6ybIVwGA9+g7faW8oI8XaXjNsI5Wgzcwc9kB95pOfYNfQDfaJG1a1gJ16Ug2/EPZ+LA61yBr6AGrefzVoMnnaVmhvI8yDpv6DStLGaOmYKIjbWuAYqji6rcQRNQYb1vsS/diQnB3dMFOobwqbxg/dPrLCPDKRzWzwxspWgUxbpCwcmkHuu7iAt0jxRr0KwL8XnDnoZqRuAvZKajpqD8douYN/T7ONBNmjbQMRipQLcJ5ApdH0QA9AdeHiDT3zvQr1+sMsY/Cw9aozkL58Cz0NRniH0VAfSmW/B9Te8b+M4uDgzxshDAk4Bx8f4gbYn2La/9e7nX14cFsYmxQ97H7g1+LtMeNCzXbjLGQ7qxIScB+ZKkRYEgb6IEyCfRijUTD/lkcssT5UoNFcpcPXyF4vustTjIrwGkVITCGQwOPLbd2ob1kk+Fg74l0yk6QsEjEkn20Lnp/VZnCD4p1kgNnYU7Q/ezOnH20LG16QhrUbNw6BZwnpG3Nb3jya9RFDh03VIA7ejy2v/NGlYkVhy6m1WPLuGx12/3eN+j10P/ngpWIMMwDMMwDMMwDMMoj/8A0XnGvlztbH4AAAAASUVORK5CYII=" /></center>
        <a href="reports.php">Reports</a>
        <a href="orders.php">Orders</a>
        <a href="clients.php">Clients</a>
        <a class="active" href="add_products.php">Add Products</a>

        <a href="signup.php">New User</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="content">
        <div class="header">
            <h1>Dashboard</h1>
            <center><?php echo "<h3> Welcome back " . $_SESSION['agent'] . "</h3>"; ?></center>
        </div><br>
        <?php

        include 'config.php';

        error_reporting(0);

        session_start();



        if (isset($_POST['submit'])) {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $agent = $_POST['agent'];
            $password = md5($_POST['password']);
            $cpassword = md5($_POST['cpassword']);

            if ($password == $cpassword) {
                $sql = "SELECT * FROM user WHERE email='$email'";
                $result = mysqli_query($conn, $sql);
                if (!$result->num_rows > 0) {
                    $sql = "INSERT INTO user (username, email, agent, password)
					VALUES ('$username', '$email', '$agent','$password')";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        header("location:dashboard.php");
                        echo "<script>alert('Wow! User Registration Completed.')</script>";
                        $username = "";
                        $email = "";
                        $agent = "";
                        $_POST['password'] = "";
                        $_POST['cpassword'] = "";
                    } else {
                        echo "<script>alert('Something is Wrong ')</script>";
                    }
                } else {
                    echo "<script>alert('Email Already Exists.')</script>";
                }
            } else {
                echo "<script>alert('Password Not Matched.')</script>";
            }
        }

        ?>
        <div class="container">
            <form action="" method="POST" class="login-email">
                <div class="input-group">
                    <input type="text" placeholder="Company Name" name="username" value="<?php echo $username; ?>" required>
                </div>
                <div class="input-group">
                    <input type="agent" placeholder="Agent Name" name="agent" value="<?php echo $agent; ?>" required>
                </div>
                <div class="input-group">
                    <input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
                </div>
                <div class="input-group">
                    <input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
                </div>
                <div class="input-group">
                    <input type="password" placeholder="Confirm Password" name="cpassword" value="<?php echo $_POST['cpassword']; ?>" required>
                </div>
                <div class="input-group">
                    <center><button name="submit" class="btn">Register</button></center>
                </div>
            </form>
        </div>

        <div class="footer">
            <p>Made by Kimae Ngowa</p>
            <p>Copyright © 2021 Tiurakh Tech.</p>
        </div>
    </div>

</body>


</html>