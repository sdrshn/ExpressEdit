<?php # Script 8.5 - cart.php

/* 
 *	This is the shopping cart page.
 *	This page has two modes:
 *	- add a product to the cart
 *	- update the cart
 *	The page shows the cart as a form for updating quantities.
 *	The cart is an object of WidgetShoppingCart type,
 *	which is stored in a session.
 */
class checkoutcart extends page_master {
protected $tablename='displaycart';
 
function pre_render_data(){
    $this->outertitle='Your Shopping Cart';
    }
function render_body_main(){  
    echo '<h1>View Your Shopping Cart</h1>';
    // Create the shopping cart:
    if (isset($_SESSION['cart'])) {
	    $cart = unserialize($_SESSION['cart']);
	   }
    else {
	    $cart = new cart();
	   }
    // This page will either add to or update the 
    // shopping cart, based upon the value of $_REQUEST['do'];
    if (isset($_REQUEST['do']) && ($_REQUEST['do'] == 'add') ) { // Add new item.
	    if (isset($_GET['sw_id'])) { // Check for a product ID.
		   // Typecast to an integer:
		  $sw_id = (int) $_GET['sw_id'];
	  // If it's a positive integer,
		  // get the item information:
		  if ($sw_id > 0) {
		   // Define and execute the query:
			 $q = "SELECT name, color, size, default_price, price FROM general_widgets LEFT JOIN specific_widgets USING (gw_id) LEFT JOIN colors USING (color_id) LEFT JOIN sizes USING (size_id) WHERE sw_id=$sw_id";
			  $r=$this->mysqlinst->query($q,__line__);		  
			 	if ($this->affected_rows()==1){
			     $row=$this->mysqlinst->fetch_assoc($r,__line__); 
				$price = (empty($row['price'])) ? $row['default_price'] : $row['price'];
		      // Add to the cart:
				$cart->add_item($sw_id, array('name' => $row['name'], 'color' => $row['color'], 'size' => $row['size'], 'price' => $price));
	    
			    } // End of mysqli_num_rows() IF.
    
		    } // End of ($sw_id > 0) IF.
			    
	    } // End of isset($_GET['sw_id']) IF.
	    
    } elseif (isset($_REQUEST['do']) && ($_REQUEST['do'] == 'update')) {
    
	    // Change any quantities...
	    // $k is the product ID.
	    // $v is the new quantity.
	    foreach ($_POST['qty'] as $k => $v) {
	    
		    // Must be integers!
		    $pid = (int) $k;
		    $qty = (int) $v;
		    
		    // Update the cart:
		    $cart->update_item($pid, $qty);
    
	    } // End of FOREACH.
	    
	    // Print a message:
	    echo '<p>Your shopping cart has been updated.</p>';
	    
    } // End of $_REQUEST IF-ELSE.
	    
    // Show the shopping cart if it's not empty:
    if (!$cart->is_empty()) {
	    $cart->display_cart(Sys::Self);
    } else {
	    echo '<p>Your cart is currently empty.</p>';
    }

// Store the cart in the session:
$_SESSION['cart'] = serialize($cart);

// Include the footer file to complete the template:	
    }//			end fucntion main render
    
}//end class checkout
?>
