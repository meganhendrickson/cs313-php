<?php
session_start();
require_once ("product.php");
$product = new Product();
$productArray = $product->getAllProduct();
if(!empty($_POST["action"])) {
switch($_POST["action"]) {
	case "add":
		if(!empty($_POST["quantity"])) {
		    $productByCode = $productArray[$_POST["code"]];
		    $itemArray = array($productByCode["code"]=>array('name'=>$productByCode["name"], 'code'=>$productByCode["code"], 'quantity'=>$_POST["quantity"], 'price'=>$productByCode["price"]));
			
			if(!empty($_SESSION["cart_item"])) {
			    $cartCodeArray = array_keys($_SESSION["cart_item"]);
			    if(in_array($productByCode["code"],$cartCodeArray)) {
					foreach($_SESSION["cart_item"] as $k => $v) {
							if($productByCode["code"] == $k) {
							    $_SESSION["cart_item"][$k]["quantity"] = $_SESSION["cart_item"][$k]["quantity"]+$_POST["quantity"];
							}
					}
				} else {
					$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
				}
			} else {
				$_SESSION["cart_item"] = $itemArray;
			}
		}
	break;
	case "remove":
		if(!empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $k => $v) {
					if($_POST["code"] == $k)
						unset($_SESSION["cart_item"][$k]);
					if(empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
			}
		}
	break;
	case "empty":
		unset($_SESSION["cart_item"]);
	break;		
}
}
?>