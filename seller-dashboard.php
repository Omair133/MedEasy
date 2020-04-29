<?php
	include_once('connection.php');
	session_start();
	$sellername=$_SESSION['sellername'];

	if(!$_SESSION["sellername"])
	{	
    //Do not show protected data, redirect to login...
    	header('Location: seller-login.php');
	}
?>

<html>
	<head>
		<script src="jquery.min.js"></script>
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
								<?php echo '<li  class="profile"><a href="#">'.$sellername.'</a>
								<div class="subprofile">
									<a href="#">Profile</a>
									<a href="logout.php">Logout</a>
								</div>
								</li>' ?>
								<li><a href="#">Contact Us</a></li>
								<li><a href="#">Visit Store</a></li>
								<li><a href="#">Home</a></li>
							</ul>
						</div>		
					</div>
				</div>
			</div>
		</header>
		<section>
			<p style="font-style:italic; text-align:right; margin:10px">You are now logged in as <?php echo $sellername ?></p>
			<div class="product">
				<h3>Enter Item Details</h3>
				<form id="product-details">
					<input type="text" id="pname" placeholder="Enter Product Name"><br>
					<input type="text" id="sku" placeholder="SKU ID"><br>
					<input type="number" id="price" placeholder="Enter Product Price"><br>
					<input type="number" id="stock" placeholder="Enter Stock Available"><br>
					<input type="text" id="image" placeholder="Enter The Image Link"><br>
					<input type="button" value="Add Product" onclick="save_product()"><br>
				</form>
				<div id="message"></div>
			</div>



			<div class="editData">
				<label>Product Name</label>
				<input type="text" id="editpname" name="editpname">
				<label>Price</label>
				<input type="number" id="editprice" name="editprice">
				<label>Stock</label>
				<input type="number" id="editstock" name="editstock">
				<label>Image Link</label>
				<input type="text" id="editimage" name="editimage">
				<input type="hidden" id="editpid" name="editpid">
				<button type="button" value="Edit Data" onclick="edit_data()">Edit Data</button>
			</div>
			<div id="edit-message"></div>
			<div id="product-list"></div>

		</section>
		<footer>
			
		</footer>
	</body>
</html>







<script>
	function save_product(){
		var pname=$("#pname").val();
		var sku=$("#sku").val();
		var price=$("#price").val();
		var stock=$("#stock").val();
		var image=$("#image").val();
		console.log(image);
		if(pname=="" || price=="" || stock=="" || image=="" || sku==""){
			$('#message').html("All Fields Are Mandatory");
			$("#product-details")[0].reset();
		}
		else{
			$.ajax({
				url:'seller-dashboard-db.php',
				type:'POST',
				dataType:'html',
				data:{
					'pname':pname,
					'price':price,
					'stock':stock,
					'image':image,
					'sku':sku,
					'action':'add'
				},
				success:function(data){
					$('#message').html(data);
					$("#product-details")[0].reset();
					show_data();
				}
			});
		}
	}

	function show_data(){
		$.ajax({
			url:'seller-dashboard-db.php',
			type:'POST',
			dataType:'html',
			data:{
				'action':'show'
			},
			success:function(data){
				$("#product-list").html(data);
			}
		});
	}

	function retrieve_data(pid){
		$('.editData').css({
			'transform':'scale(1,1)'
		});
		$('.editData > input').each(function(){
				$(this).removeAttr('value');
			});

		$.ajax({
			url:'seller-dashboard-db.php',
			type:'POST',
			dataType:'JSON',
			data:{
				'action':'retrieve',
				'pid':pid
			},
			success:function(data){
				//console.log(data);
				var pname=data.pname;
				var price=data.price;
				var stock=data.stock;
				var image=data.image;

				$('#editpname').attr({
					'value':pname
				});

				$('#editprice').attr({
					'value':price
				});
				$('#editstock').attr({
					'value':stock
				});
				$('#editimage').attr({
					'value':image
				});
				$('#editpid').attr({
					'value':pid
				})
			}
		});
	}
	function edit_data(){
		$('.editData').css({
			'transform':'scale(1,0)'
		});

		var pid=$('#editpid').val();
		var pname=$('#editpname').val();
		var price=$('#editprice').val();
		var stock=$('#editstock').val();
		var image=$('#editimage').val();
		console.log(pid, pname, price, stock, image);

		$.ajax({
			url:'seller-dashboard-db.php',
			type:'POST',
			dataType:'html',
			data:{
				'action':'edit',
				'pname':pname,
				'price':price,
				'stock':stock,
				'image':image,
				'pid':pid
			},
			success:function(data){
				$('#edit-message').html(data);
				/*$(".editData")[0].reset();*/
				$('.editData > input').each(function(){
				$(this).removeAttr('value');
			});
				show_data();
			}
		});
	}

	function delete_data(pid){
		$.ajax({
			url:'seller-dashboard-db.php',
			dataType:'html',
			type:'POST',
			data:{
				'action':'delete',
				'pid':pid
			},
			success:function(data){
				show_data();
				alert(data);
			}
		});
	}

	$(document).ready(function(){
		show_data();
	});


</script>
<script src="jquery.min.js"></script>