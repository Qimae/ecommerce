<?php
session_start();

?>
<div class="header_container">
	<div class="logo_container">
		<a href="index.php"><img src="images/sage logo.png"></a>
	</div>
	<span id="company"><b>PHP</b> <i>Spares</i></span>
	<ul class="menu_items">
		<li><a href="index.php"><i class="fas fa-home"></i>Home </a></li>
		<li><a href="aboutus.php"><i class="far fa-file-alt"></i>About Us </a></li>
		<li><a href="product.php"> Product & Services </a></li>
		<?php if (!isset($_SESSION['email'])){?>

			<li><a href="signup.php"> Register </a></li>
			<li><a href="login.php"> Login</a></li>
			<li><a href="contact.php"> Contact </a></li>

		<?php }else {?>
			<li><a href="account.php"> Account </a></li>
			<li><a href="contact.php"> Contact </a></li>
			<li><a href="logout.php"> Logout </a></li>
		<?php }?>


	</ul>


</div>