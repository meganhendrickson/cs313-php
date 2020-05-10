<?php
//include header
ob_start();
include $_SERVER['DOCUMENT_ROOT'] . '/common/header.php';
$buffer = ob_get_contents();
ob_end_clean();

//set page title
$title = "View Cart";
$buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);
echo $buffer;

require_once("cart-action.php");
require_once("product.php");

?>
<main>
  <h1>Your Shopping Cart</h1>
  <div id="shopping-cart">
    <div id="cart-item">
      <?php
      if (isset($_SESSION["cart_item"])) {
        $item_total > 0;
      ?>
        <table class="cart-table">
          <tbody>
            <tr>
              <th><strong>Name</strong></th>
              <th><strong>Code</strong></th>
              <th class="align-right"><strong>Quantity</strong></th>
              <th class="align-right"><strong>Price</strong></th>
              <th></th>
            </tr>
            <?php
            foreach ($_SESSION["cart_item"] as $item) {
            ?>
              <tr>
                <td><strong><?php echo $item["name"]; ?></strong></td>
                <td><?php echo $item["code"]; ?></td>
                <td align="right"><?php echo $item["quantity"]; ?></td>
                <td align="right"><?php echo "$" . $item["price"]; ?></td>
                <td align="center"><a onClick="cartAction('remove','<?php echo $item["code"]; ?>')" class="btnRemoveAction cart-action"><img src="images/icon-delete.png" /></a></td>
              </tr>
            <?php
              $item_total += ($item["price"] * $item["quantity"]);
            }
            ?>

            <tr>
              <td colspan="3" align=right><strong>Total:</strong></td>
              <td align=right><?php echo "$" . number_format($item_total, 2); ?></td>
              <td></td>
            </tr>
          </tbody>
        </table>
        <a id="btnEmpty" class="cart-action" onClick="cartAction('empty','');"><img src="images/icon-empty.png" />Empty Cart</a>
        <a id="btnCheckout" class="cart-action" onClick="index.php"><img src="images/add-to-cart.png" />Continue Shopping</a>
        <a id="btnCheckout" class="cart-action" onClick="checkout.php"><img src="images/check.png" />Checkout</a>
      <?php
      }
      else{
        ?>
        <p>Your shopping cart is empty.</p>
        <a id="btnCheckout" class="cart-action" onClick="index.php"><img src="images/add-to-cart.png" />Continue Shopping</a>
      <?php
      }
      ?>
    </div>
  </div>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php' ?>