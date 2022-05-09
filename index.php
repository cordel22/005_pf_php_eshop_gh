<?php
session_start();




$banana = array(
  "id" => 1,
  "img" => "&#127820",
  "name" => "banana",
  "price" => "71"
);

$apple = array(
  "id" => 2,
  "img" => "&#127823",
  "name" => "apple",
  "price" => "39"
);

$watermelon = array(
  "id" => 3,
  "img" => "&#127817",
  "name" => "watermelon",
  "price" => "27"
);

$pear = array(
  "id" => 4,
  "img" => "&#127824",
  "name" => "pear",
  "price" => "17"
);

$catalog = array($banana, $apple, $watermelon, $pear);



function getBy($att, $value, $array)
{
  foreach ($array as $key => $val) {

    if ($val[$att] === $value) {
      return $key;
    }
  }
  return null;
}

if (isset($_GET["action"])) {

  if ($_GET["action"] == "add" && !empty($_GET["id"])) {
    addToCart($_GET["id"]);
    header("Location: /");
  }

  if ($_GET["action"] == "remove" && !empty($_GET["id"])) {
    removeFromCart($_GET["id"]);
    header("Location: /");
  }

  if ($_GET["action"] == "delete" && !empty($_GET["id"])) {
    deleteFromCart($_GET["id"]);
    header("Location: /");
  }
}

function addToCart($productId)
{
  if (!array_key_exists($productId, $_SESSION["cart"])) {
    $_SESSION["cart"][$productId]["quantity"] = 1;
  } else {
    $_SESSION["cart"][$productId]["quantity"]++;
  }
}

function removeFromCart($productId)
{
  if (array_key_exists($productId, $_SESSION["cart"])) {
    if ($_SESSION["cart"][$productId]["quantity"] <= 1) {
      unset($_SESSION["cart"][$productId]);
    } else {
      $_SESSION["cart"][$productId]["quantity"]--;
    }
  }
}

function deleteFromCart($productId)
{
  unset($_SESSION["cart"][$productId]);
}




?>

<html>

<head>
  <title>Apple Store</title>
  <style>
    .catalog-item {
      width: 200px;
      background-color: beige;
      height: 300px;
      margin: 5px;
    }

    .catalog-img {
      font-size: 30px;
    }

    .catalog-buy-button,
    .cart-button {
      margin: 5px;
      padding: 5px;
      border: 1px solid yellow;
      background-color: yellowgreen;
      text-align: center;
    }

    #catalog-items {
      display: flex;
    }

    a.catalog-buy-button {
      display: block;
    }

    .cart-item {
      justify-content: space-between;
      display: flex;
      margin: 5px;
      border: 1px solid yellowgreen;
      padding: 5px;
    }

    .cart-quantity {
      margin: 10px;
    }

    .cart-price {
      margin: 10px;

    }

    .cart-control {
      display: flex;
    }


    #cart-total-price {
      font-weight: bold;
    }
  </style>
</head>

<body>

  <section>
    <h2>Shopping Cart</h2>
    <?php
    $totalPrice = 0;
    foreach ($_SESSION["cart"] as $key => $value) {
      $item = $catalog[getBy("id", $key, $catalog)];
      $totalPrice =  $totalPrice + ($value["quantity"] * $item["price"]);
      echo '
<div class="cart-item">
<div class="cart-img">
' . $item["img"] . '
</div>
<h3>
' . $item["name"] . '
</h3>
<div class="cart-control">
<div class="cart-price">
' . $item["price"] . '
</div>
<div class="cart-quantity">
' . $value["quantity"] . '
</div>
<div class="cart-quantity">
' . $value["quantity"] * $item["price"] . '
</div>
<a href="/?action=add&id=' . $item["id"] . '" class="cart-button">
+
</a>
<a href="/?action=remove&id=' . $item["id"] . '" class="cart-button">
-
</a>
<a href="/?action=delete&id=' . $item["id"] . '" class="cart-button">
Remove
</a>
</div>
</div>';
    }
    echo '<div id="cart-total-price">
    And the Total Price is : 
    ' . $totalPrice . '
    </div>';

    ?>
  </section>

  <section id="catalog-items">

    <?php

    /*    //  ti nefunguje flexbox, preco?
        foreach ($catalog as $item) {
      echo '<div class="catalog-item">
    <div class="catalog-img">
    
      ' . $item["img"] . '
    </div>
    <h3>
    ' . $item["name"] . '
    </h3>
    <div>
      ' . $item["price"] . '
    </div>
    <div class="catalog-buy-button">
      Buy
    </div>
  <div>';
    } */

    foreach ($catalog as $item) {
      echo '
<div class="catalog-item">
<div class="catalog-img">
' . $item["img"] . '
</div>
<h3>
' . $item["name"] . '
</h3>
<div>
' . $item["price"] . '
</div>
<a href="/?action=add&id=' . $item["id"] . '" class="catalog-buy-button">
Buy
</a>
</div>';
    }

    ?>

  </section>

</body>

</html>