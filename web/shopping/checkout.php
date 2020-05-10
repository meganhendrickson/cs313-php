<?php
//include header
ob_start();
include $_SERVER['DOCUMENT_ROOT'] . '/common/header.php';
$buffer = ob_get_contents();
ob_end_clean();

//set page title
$title = "Checkout";
$buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);
echo $buffer;

require_once ("cart-action.php");
require_once ("product.php");

?>
<main>
<h1>Checkout Demo</h1>
  <div id="shopping-cart">
      <div id="cart-item">
      <?php
      if (isset($_SESSION["cart_item"])) {
        $item_total = 0;
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
      <?php
      }
      ?>
    </div>
  </div>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php' ?>