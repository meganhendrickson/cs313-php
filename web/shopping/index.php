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

require_once("cart-action.php"); //cart actions
require_once("product.php"); //product array

$product = new Product();
$productArray = $product->getAllProduct();
?>
<main>
    <h1>Fabulous Tees</h1>
    <a class="cart-action" href="view-cart.php">View Cart</a>
    <div id="product-grid">
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
        <?php
            }
        }
        ?>
    </div>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php' ?>