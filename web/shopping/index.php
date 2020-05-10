<?php
    ob_start();
    include $_SERVER['DOCUMENT_ROOT'].'/common/header.php';
    $buffer=ob_get_contents();
    ob_end_clean();

    $title = "Shopping Cart Assignment";
    $buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);

    echo $buffer;
?>
<link rel="stylesheet" type="text/css" href="main.css">
<main>
    <h1>PHP Shopping Cart Demo</h1>
<?php
require_once ("product.php");
$product = new Product();
$productArray = $product->getAllProduct();
?>
<div id="product-grid">
    <div class="txt-heading">Products</div>
<?php
if (! empty($productArray)) {
    foreach ($productArray as $k => $v) {
        ?>
		<div class="product-item">
        <form id="frmCart" method="post" action="index.php?action=add&code+<?php echo $productArray[$k]["code"];?>">
            <div class="product-image">
                <img src="<?php echo $productArray[$k]["image"]; ?>">
            </div>
            <div>
                <div class="product-info">
                    <strong><?php echo $productArray[$k]["name"]; ?></strong>
                </div>
                <div class="product-info product-price"><?php echo "$".$productArray[$k]["price"]; ?></div>
                <div class="cart-action">
                    <input type="text" class="product-quantity" name="quantity" value="1" size="2" />
                    <input type="image" src="images/add-to-cart.png" class="addbtn" value="add to cart" alt="add" />
                </div>
            </div>
        </form>
    </div>
	<?php
    }
}
?>
</div>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'].'/common/footer.php'?>