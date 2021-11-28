<?php

session_start();

if (!isset($_SESSION['agent'])) {
    header("Location: index.php");
}
include 'config.php';

$sql = "SELECT * FROM clients";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Clients | Customer Management system</title>
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

        }

        .header h1 {
            font-size: 20px;
        }

        * {
            box-sizing: border-box;
        }

        .row {
            margin-left: -5px;
            margin-right: -5px;
        }

        .column {
            float: left;
            width: 100%;
            padding: 16px;
            border-radius: 8px;
            background-color: #f1f1f1;
            color: black;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            margin-left: 10px;

        }

        .row::after {
            content: "";
            clear: both;
            display: table;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
        }



        th,
        td {
            text-align: left;
            padding: 16px;


        }

        tr:nth-child(even) {
            background-color: #f1f1f1;
        }

        @media screen and (max-width: 600px) {
            .column {
                width: 100%;
            }
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
        <a href="reports.php">Reports</a>
        <a href="orders.php">Orders</a>
        <a class="active" href="clients.php">Clients</a>
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
        <center>
            <div class="row">
                <div class="column">
                    <table>
                        <h4>Customers Registered</h4>

                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Country</th>

                        </tr>

                        <?php while ($client = $result->fetch_assoc()) : ?>
                            <tr>
                                <td><?php echo $client['name'] ?></td>
                                <td><?php echo $client['email'] ?></td>
                                <td><?php echo $client['number'] ?></td>
                                <td><?php echo $client['address'] ?></td>
                                <td><?php echo $client['country'] ?></td>
                            </tr>
                        <?php endwhile ?>
                    </table>
                </div>
            </div>
        </center>

        <div class="footer">
            <p>Made by Kimae Ngowa</p>
            <p>Copyright © 2021 Tiurakh Tech.</p>
        </div>
    </div>

</body>


</html>