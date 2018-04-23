//items.php (Page 1)
<?php 
	require_once 'itemsfunction.php';
	// array of images
	$photos =array("<img src = 'kakashi.jpg' width='300' height='300'>",
				 "<img src = 'allmight.jpg' width='300' height='300'>",
				 "<img src = 'simondominic.jpg' width='300' height='300'>",
				 "<img src = 'mlazi.jpg' width='300' height='300'>",
				 "<img src = 'Pokemon.jpg' width='300' height='300'>",
				 "<img src = 'dragon.jpg' width='300' height='300'>",
				 "<img src = 'ich.jpg' width='300' height='300'>",
				 "<img src = 'spider.jpg' width='300' height='300'>",
				 "<img src = 'loco.jpg' width='300' height='300'>",
				 "<img src = 'beads.jpg' width='300' height='300'>",
				 
				 
				 
				 
				 
				 
				 
				 
				 );
//array of items to be sold ($is,$product_name,$price,$description)
	$items = [
		'1' => new Item(0,'Naruto Shippuden', 4.5,'T-Shirt','Watercolor T-Shirt of Kakashi Hatake, the coolest, most kickass ninja of the Hidden-leaf village. ',$photos[0]),
		'2' => new Item(1,'My Hero Academia', 12.70, 'T-Shirt','Black All Might T-Shirt. A true hero is one who overcomes lifes misfortunes',$photos[1]),		
		'3' => new Item(3,'Won & Only - EP',12.00,'Digital EP','Korean born rapper Simon Dominic has returned with an amazing EP',$photos[2]),
		'4' => new Item(4,'Mlazi Milano', 19.00, 'Digital Album','South African born rapper Okmalumkoolkat he is so cryptic and smart about his choice of words, bringing a balance between his style, flow and depth of his lines. Perhaps the best album of 2017.',$photos[3]),
		'5' => new Item(5,'Pokemon', 5.00, 'Key Chain','Size: 1 inch Diameter Design,  2.5 inch Chain and Ring',$photos[4]),
		'6' => new Item(6,'Dragonball Super', 5.00, 'Key Chain','Size: 1 inch Diameter Design,  2.5 inch Chain and Ring',$photos[5]),
		'7' => new Item(7,'Icha Icha Paradise', 20.00, 'Paperback book' ,'Best selling novel from Jiraya sensei. The novel is about a passionate love between a man and a woman',$photos[6]),
		'8' => new Item(8,'Spiderman: Clone Saga Epic 1', 22.00, 'Paperback Comic book','Spider-Mans clone is back  and the real Spidey is beside himself Peter thought his clone was long dead, but where has Ben Reilly been for the last five years? ',$photos[7]),
		'9' => new Item(9,'Bleached', 19.00, 'Digital Album','“Bleached” is the 1st album recorded by South Korean rapper Loco - 로꼬',$photos[8]),
		'10' => new Item(10,'Kimoyo Beads', 12.70, 'Accessory Item','Wakandas precious Kimoyo beads are at your hand, allowing access to Black Panthers secret communication field with this exquisite gunmetal bracelet by RockLove. A blue prime bead holds a lifetime of knowledge and illuminates in the dark.',$photos[9]),
		];
?>

//itemsfunction.php(Page 2)

<?php

class Item {
	var $id;
	var $name;
	var $price;
	var $category;
	var $description;
	var $photo;

	
	function __construct($id,$name,$price,$category,$description,$photo) 
	{
		$this->id = $id;
		$this->name = $name;
		$this->price = $price;
		
		$this->category = $category;
		$this->description = $description;
		$this->image = $photo;
	}
	
	function get_id()
	{
		return $this->id;
	}
	function get_name() 
	{
		return $this->name;
	}
	function get_photo() 
	{
		return $this->image;
	}
	function get_price() 
	{
		return $this->price;
	}
	function get_category() 
	{
		return $this->category;
	}
	function get_description() 
	{
		return $this->description;
	}
		
	function takes_currrency($number)
	{
		$number = get_price();
		setlocale(LC_MONETARY,"en_US");
		echo money_format($number);
	}

	
	
	function get_select($max_items) 
	{
		$id = $this->get_name();
		$html = <<<EOT
			<label for="$id">$this->description</label>
			<select id="$id" name="$id">
EOT;

		for ($count = 0; $count <= $max_items; $count++)
		{
			$html .= <<<EOT
				<option value="$count">$count</option>
EOT;
		}
		$html .= '</select>';
		return $html;
	}
}
//function get_name() {return $this->description . 'Item';}
?>

// user.php (Page 3)


<?php
	session_start();
	require 'items.php';

	require_once 'itemsfunction.php';
		
?>


<!DOCTYPE html>
<html>
	<head>
		<title>Product Page</title>
		<link rel = "stylesheet" type = "text/css" href = "default.css">
	</head>
	<body align = "center">
	
	
	<?php 
	
	//initialize cart
	if(!isset($_SESSION['shoppingCart']))
	{
		$_SESSION['shoppingCart'] = array();
	}
	echo"<a href = 'user.php?view_cart=1'>View Cart</a></br>";

	//Empty cart
	if($_GET['empty_cart'])
	{
		$_SESSION['shoppingCart'] = array();
	}
		
	//add to cart
	 if(isset($_POST['addCart']))
	{
		$item_id = $_POST['item_id'];
		//Is item valid
		if(!isset($items[$item_id]))
		{
			echo "Invalid Item!<br/>";
		}
		else if(isset($_SESSION['shoppingCart'][$item_id]))
		{
			echo "Item is already in cart!<br/>";
		}
		else
		{
		$count = count($_SESSION['shoppingCart']);
		$_SESSION['shoppingCart'][$count]['item_id'] = $_POST['item_id'];
		$_SESSION['shoppingCart'][$count]['quantity'] = $_POST['quantity'];
		
		}
	}
	
	//update Cart
	if((isset($_POST['updateCart'])))
	{
		$quanties = $_POST['quantity'];
		foreach($quanties as $id=>$quantity)
		{
			if(!isset($products[$id])) 
			{
			 echo "Invalid product!<br/>";
			break;
			}
		}
		$_SESSION['shoppingCart'][$id]['quantity'] = $quantity;
	}
	
		
	if(isset($_GET['view_product']))
	{
		echo "<h2 style = 'text-align:center;' >Hidden Leaf Mart</h2>
			<h3 style = 'text-align:center;'>You Selected:</h3>";
		echo $_GET['view_product'];
		$item_id = $_GET['view_product'];
		
		echo "<span; align = left><a href='http://localhost/test/user.php'>Home</a> </span></br>";
		
		
		$item = $items[$item_id];
		echo $item->get_photo()."</br>" ;
		echo $item->get_name()."</br>" ;
		$total = sprintf($item->get_price());
		echo '$'.$total."</br>" ;
		echo $item->get_category()."</br>" ;
		echo $item->get_description()."</br>" ;
		
		echo"<span>
			<form action = 'user.php?view_product=$item_id' method = 'post'>
			<select name = 'quantity'>
			<option value = '1'>1</option>
			<option value = '2'>2</option>
			<option value = '3'>3</option>
			<option value = '4'>4</option>
			<option value = '5'>5</option>
			</select>
			<input type = 'hidden' name = 'item_id' value = '$item_id'/>
			<input type = 'submit' name = 'addCart' value = 'Add to cart'/>
			</form>";	
			
	}
	else if(isset($_GET['view_cart']))
	{
		echo "<a href = 'user.php'>Hidden-Leaf</a></br>";
		echo"Your Cart: <br/>";
		echo "<a href = 'user.php?empty_cart=1'>Empty Cart</a></br></br>";
		
		if(empty($_SESSION['shoppingCart']))
		{
		echo "You have no items in your cart. </br>";		
		}	
		else
		{
		echo "<form action='user.php?view_cart=1' method='post'>
		<table style='width:500px;' cellspacing='0'>
		<tr>
		<th style='border-bottom:1px solid #000000;'>Name</th>
					<th style='border-bottom:1px solid #000000;'>Price</th>
					<th style='border-bottom:1px solid #000000;'>Category</th>
					<th style='border-bottom:1px solid #000000;'>Quantity</th>
		</tr>";	
			
		 foreach($_SESSION['shoppingCart']as $id => $product)
		 {
			 $product_id = $product['item_id'];
			 $quantity = $product['quantity'];
			 
			 $item = $items[$product_id];
			 echo "<tr>
						<td style='border-bottom:1px solid #000000;'><a href='./index.php?view_product=$id'>" . 
							$item->get_name() . "</a></td>
						<td style='border-bottom:1px solid #000000;'>$" . $item->get_price()  . "</td> 
						<td style='border-bottom:1px solid #000000;'>" . $item->get_category(). "</td>
						<td style='border-bottom:1px solid #000000;'>
							<input type='text' name='quantity[$product_id]' value='" . $product['quantity'] . "' /></td>
					</tr>";
		
		 }
	
		}
		echo "</table>
			<input type='submit' name='update_cart' value='Update' />
			</form>
			<p>
			<a href='user.php?checkout=1'>Checkout</a>
			</p>";
		
	}
	else if(isset($_GET['checkout']))
	{
		echo "<a href = 'user.php'>Hidden-Leaf</a></br>";
		echo"Checkout: <br/>";
		if(empty($_SESSION['shoppingCart'])) 
		{
		echo "Your cart is empty.<br />";
		}
		else
		{
			echo "<form action='user.php?checkout=1' method='post'>
		<table style='width:500px;' cellspacing='0'>
				<tr>
					<th style='border-bottom:1px solid #000000;'>Name</th>
					<th style='border-bottom:1px solid #000000;'>Item Price</th>
					<th style='border-bottom:1px solid #000000;'>Quantity</th>
					<th style='border-bottom:1px solid #000000;'>Cost</th>
				</tr>";
				
				$total_price =0;
				foreach($_SESSION['shoppingCart'] as $id => $product) 
				{
					$product_id = $product['item_id'];
					$item = $items[$product_id];
					$total = $item->get_price(); 
					$total_price += ($total * $product['quantity']);
					echo "<tr>
						<td style='border-bottom:1px solid #000000;'><a href='user.php?view_product=$id'>" . 
							$item->get_name() . "</a></td>
						<td style='border-bottom:1px solid #000000;'>$" . $item->get_price(). "</td> 
						<td style='border-bottom:1px solid #000000;'>" . $product['quantity'] . "</td>
						<td style='border-bottom:1px solid #000000;'>$" . ($total * $product['quantity']) . "</td>
					</tr>";
				}
				$taxrate = 8.25;
				echo "</table><br/>";
			echo "Tax rate: $".$taxrate."<br/>";
			echo "<p>Total price: $" . ($total_price+$taxrate) . "</p>";
			
		}
	}	
	else
	{
		echo "<h2 style = 'text-align:center;' >Welcome to Hidden Leaf Mart</h2>
			<h3 style = 'text-align:center;'>Our Products:</h3>";
				foreach ($items as $id => $item) 
				{
				 $item->get_id();

				 
				 echo $item-> get_photo();
				 echo '<br />';
				 echo "<a href = './user.php?view_product=$id'>". $item ->get_name()."</a>";
				 echo '<br />';
				 echo '<br />';
				 echo '<br />';
					
				}
	}
	
	
	
	?>
		
		
	</body>
</html>



