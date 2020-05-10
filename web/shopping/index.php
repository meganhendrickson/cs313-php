<?php
session_start();

//include header
ob_start();
include $_SERVER['DOCUMENT_ROOT'] . '/common/header.php';
$buffer = ob_get_contents();
ob_end_clean();

//set page title
$title = "Shopping Cart Assignment";
$buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);
echo $buffer;
?>
<main>
    <h1>Fabulous Tees</h1>
    <?php
    require_once("product.php");
    $product = new Product();
    $productArray = $product->getAllProduct();
    ?>
    <div id="product-grid">
        <div class="txt-heading">Products</div>
        <?php
        if (!empty($productArray)) {
            foreach ($productArray as $k => $v) {
        ?>
                <div class="product-item">
                    <form id="frmCart">
                        <div class="product-image">
                            <img src="<?php echo $productArray[$k]["image"]; ?>">
                        </div>
                        <div>
                            <div class="product-info">
                                <strong><?php echo $productArray[$k]["name"]; ?></strong>
                            </div>
                            <div class="product-info product-price"><?php echo "$" . $productArray[$k]["price"]; ?></div>
                            <div class="product-info">
                                <input type="text" id="qty_<?php echo $productArray[$k]["code"]; ?>" class="quantityInput" name="quantity" value="1" size="2" />
                                <button type="button" id="add_<?php echo $productArray[$k]["code"]; ?>" class="btnAddAction cart-action" onClick="cartAction('add','<?php echo $productArray[$k]["code"]; ?>')">
                                    <img src="images/add-to-cart.png" />
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="clear-float"></div>
    <div id="shopping-cart">
        <div class="txt-heading">
            Shopping Cart <a id="btnEmpty" class="cart-action"
                onClick="cartAction('empty','');"><img
                src="images/icon-empty.png" /> Empty Cart</a>
        </div>
        <div id="cart-item">
        <?php 
		require_once "ajax-action.php";
        ?>
        </div>
    </div>
        <?php
            }
        }
        ?>
    </div>
    <a href="view-cart.php">View Cart</a>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php' ?>