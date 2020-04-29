<?php
include_once("connection.php");
session_start();
if(isset($_POST['login'])){
	if(empty($_POST['sellername']) || empty($_POST['sellerpassword'])){
		$message="All fields are mandatory";
	}
	else{
		if($_POST['sellername']=="admin" && $_POST['sellerpassword']=="admin"){
			$_SESSION['sellername']=$_POST['sellername'];
			header('location: seller-dashboard.php');
		}
		else{
			$message="Invalid Username or Password";
		}
	}
}

?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" href="css/bootstrap.min.css">
	</head>
	<body>
		<header>
			<div class="top-bar">
				<div class="row">
					<div class="col-lg-12">
						<div class="logo">
							<a href="#"><img src="images/logo.png"></a>
						</div>
					</div>
					<div class="col-lg-12 nav-bar">
						<div class="nav-bar-contents">
							<ul>
								<li><a href="#">Contact Us</a></li>
								<li><a href="#">Seller Login</a></li>
								<li><a href="#">Visit Store</a></li>
								<li><a href="#">Home</a></li>
							</ul>
						</div>		
					</div>
				</div>
			</div>
		</header>

		<section>
			<div class="banner">
				<div class="container">
					<div class="row">
						<div class="col-md-8">
							<div class="ban-text">
								<h1>Now <br>Online Pharmacy <br><span>Made Easy</span></h1>
							</div>
						</div>
						<div class="col-md-4">
							<div class="seller-login">
								<form method="post">
									<h4>Login as Seller!</h4>
									<input type="text" name="sellername" placeholder="Seller Name" autocomplete="off"><br>
									<input type="password" name="sellerpassword" placeholder="Enter Password"><br>
									<a href="seller-dashboard.php"><input type="submit" name="login" value="Submit"></a>
								</form>
								<?php
									if(isset($message)){
										echo '<p style="color:red; font-style:italic">'.$message.'</p>';
									}
								?>
							</div>	
						</div>
					</div>
				</div>
			</div>	
		</section>
		<footer>
			
		</footer>

	</body>
</html>