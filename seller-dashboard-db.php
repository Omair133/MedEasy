<?php
include_once('connection.php');
$action=$_REQUEST['action'];

switch($action){

	case 'add': 

		$pname=$_REQUEST['pname'];
		$sku=$_REQUEST['sku'];
		$price=$_REQUEST['price'];
		$stock=$_REQUEST['stock'];
		$image=$_REQUEST['image'];

		$sql="SELECT pid FROM products WHERE sku='$sku' AND del_flag=0";
		$query  = $pdoconn->prepare($sql);
	        $query->execute();
	        $arr_trade = $query->fetchAll(PDO::FETCH_ASSOC);
	        if(count($arr_trade)>0)
	        {
	            echo "Product Already Exists";
	            break;
	        }

	        $sql="INSERT INTO products(pname, sku, price, stock, image) VALUE('$pname','$sku','$price','$stock','$image')";
	        $query  = $pdoconn->prepare($sql);
	        $query->execute();
	        echo "Product Added";

	        break;

	case 'show':

		$html="<table>
					<tr><th>SL NO</th>
						<th>Image</th>
						<th>Product Name</th>
						<th>SKU ID</th>
						<th>Price</th>
						<th>Stock</th>
						<th>Edit</th>
						<th>Delete</th>
					</tr>";

		$sql="SELECT * FROM products WHERE del_flag=0";
		$query  = $pdoconn->prepare($sql);
        $query->execute();
        $arr_trade = $query->fetchAll(PDO::FETCH_ASSOC);
        $slno=1;
        if($arr_trade){
        	foreach($arr_trade as $val){
        		$image=$val['image'];
        		$pname=$val['pname'];
        		$price=$val['price'];
        		$stock=$val['stock'];
        		$sku=$val['SKU'];
        		$pid=$val['pid'];

        		$html.="<tr>
        					<td>".$slno."</td>
        					<td><img style=\"width:50px; height:50px\" src=\"".$image."\"></td>
        					<td>".$pname."</td>
        					<td>".$sku."</td>
        					<td>".$price."</td>
        					<td>".$stock."</td>
        					<td> <img style='cursor:pointer' src='images/edit.png' onclick='retrieve_data(".$pid.")'></td>
        					<td> <img style='cursor:pointer' src='images/delete.png' onclick='delete_data(".$pid.")'></td>
        				</tr>";
        		$slno++;

        	}
        $html.="</table>";
        echo $html;
        }
        else{
        	echo "No Product Found";
        }

        break;

    case 'retrieve':

    	$pid=$_REQUEST['pid'];

    	$sql="SELECT pname, price, stock, image FROM products WHERE pid='$pid' AND del_flag=0";
    	$query  = $pdoconn->prepare($sql);
        $query->execute();
        $arr_trade = $query->fetchAll(PDO::FETCH_ASSOC); 
        foreach($arr_trade as $val){
        	$pname=$val['pname'];
        	$price=$val['price'];
        	$stock=$val['stock'];
        	$image=$val['image'];
		}
		$return_arr=array('pname'=>$pname, 'price'=>$price, 'stock'=>$stock, 'image'=>$image);
		echo json_encode($return_arr);

		break;

	case 'edit':

		$pname=$_REQUEST['pname'];
		$pid=$_REQUEST['pid'];
		$stock=$_REQUEST['stock'];
		$price=$_REQUEST['price'];
		$image=$_REQUEST['image'];

		$sql="UPDATE products SET pname='$pname', stock='$stock', price='$price', image='$image' WHERE pid='$pid'";
		$query  = $pdoconn->prepare($sql);
	    $query->execute();
	    if($query)
	        echo 'EDITED SUCCESSFULLY';
	    else
	        echo 'ERROR WHILE EDITING...';
	    break;

	case 'delete':

		$pid=$_REQUEST['pid'];
		$sql="UPDATE products SET del_flag=1 WHERE pid='$pid'";
		$query  = $pdoconn->prepare($sql);
	    $query->execute();
	    if($query)
	        echo 'DELETED SUCCESSFULLY';
	    else
	        echo 'ERROR WHILE DELETING...';
	    break;


}
?>