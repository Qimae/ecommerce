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
    </style>


</head>

<body>

    <div class="sidebar">
        <center><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGwAAABsCAYAAACPZlfNAAAE4klEQVR4nO2d4W3rOgyFzwgZQSN0g3qEbFBvcLtBtcG9G0QbNBtEG7QbOBskG/j9sA34pXUi26RIK/yAAxRI0/KQkSzLkgIYhmEYhmEYhmEYhlEcDsArgA8ABwCnXg2A9kbN6PVD/57X/m8YTDgAbwA+AVzwsyhLdUFXxDdYAVfjAPzB762GS03/Px27u4IYWlKuIk3ps4/FmOANeVvTnFZnhRuxh85C/Va4PVMONoFDN3KTLsRcnfCE17gP0I72cuvSeygeB+AL8gmn0hcKbm17bLtV3WttFV2adPAX8onl1gdZtoQ5QD6ZuXQgypkIOzxXsTZdtB3KGlzM1df6FOblGVvWZluaFWtDRfsH+SRpk1+TUE72kE+OVlXL08qDQ5k3xVS6QNmMyDOPCFOlZuToIZ+MrcgvyjAhDtYVzpF413iCfBIGXQFEAEd0n2Tf/xz716TjG3SanWUitIwKA9JGYVX/u9LxthB6ct0sDJayUG5B3A7yhWsWxL2KmiDoNarNwzwkW9cLoY8XQR/ZWlmdwUzOT6WknyzXsqOQuVCgpyOjJwDdBVvq0+jM13zehUwFTlM9QcBXiy6nbDRCpipOUz2VgK8WjIMPJ2ToymXoF6RmRByHmVrITOQwM0FkiD9FNYeZEkeHtxTlUWpW3nOYmcAzxJ+iC7URJ2TkWQrWgvg6VgkaCZRGHiDVJbYgHgl7QSOR0sgDIkP8qfKURoKgEfL+/Q6ST88DpZEoaKRF2TfOgyKlmShsJlCamSAI+GIrWCNspkW5k7+DSJfBSZtp0Z2bwYWGc0FaSkPSRgbVlKZ6agW+ii1Yi3KWCDxNwVqUsQiHtWBnBWZu9Ynly9y0XLPG+l7gZZKowNCUDujOP3zEK3RvNowJHpKJCgw90gXdMuhPdEcwfPQ/n7CN9f8xsRZJBAWGSte/1GKk4BUYKl0+sRZJVAoMla4qsRZJOAWGSpdLrEUymvZYlSaWlWGST2NLV0gvQzq1AmNjRfzccflIx9H7pOMfq76T98U4YVMR3bJm6rnEd3SzDJLeHKGn/3HObOSKrmXsuAyN2PX/K/e1+sxpKudmCI88hbplKFwun6ybIVwGA9+g7faW8oI8XaXjNsI5Wgzcwc9kB95pOfYNfQDfaJG1a1gJ16Ug2/EPZ+LA61yBr6AGrefzVoMnnaVmhvI8yDpv6DStLGaOmYKIjbWuAYqji6rcQRNQYb1vsS/diQnB3dMFOobwqbxg/dPrLCPDKRzWzwxspWgUxbpCwcmkHuu7iAt0jxRr0KwL8XnDnoZqRuAvZKajpqD8douYN/T7ONBNmjbQMRipQLcJ5ApdH0QA9AdeHiDT3zvQr1+sMsY/Cw9aozkL58Cz0NRniH0VAfSmW/B9Te8b+M4uDgzxshDAk4Bx8f4gbYn2La/9e7nX14cFsYmxQ97H7g1+LtMeNCzXbjLGQ7qxIScB+ZKkRYEgb6IEyCfRijUTD/lkcssT5UoNFcpcPXyF4vustTjIrwGkVITCGQwOPLbd2ob1kk+Fg74l0yk6QsEjEkn20Lnp/VZnCD4p1kgNnYU7Q/ezOnH20LG16QhrUbNw6BZwnpG3Nb3jya9RFDh03VIA7ejy2v/NGlYkVhy6m1WPLuGx12/3eN+j10P/ngpWIMMwDMMwDMMwDMMoj/8A0XnGvlztbH4AAAAASUVORK5CYII=" /></center>
        <a class="active" href="reports.php">Reports</a>
        <a href="orders.php">Orders</a>
        <a href="clients.php">Clients</a>
        <a href="add_products.php">Add Products</a>
        <a href="new_user.php">New User</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="content">
        <div class="header">
            <h1>Dashboard</h1>
            <center><?php echo "<h3> Welcome back " . $_SESSION['agent'] . "</h3>"; ?></center>
        </div>
        <br>
        <?php
        include 'config.php';

        $sql = "SELECT * FROM orders";
        $result = mysqli_query($conn, $sql);
        $total_orders = mysqli_num_rows($result);
        ?>

        <div class="row">
            <div class="column">
                <div class="card">
                    <h3>Total Customers</h3>
                    <p><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAA70lEQVRIieWU3RGDIBCEvxIoxRLoIHSiHcROtCPtQDuIHSQPHjNMPE6IeUp2Zl+OY5efBfgHBGAAJuApnKR2uyLsgSURzXGR3ir0BcLvbEvFuw/EI7szcX9BPNJbBmtm0iarc8JOark7UREqt24dZdAMRmOCU/qd0T9qBvMXDSbNoDYdZ2mrMniw5zxeciu1KgPriGo5awajMWGV8V44ko909pK1mG7YD8ejvwc1piiragzxiIbjbs0Vpc0DekQjnPQUfxVwjF9MULqbBrhzTNLpZ5czKWGxeITHTkp65r5WPEVgj136TmapZdPyO3gBpmH4wRECwbAAAAAASUVORK5CYII=" />
                        <?php echo " $total_clients" ?></p>
                </div>
            </div>

            <div class="column">
                <div class="card">
                    <h3>Total Orders</h3>
                    <p>
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAlUlEQVRIiWNgGAWDCfynIj5Paws+4PPJBKiiBST5HwIKiNGrAFX0ngwLDkD1JhBSeIFYhUhAgAERRAKEFMO8uoEECwKgei5Q3TVQsACqvoFYF21gIC8FGRBrQQIZhk8g1nAY+ECqq0gFC6AWrKeVBQoMpAURWSCAAZEvaGIBXUADA/Y0jkucZIArGKgWPA0MNPbBCAYAEwl/Ey8icrEAAAAASUVORK5CYII=" />
                        <?php echo " $total_orders" ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="footer">
            <p>Made by Kimae Ngowa</p>
            <p>Copyright © 2021 Tiurakh Tech.</p>
        </div>
    </div>

</body>


</html>