<?php

@include 'config.php';

if(isset($_POST['order_btn'])){

   $name = $_POST['name'];
   $number = $_POST['number'];
   $email = $_POST['email'];
   $method = $_POST['method'];
   $flat = $_POST['flat'];
   $street = $_POST['street'];
   $city = $_POST['city'];
   $state = $_POST['state'];
   $country = $_POST['country'];
   $pin_code = $_POST['pin_code'];

   $cart_query = mysqli_query($conn, "SELECT * FROM `cart`");
   $price_total = 0;
   if(mysqli_num_rows($cart_query) > 0){
      while($product_item = mysqli_fetch_assoc($cart_query)){
         $product_name[] = $product_item['name'] .' ('. $product_item['quantity'] .') ';
         $product_price = floatval($product_item['price']) * floatval($product_item['quantity']);
         $price_total += $product_price;
      };
   };

   $total_product = implode(', ',$product_name);
   $detail_query = mysqli_query($conn, "INSERT INTO `order`(name, number, email, method, flat, street, city, state, country, pin_code, total_products, total_price) VALUES('$name','$number','$email','$method','$flat','$street','$city','$state','$country','$pin_code','$total_product','$price_total')") or die('query failed');

   if($cart_query && $detail_query){
      echo "
      <div class='order-message-container'>
      <div class='message-container'>
         <h3>Gracias por su compra!</h3>
         <div class='order-detail'>
            <span>".$total_product."</span>
            <span class='total'> total : $".number_format($price_total, 2)." </span>
         </div>
         <div class='customer-details'>
            <p> Nombre : <span>".$name."</span> </p>
            <p> Número de teléfono : <span>".$number."</span> </p>
            <p> Correo : <span>".$email."</span> </p>
            <p> Dirección : <span>".$flat.", ".$street.", ".$city.", ".$state.", ".$country." - ".$pin_code."</span> </p>
            <p> Método de pago : <span>".$method."</span> </p>
            <p>(*Pagar cuando el producto llegue*)</p>
         </div>
            <a href='productos.php' class='btn'>Continuar comprando</a>
         </div>
      </div>
      ";
   }

   $empty_cart_query = mysqli_query($conn, "DELETE FROM `cart`");


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="shortcut icon" href="chef.png">
   <link rel="stylesheet" href="estilo.css">

</head>
<body>

<?php include 'header.php'; ?>

<div class="container">

<section class="checkout-form">

   <h1 class="heading">Completar el pedido</h1>

   <form action="" method="post">

   <div class="display-order">
      <?php
         $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
         $total = 0;
         $grand_total = 0;
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
               $total_price = floatval($fetch_cart['price']) * floatval($fetch_cart['quantity']);
               $grand_total += $total_price;
      ?>
      <span><?= $fetch_cart['name']; ?>(<?= $fetch_cart['quantity']; ?>)</span>
      <?php
         }
      }else{
         echo "<div class='display-order'><span>Tu carrito está vacio!</span></div>";
      }
      ?>
      <span class="grand-total"> Total a pagar : $<?= number_format($grand_total, 2); ?> </span>
   </div>

      <div class="flex">
         <div class="inputBox">
            <span>Nombre</span>
            <input type="text" placeholder="Ingresa tu nombre" name="name" required>
         </div>
         <div class="inputBox">
            <span>Número de teléfono</span>
            <input type="number" placeholder="Ingresa tu número" name="number" required>
         </div>
         <div class="inputBox">
            <span>Correo electrónico</span>
            <input type="email" placeholder="Ingresa tu correo" name="email" required>
         </div>
         <div class="inputBox">
            <span>método de pago</span>
            <select name="method">
               <option value="Efectivo" selected>Efectivo</option>
               <option value="Tarjeta de crédito">Tarjeta de crédito</option>
               <option value="Paypal">Paypal</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Dirección</span>
            <input type="text" placeholder="Ingresa tu dirección" name="flat" required>
         </div>
        
         <div class="inputBox">
            <span>Ciudad</span>
            <input type="text" placeholder="Ingresa tu Ciudad" name="city" required>
         </div>
         <div class="inputBox">
            <span>Provincia</span>
            <input type="text" placeholder="Ingresa tu provincia" name="state" required>
         </div>
         <div class="inputBox">
            <span>Código postal</span>
            <input type="text" placeholder="Código postal" name="pin_code" required>
         </div>
      </div>
      <input type="submit" value="Ordenar ahora" name="order_btn" class="btn">
   </form>

</section>

</div>

<script src="jscript.js"></script>
   
</body>
</html>
