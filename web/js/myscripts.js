// responsive nav bar function
function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
      x.className += " responsive";
    } else {
      x.className = "topnav";
    }
  }

// shopping cart functions
function cartAction(action, product_code) {
  var queryString = "";
  if (action != "") {
      switch (action) {
      case "add":
          queryString = 'action=' + action + '&code=' + product_code
                  + '&quantity=' + $("#qty_" + product_code).val();
          break;
      case "remove":
          queryString = 'action=' + action + '&code=' + product_code;
          break;
      case "empty":
          queryString = 'action=' + action;
          break;
      }
  }
  jQuery.ajax({
      url : "cart-action.php",
      data : queryString,
      type : "POST",
      success : function(data) {
          $("#cart-item").html(data);
          if (action == "add") {
              $("#add_" + product_code + " img").attr("src",
                      "images/icon-check.png");
              $("#add_" + product_code).attr("onclick", "");
          }
      },
      error : function() {
      }
  });
}